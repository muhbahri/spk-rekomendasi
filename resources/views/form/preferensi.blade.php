<x-app-layout>
    <x-slot name="header">
    
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Pertanyaan Preferensi') }}
        </h2>

        </x-slot>

    <div class="max-w-5xl py-6 mx-auto">
        <form method="POST" action="{{ route('form.submit') }}" class="p-6 bg-white rounded shadow">
            @csrf

            @php
    $grouped = $pertanyaans->groupBy(fn($p) => $p->kriteria->nama);
@endphp

@foreach($grouped as $kriteria => $list)
    <div class="mb-10">
        <h3 class="pb-1 mb-2 text-lg font-bold text-blue-700 border-b">{{ $kriteria }}</h3>

        {{-- Skala Likert --}}
        <div class="mb-4 text-sm text-gray-600">
            <div class="flex justify-between max-w-md">
                <span>1 = Sangat Tidak Setuju / Tidak Penting</span>
                <span>3 = Cukup Setuju / Cukup Penting</span>
                <span>5 = Sangat Setuju / Sangat Penting</span>
            </div>
        </div>

        @foreach($list as $pertanyaan)
            <div class="mb-6">
                <label class="block mb-2 font-medium text-gray-800">{{ $pertanyaan->pertanyaan }}</label>
                <div class="flex gap-6">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="inline-flex items-center">
                            <input type="radio"
                                   name="jawaban[{{ $pertanyaan->id }}]"
                                   value="{{ $i }}"
                                   class="mr-1"
                                   required>
                            {{ $i }}
                        </label>
                    @endfor
                </div>
            </div>
        @endforeach
    </div>
@endforeach


            <div class="mt-6 text-right">
                <button type="submit" class="px-4 py-2 text-white transition bg-blue-600 rounded hover:bg-blue-700">
                    Lanjut ke Hasil
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
