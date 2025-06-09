<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Rekomendasi Negara') }}
        </h2>
    </x-slot>

    @if (session('info'))
    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4">
        {{ session('info') }}
    </div>
    @endif


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
