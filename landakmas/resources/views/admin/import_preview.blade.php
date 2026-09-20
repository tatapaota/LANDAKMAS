@extends('layouts.admin')

@section('title', 'Preview Import Arsip | LANDAKMAS')

@section('content')

<h2 class="font-serif text-4xl text-slate-900">Preview Import Arsip</h2>
<p class="text-slate-500 mt-2">
  Periksa dulu hasil baca file di bawah ini. Data baru benar-benar tersimpan
  setelah kamu klik "Simpan Semua ke Database".
</p>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-10 mt-8">
<form action="{{ route('admin.archive.import.store') }}" method="POST">
@csrf

<div class="grid sm:grid-cols-2 gap-x-10 gap-y-6 mb-8">
<div>
<label class="block font-semibold text-slate-800 mb-2">Instansi (default)</label>
<input type="text" name="instansi" value="{{ old('instansi', $instansi) }}" required
  class="w-full px-5 py-3.5 rounded-lg bg-slate-100 outline-none focus:ring-2 focus:ring-secondary/30"
  placeholder="Nama instansi tidak terdeteksi, isi manual"/>
@if(!$instansi)
<p class="text-sm text-amber-600 mt-2">
  Nama instansi tidak berhasil terbaca otomatis dari file, silakan isi manual.
</p>
@endif
<p class="text-slate-400 text-xs mt-2">
  Dipakai untuk baris yang kolom Instansi-nya kosong / filenya tidak punya kolom Instansi sendiri.
</p>
</div>
<div class="flex items-end">
<p class="text-slate-500 text-sm">
  Ditemukan <strong>{{ count($rows) }}</strong> baris arsip siap diimpor.
</p>
</div>
</div>

<div class="overflow-x-auto rounded-xl border border-slate-100">
<table class="w-full text-sm text-left">
<thead class="bg-slate-50 text-slate-500">
<tr>
<th class="py-3 px-4">No. Definitif</th>
<th class="py-3 px-4">Kode Klasif</th>
<th class="py-3 px-4">Tahun</th>
<th class="py-3 px-4">Instansi</th>
<th class="py-3 px-4">Uraian Arsip</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100">
@foreach($rows as $row)
<tr>
<td class="py-3 px-4 whitespace-nowrap">{{ $row['nomor_arsip'] }}</td>
<td class="py-3 px-4 whitespace-nowrap">{{ $row['kode_klasifikasi'] }}</td>
<td class="py-3 px-4 whitespace-nowrap">{{ $row['tahun'] }}</td>
<td class="py-3 px-4 whitespace-nowrap text-slate-500">{{ $row['instansi'] ?? '' ?: '(pakai default)' }}</td>
<td class="py-3 px-4">{{ $row['uraian'] }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<div class="flex gap-4 mt-8">
<a href="{{ route('admin.archive.create') }}" class="px-6 py-3 rounded-lg border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition">
  Batal
</a>
<button type="submit" class="bg-primary text-white font-semibold px-6 py-3 rounded-lg hover:bg-slate-800 transition">
  Simpan Semua ke Database
</button>
</div>

</form>
</div>

@endsection

