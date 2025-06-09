<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Tambah Negara</h2>
    </x-slot>

    <div class="max-w-md p-4 mx-auto bg-white rounded shadow">
        <form action="{{ route('admin.negara.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Nama Negara</label>
                <input type="text" name="nama" class="w-full px-3 py-2 border rounded" required>
            </div>
            <button class="px-4 py-2 text-black bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
        </form>
    </div>
</x-app-layout>
