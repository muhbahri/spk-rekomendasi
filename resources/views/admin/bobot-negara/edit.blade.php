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
