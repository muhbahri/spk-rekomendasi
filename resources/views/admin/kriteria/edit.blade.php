<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Edit Kriteria</h2>
    </x-slot>

    <div class="max-w-md p-4 mx-auto bg-white rounded shadow">
        <form action="{{ route('admin.kriteria.update', $kriteria) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold">Nama Kriteria</label>
                <input type="text" name="nama" value="{{ $kriteria->nama }}" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Jenis</label>
                <select name="is_benefit" class="w-full px-3 py-2 border rounded">
                    <option value="1" @if($kriteria->is_benefit) selected @endif>Benefit</option>
                    <option value="0" @if(!$kriteria->is_benefit) selected @endif>Cost</option>
                </select>
            </div>

            <button class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Update</button>
        </form>
    </div>
</x-app-layout>
