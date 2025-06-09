<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Edit Pertanyaan</h2>
    </x-slot>

    <div class="max-w-xl p-4 mx-auto mt-4 bg-white rounded shadow">
        <form action="{{ route('admin.pertanyaan.update', $pertanyaan) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Pertanyaan</label>
                <textarea name="pertanyaan" class="w-full px-3 py-2 border rounded" required>{{ $pertanyaan->pertanyaan }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Kriteria</label>
                <select name="kriteria_id" class="w-full px-3 py-2 border rounded" required>
                    @foreach($kriterias as $k)
                        <option value="{{ $k->id }}" @selected($pertanyaan->kriteria_id == $k->id)>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Urutan</label>
                <input type="number" name="urutan" value="{{ $pertanyaan->urutan }}" class="w-full px-3 py-2 border rounded" required>
            </div>

            <button class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Update</button>
        </form>
    </div>
</x-app-layout>
