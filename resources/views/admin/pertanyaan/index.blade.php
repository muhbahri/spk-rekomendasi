<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Daftar Pertanyaan Preferensi</h2>
    </x-slot>

    <div class="p-4">
        <a href="{{ route('admin.pertanyaan.create') }}" class="inline-block px-4 py-2 mb-4 text-white bg-green-600 rounded">+ Tambah Pertanyaan</a>

        <table class="w-full text-sm bg-white border rounded shadow table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Kriteria</th>
                    <th class="px-4 py-2 border">Pertanyaan</th>
                    <th class="px-4 py-2 border">Urutan</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pertanyaans as $p)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $p->kriteria->nama }}</td>
                        <td class="px-4 py-2">{{ $p->pertanyaan }}</td>
                        <td class="px-4 py-2">{{ $p->urutan }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.pertanyaan.edit', $p) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.pertanyaan.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pertanyaan ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
