<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Membaca file "Daftar Arsip" yang formatnya seperti dokumen resmi:
 *
 *   Baris 1: DAFTAR ARSIP STATIS
 *   Baris 2: <NAMA INSTANSI>              <- ini yang kita ambil jadi Instansi
 *   Baris 3: TAHUN 1960 - 1999
 *   Baris 4: (kosong)
 *   Baris 5: No | Kode Klasifikasi | Uraian Informasi Arsip | Kurun Waktu | ...  <- header
 *   Baris 6+: data
 *
 * Hanya 4 kolom yang benar-benar dipakai sistem: No, Kode Klasifikasi,
 * Kurun Waktu (-> Tahun), dan Uraian Informasi Arsip. Kolom lain
 * (Jumlah, Tingkat Perkembangan, Klasifikasi Keamanan, dst) diabaikan.
 */
class ArsipImport implements ToCollection, WithMultipleSheets
{
    public string $instansi = '';

    /** @var array<int, array{nomor_arsip:string,kode_klasifikasi:string,tahun:string,uraian:string,instansi:string}> */
    public array $rows = [];

    /**
     * Alias header yang dikenali, supaya tahan terhadap variasi penulisan antar file.
     * Dicek sebagai kata/frasa utuh di dalam sel (bukan harus sama persis satu sel),
     * supaya varian seperti "No Definitif", "No. Definitif", atau "Tahun Arsip"
     * tetap terdeteksi. Alias yang lebih spesifik/panjang diletakkan lebih dulu
     * supaya dicoba duluan (mis. "no definitif" sebelum "no" polos).
     */
    protected array $headerAliases = [
        'nomor_arsip'      => ['nomor definitif', 'no definitif', 'nomor arsip', 'no arsip', 'nomor', 'no'],
        'kode_klasifikasi' => ['kode klasifikasi arsip', 'kode klasifikasi', 'kode'],
        'tahun'            => ['tahun arsip', 'kurun waktu', 'tahun'],
        'uraian'           => ['uraian informasi arsip', 'uraian arsip', 'uraian singkat', 'uraian'],
        'instansi'         => ['nama instansi', 'instansi opd', 'instansi', 'opd', 'unit kerja'],
    ];

    public function sheets(): array
    {
        // hanya proses sheet pertama, cukup untuk 1 daftar arsip per file
        return [0 => $this];
    }

    public function collection(Collection $sheetRows): void
    {
        $headerRowIndex = null;
        $columnMap = [];

        // 1) Cari baris header: baris yang punya sel mengandung "No"/"No Definitif"
        //    DAN sel mengandung "Kode Klasifikasi".
        foreach ($sheetRows as $i => $row) {
            $cells = $row->map(fn ($c) => $this->normalize($c))->toArray();

            $hasNo   = $this->rowContainsAny($cells, $this->headerAliases['nomor_arsip']);
            $hasKode = $this->rowContainsAny($cells, $this->headerAliases['kode_klasifikasi']);

            if ($hasNo && $hasKode) {
                $headerRowIndex = $i;

                foreach ($cells as $colIndex => $value) {
                    if ($value === '') {
                        continue;
                    }

                    foreach ($this->headerAliases as $field => $aliases) {
                        if (isset($columnMap[$field])) {
                            continue;
                        }

                        foreach ($aliases as $alias) {
                            if ($this->cellMatchesAlias($value, $alias)) {
                                $columnMap[$field] = $colIndex;
                                break;
                            }
                        }
                    }
                }
                break;
            }
        }

        // Format tidak dikenali -> biarkan $this->rows kosong, controller yang kasih pesan error.
        if ($headerRowIndex === null) {
            return;
        }

        // 2) Cari nama instansi di baris-baris sebelum header: baris yang cuma
        //    berisi satu sel teks dan bukan judul umum "DAFTAR ARSIP..." / "TAHUN ...".
        for ($i = 0; $i < $headerRowIndex; $i++) {
            $row = $sheetRows[$i] ?? collect();
            $filled = $row->filter(fn ($c) => trim((string) $c) !== '');

            if ($filled->count() === 1) {
                $text = trim((string) $filled->first());
                $upper = mb_strtoupper($text);

                if ($text !== '' && !str_starts_with($upper, 'DAFTAR') && !str_starts_with($upper, 'TAHUN')) {
                    $this->instansi = $text;
                }
            }
        }

        // 3) Ambil baris data di bawah header, berhenti begitu ketemu
        //    baris penutup tabel (baris "JUMLAH" dan blok tanda tangan
        //    "Yang Mengajukan / Menyetujui ... NIP ..." di bawahnya) —
        //    lihat catatan di isClosingSectionRow().
        foreach ($sheetRows->slice($headerRowIndex + 1) as $row) {
            if ($this->isClosingSectionRow($row)) {
                break;
            }

            $no       = isset($columnMap['nomor_arsip']) ? trim((string) $row->get($columnMap['nomor_arsip'])) : '';
            $kode     = isset($columnMap['kode_klasifikasi']) ? trim((string) $row->get($columnMap['kode_klasifikasi'])) : '';
            $tahun    = isset($columnMap['tahun']) ? trim((string) $row->get($columnMap['tahun'])) : '';
            $uraian   = isset($columnMap['uraian']) ? trim((string) $row->get($columnMap['uraian'])) : '';
            // Kolom Instansi per baris sifatnya opsional — kebanyakan file
            // "Daftar Arsip Statis" cuma punya satu nama instansi di judul
            // (ditangani di langkah 2 di atas), bukan kolom tersendiri.
            // Kalau memang ada kolomnya, nilai per baris ini yang dipakai
            // duluan (lihat ArchiveController::importStore).
            $instansi = isset($columnMap['instansi']) ? trim((string) $row->get($columnMap['instansi'])) : '';

            // lewati baris kosong / pemisah antar section
            if ($no === '' && $kode === '' && $uraian === '') {
                continue;
            }

            $this->rows[] = [
                'nomor_arsip'      => $no ?: '-',
                'kode_klasifikasi' => $kode ?: '-',
                'tahun'            => $tahun,
                'uraian'           => $uraian,
                'instansi'         => $instansi,
            ];
        }
    }

