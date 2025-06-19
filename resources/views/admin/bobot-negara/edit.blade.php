<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Edit Bobot: {{ $negara->nama }}</h2>
    </x-slot>

    <div class="max-w-xl p-4 mx-auto mt-4 bg-white rounded shadow">
        <small class="text-center">Nilai skala 1–5, sesuai urgensi kriteria ini di negara terkait.</small>
        <form action="{{ route('admin.bobot-negara.update', $negara->id) }}" method="POST">
            @csrf @method('PUT')

            <table class="w-full text-sm table-auto">
                <thead>
                    <tr class="text-left bg-gray-100">
                        <th class="px-4 py-2 border">Kriteria</th>
                        <th class="px-4 py-2 border">Nilai Bobot (0–5)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kriterias as $k)
                        <tr>
                            <td class="px-4 py-2 border">{{ $k->nama }}</td>
                            <td class="px-4 py-2 border">
                                <input
                                    type="number"
                                    name="nilai_bobot[{{ $k->id }}]"
                                    value="{{ $bobot[$k->id] ?? '' }}"
                                    step="1"
                                    min="1"
                                    max="5"
                                    class="w-24 px-2 py-1 border rounded"
                                    required
                                >      
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 text-right">
                <button class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app-layout>

@if(session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 2000)" 
        x-show="show"
        x-transition
        class="fixed inset-x-0 top-0 z-50 flex px-4 py-3 text-green-800 bg-green-100 border-b border-green-300 shadow-md"
    >
        <div class="flex items-center w-full max-w-3xl gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M5 13l4 4L19 7" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

