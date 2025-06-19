<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hasil Rekomendasi Negara</h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto text-center">
        <h1 class="text-4xl font-bold uppercase mb-2">Rekomendasi Negara</h1>
        <h2 class="text-6xl font-extrabold uppercase text-blue-700 mb-6">{{ strtoupper($topCountry) }}</h2>

        <div class="bg-white border-2 border-black rounded-lg p-6 shadow-md max-w-xl mx-auto text-left">
            <h3 class="text-xl font-semibold mb-3">Peringkat Alternatif Negara Lain</h3>
            <ol class="list-decimal list-inside space-y-4">
                @foreach ($alternatifCountries as $negara => $skor)
                    <li>
                        <strong>{{ $negara }}</strong>
                        <br>
                        Namun, negara ini memiliki kelebihan di beberapa aspek namun sedikit kalah pada aspek 
                        @php
                            // Tentukan aspek terlemah negara ini berdasarkan bobot
                            $kriteriaTerlemah = \App\Models\Kriteria::all()->sortBy(function($kriteria) use ($negara) {
                                return \App\Models\BobotNegara::whereHas('negara', fn($q) => $q->where('nama', $negara))
                                    ->where('kriteria_id', $kriteria->id)
                                    ->value('nilai_bobot');
                            })->first();
                        @endphp
                        <em>{{ strtolower($kriteriaTerlemah->nama ?? 'beberapa kriteria') }}</em>.
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold mb-4">Berikut adalah rekomendasi negara untuk Anda:</h3>
            <ol class="list-decimal ml-5">
                @foreach ($scores as $negara => $skor)
                    <li class="mb-2">
                        <strong>{{ $negara }}</strong> — Skor: {{ number_format($skor, 4) }}
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</x-app-layout>

{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Rekomendasi Negara') }}
        </h2>
    </x-slot>

    @if (session('info'))
    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4">
        {{ session('info') }}
    </div>
    @endif --}}


    
{{-- </x-app-layout> --}}
