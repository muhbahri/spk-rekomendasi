<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Tambah Calon PMI Baru
        </h2>
    </x-slot>

    <div class="max-w-lg p-6 mx-auto mt-6 bg-white rounded shadow">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold">Nama</label>
                <input type="text" name="name" class="w-full px-3 py-2 border rounded" required>
            </div>

            {{-- <div class="mb-4">
                <label class="block font-semibold">Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded" required>
            </div> --}}

            <button type="submit" class="px-4 py-2 bg-blue-600 rounded text-green hover:bg-blue-700">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>
