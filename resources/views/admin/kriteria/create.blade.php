<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Tambah Kriteria</h2>
    </x-slot>

    <div class="max-w-md p-4 mx-auto bg-white rounded shadow">
        <form action="{{ route('admin.kriteria.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold">Nama Kriteria</label>
                <input type="text" name="nama" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Jenis</label>
                <select name="is_benefit" class="w-full px-3 py-2 border rounded" required>
                    <option value="1" {{ (old('is_benefit', $kriteria->is_benefit ?? '') == '1') ? 'selected' : '' }}>Benefit</option>
                    <option value="0" {{ (old('is_benefit', $kriteria->is_benefit ?? '') == '0') ? 'selected' : '' }}>Cost</option>
                </select>
            </div>

            <button class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
        </form>
    </div>
</x-app-layout>
