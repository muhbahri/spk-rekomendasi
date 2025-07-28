<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Hasil Rekomendasi Negara</h2>
    </x-slot>

    <div class="max-w-4xl py-10 mx-auto text-center">
        <h1 class="mb-2 text-4xl font-bold uppercase">Rekomendasi Negara</h1>
        <h2 class="mb-6 text-6xl font-extrabold text-blue-700 uppercase">{{ strtoupper($topCountry) }}</h2>

        <div class="max-w-xl p-6 mx-auto text-left bg-white border-2 border-black rounded-lg shadow-md">
            <h3 class="mb-3 text-xl font-semibold">Peringkat Alternatif Negara Lain</h3>
            <ol class="space-y-4 list-decimal list-inside">
                @foreach ($alternatifCountries as $negara => $skor)
                    <li value="{{ $loop->index + 2 }}">
                        <strong>{{ $negara }}</strong>
                        <br>
                        Negara ini memiliki kelebihan di beberapa aspek namun sedikit kalah pada aspek 
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
    <div class="max-w-4xl py-6 mx-auto">
        <div class="p-6 bg-white rounded shadow">
            <h3 class="mb-4 text-lg font-bold">Berikut adalah rekomendasi negara untuk Anda:</h3>
            <ol class="ml-5 list-decimal">
                @foreach ($scores as $negara => $skor)
                    <li class="mb-2">
                        <strong>{{ $negara }}</strong> — Skor: {{ number_format($skor, 3) }}
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</x-app-layout>

{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Hasil Rekomendasi Negara') }}
        </h2>
    </x-slot>

    @if (session('info'))
    <div class="p-4 mb-4 text-blue-700 bg-blue-100 border-l-4 border-blue-500">
        {{ session('info') }}
    </div>
    @endif --}}


    
{{-- </x-app-layout> --}}
