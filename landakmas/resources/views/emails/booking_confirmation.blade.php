@component('mail::message')
# Jadwal Pengambilan Arsip Sudah Ditentukan

Halo **{{ $peminjam['nama'] }}**,

Admin sudah memverifikasi permintaan booking arsip Anda dan menentukan jadwal
pengambilannya sebagai berikut:

- **Tanggal Pengambilan:** {{ \Illuminate\Support\Carbon::parse($peminjam['tanggal_pengambilan'])->translatedFormat('d F Y') }}
- **Jam Pengambilan:** {{ $peminjam['waktu_pengambilan'] ?? '-' }} WIB
- **Tujuan Peminjaman:** {{ $peminjam['tujuan'] }}
- **Alamat:** {{ $peminjam['alamat'] }}
- **Telepon:** {{ $peminjam['telepon'] }}

## Daftar Arsip yang Dibooking

@component('mail::table')
| No | Kode Klasifikasi | Uraian | Instansi | Tahun |
|:---|:---|:---|:---|:---|
@foreach ($arsipList as $item)
| {{ $item['no'] ?? '-' }} | {{ $item['kode'] ?? '-' }} | {{ $item['uraian'] ?? '-' }} | {{ $item['instansi'] ?? '-' }} | {{ $item['tahun'] ?? '-' }} |
@endforeach
@endcomponent

Silakan datang langsung ke Kantor Dinas Arsip dan Perpustakaan Daerah
Kabupaten Banyumas sesuai tanggal dan jam pengambilan di atas untuk proses
verifikasi identitas dan pengambilan dokumen. Simpan email ini sebagai bukti
riwayat booking Anda.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent