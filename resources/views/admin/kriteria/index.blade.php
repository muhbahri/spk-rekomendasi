<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Daftar Kriteria</h2>
    </x-slot>

    <div class="p-4">
        <a href="{{ route('admin.kriteria.create') }}" class="inline-block px-4 py-2 mb-4 text-black bg-green-600 rounded">+ Tambah Kriteria</a>

        <table class="w-full text-sm bg-white border rounded shadow table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Tipe</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriterias as $kriteria)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $kriteria->nama }}</td>
                        <td class="px-4 py-2">{{ $kriteria->is_benefit ? 'Benefit' : 'Cost' }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.kriteria.edit', $kriteria) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.kriteria.destroy', $kriteria) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kriteria ini?')">
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