    /**
     * Setelah baris data terakhir, dokumen "Daftar Arsip Statis" biasanya
     * ditutup dengan baris "JUMLAH" lalu blok tanda tangan dua kolom
     * ("Yang Mengajukan" / "Menyetujui", nama pejabat, NIP, dst — lihat
     * contoh gambar penutup dokumen). Baris-baris ini bukan data arsip,
     * jadi begitu salah satunya ketemu, sisa baris di bawahnya (termasuk
     * baris ini sendiri) tidak boleh ikut ter-import sebagai daftar arsip.
     */
    protected function isClosingSectionRow(Collection $row): bool
    {
        $closingMarkers = [
            'jumlah',
            'yang mengajukan',
            'menyetujui',
            'mengetahui',
            'sekretaris',
            'pembina utama',
            'pembina tingkat',
        ];

        foreach ($row as $cell) {
            $value = $this->normalize($cell);

            if ($value === '') {
                continue;
            }

            foreach ($closingMarkers as $marker) {
                if ($value === $marker || str_starts_with($value, $marker)) {
                    return true;
                }
            }

            // Baris "NIP 198512142009121002" atau "NIP. 197105101990031003".
            if (preg_match('/^nip\b/', $value)) {
                return true;
            }
        }

        return false;
    }

    protected function normalize(mixed $value): string
    {
        // Rapikan whitespace (termasuk line-break di dalam sel akibat word-wrap,
        // misal sel "No\nDefinitif") jadi satu spasi, dan buang tanda baca
        // seperti titik/titik dua/garis miring (mis. sel "No. Definitif" atau
        // "Instansi/OPD") supaya tetap cocok dengan alias yang ditulis tanpa
        // tanda baca ("no definitif", "instansi/opd" dst tetap tercocokkan
        // lewat perbandingan tanpa tanda baca ini).
        $value = preg_replace('/\s+/u', ' ', (string) $value) ?? '';
        $value = mb_strtolower(trim($value));
        $value = preg_replace('/[.:\/]+/u', ' ', $value) ?? $value;
        $value = preg_replace('/\s+/u', ' ', $value) ?? $value;

        return trim($value);
    }

    protected function rowContainsAny(array $cells, array $needles): bool
    {
        foreach ($cells as $cell) {
            if ($cell === '') {
                continue;
            }

            foreach ($needles as $needle) {
                if ($this->cellMatchesAlias($cell, $needle)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * True jika $alias muncul sebagai kata/frasa utuh di dalam $cell,
     * misal alias "no" cocok dengan sel "no definitif", dan alias
     * "tahun" cocok dengan sel "tahun arsip".
     */
    protected function cellMatchesAlias(string $cell, string $alias): bool
    {
        if ($cell === $alias) {
            return true;
        }

        $pattern = '/(?<![a-z0-9])' . preg_quote($alias, '/') . '(?![a-z0-9])/i';

        return (bool) preg_match($pattern, $cell);
    }
}