<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-col items-center justify-center py-16 min-h-[70vh] text-center font-[handwriting]">
        <h1 class="text-2xl font-semibold leading-relaxed sm:text-3xl">
            Sistem Rekomendasi <br>
            Negara Tujuan <br>
            Calon Pekerja Migran Indonesia
        </h1>
        <p class="mt-2 text-sm text-gray-600">PT. Surya Eka Perkasa</p>

        <div class="mt-8">
            @if (!$sudahMengisiPreferensi)
                <a href="{{ route('biodata.show') }}"
                   class="px-6 py-2 text-lg transition-all border-2 border-black rounded-xl hover:bg-gray-100">
                    Cari Rekomendasi
                </a>
            @else
                <a href="{{ route('hasil.rekomendasi') }}"
                   class="px-6 py-2 text-lg transition-all border-2 border-black rounded-xl hover:bg-gray-100">
                    Lihat Hasil Rekomendasi
                </a>
            @endif
        </div>
    </div>
</x-app-layout>
