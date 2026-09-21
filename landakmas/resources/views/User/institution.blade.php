@extends('layouts.public')

@section('title', 'Direktori Instansi | LANDAKMAS')

@section('content')





    <section class="bg-primary">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <h1 class="font-serif text-5xl text-white">Direktori Instansi</h1>
            <p class="text-slate-300 mt-4">
                Pilih salah satu Instansi untuk melihat seluruh arsip yang tersimpan
                pada instansi tersebut.
            </p>
        </div>
    </section>


    <section class="bg-soft py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-6" id="institutionGrid">
                <!-- Cards di-render lewat JavaScript, lihat data di bawah -->
            </div>
        </div>
    </section>



    <script>
        // Data instansi dihitung otomatis dari tabel arsips (lewat controller
        // PublicSiteController@institution). Kartu ini otomatis bertambah kalau
        // ada instansi baru yang punya arsip tersimpan.
        const institutions = @json($institutionsJs);

        const grid = document.getElementById("institutionGrid");
        const institutionDetailBaseUrl = "{{ route('institution.detail') }}";

        if (institutions.length === 0) {
            grid.innerHTML = `
      <p class="col-span-full text-center text-slate-500 py-16">
        Belum ada arsip yang tersimpan untuk instansi manapun.
      </p>`;
        } else {
            grid.innerHTML = institutions
                .map(
                    (inst) => `
              <a href="${institutionDetailBaseUrl}?instansi=${inst.slug}" class="block bg-white rounded-2xl shadow-lg p-6 hover:-translate-y-1 hover:shadow-xl duration-300 cursor-pointer">
                <h1 class="font-serif text-5xl text-primary">${String(inst.jumlahArsip).padStart(3, "0")}</h1>
                <h4 class="font-bold mt-3">${inst.nama}</h4>
                <p class="text-slate-500 mt-1">${inst.deskripsi}</p>
                <span class="inline-block mt-5 text-blue-600 font-semibold">
                  Lihat arsip →
                </span>
              </a>
            `,
                )
                .join("");
        }
    </script>


@endsection
