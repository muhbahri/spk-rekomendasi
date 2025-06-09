<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Daftar Negara</h2>
    </x-slot>

    <div class="p-4">
        <a href="{{ route('admin.negara.create') }}" class="inline-block px-4 py-2 mb-4 text-black bg-green-600 rounded">+ Tambah Negara</a>

        <table class="w-full text-sm bg-white border rounded shadow table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left border">Nama</th>
                    <th class="px-4 py-2 text-left border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($negaras as $negara)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $negara->nama }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.negara.edit', $negara) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.negara.destroy', $negara) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
