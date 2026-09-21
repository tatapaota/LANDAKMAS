@extends('layouts.admin')

@section('title', 'Tambah Arsip | LANDAKMAS')

@section('content')


<h2 class="font-serif text-4xl text-slate-900">Tambah Arsip</h2>


<p class="text-slate-500 mt-2">
          Upload file Excel daftar arsip untuk menambahkannya ke sistem
        </p>

<!-- ==== Upload Massal dari File Excel ==== -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-10 mt-8">
<h3 class="font-semibold text-slate-800">Upload Massal dari File Excel</h3>
<div class="border-b border-slate-200 mt-3 mb-6"></div>

<p class="text-slate-500 text-sm mb-5">
  Upload file <strong>.xlsx</strong> daftar arsip (format Daftar Arsip Statis). Sistem otomatis
  mengambil kolom <strong>Kode Klasifikasi, No. Definitif, Uraian, Instansi, dan Tahun</strong>
  (kolom Instansi boleh tidak ada di file, nanti dideteksi dari judul file atau diisi manual di
  halaman preview). Kamu akan diminta konfirmasi di halaman preview sebelum data benar-benar
  disimpan.
</p>

<form action="{{ route('admin.archive.import.preview.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
@csrf
<div class="flex items-center gap-2">
  <input type="file" name="file" id="excelFileInput" accept=".xlsx,.xls" required class="text-sm text-slate-600 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-0 file:bg-primary file:text-white file:font-semibold hover:file:bg-slate-800 file:transition"/>
  <button type="button" id="excelFileClearBtn" onclick="document.getElementById('excelFileInput').value = ''; this.classList.add('hidden');" class="hidden text-slate-400 hover:text-rose-500 transition" title="Hapus file yang dipilih">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>
</div>
<button type="submit" class="bg-primary text-white text-sm font-semibold px-6 py-3 rounded-lg hover:bg-slate-800 transition whitespace-nowrap">
  Baca &amp; Preview File
</button>
</form>
<script>
  document.getElementById('excelFileInput')?.addEventListener('change', function () {
    document.getElementById('excelFileClearBtn').classList.toggle('hidden', !this.files.length);
  });
</script>
</div>


@endsection

