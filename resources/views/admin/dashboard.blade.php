<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Dashboard Admin — Data Calon PMI
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="p-4 overflow-x-auto bg-white rounded shadow">
            <h3 class="mb-4 text-lg font-semibold">Daftar Calon PMI</h3>
            <div class="flex items-center justify-between mb-4">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex gap-2 mb-4">
                    <input type="text" name="search" value="{{ $keyword }}" placeholder="Cari nama atau email"
                    class="w-64 px-3 border rounded">
                    <button class="px-4 text-black bg-blue-600 rounded hover:bg-blue-700">Cari</button>
                </form>
                <a href="{{ route('admin.users.create') }}" class="inline-block px-4 py-2 mb-4 text-black bg-green-600 rounded hover:bg-green-700">
                ➕ Tambah Calon PMI Baru
                </a>
            </div>

            <table class="w-full text-sm border table-auto">
                <thead>
                    <tr class="text-left bg-gray-200">
                        <th class="px-3 py-2 border">Nama</th>
                        <th class="px-3 py-2 border">Email</th>
                        <th class="px-3 py-2 border">Usia</th>
                        <th class="px-3 py-2 border">Keterampilan</th>
                        <th class="px-3 py-2 border">Pengalaman Kerja</th>
                        <th class="px-3 py-2 border">Rekomendasi Negara</th>
                        <th class="px-3 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-t">
                            <td class="px-3 py-2">{{ $user->name }}</td>
                            <td class="px-3 py-2">{{ $user->email }}</td>
                            <td class="px-3 py-2">{{ $user->usia ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $user->keterampilan ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $user->pengalaman_kerja ?? '-' }}</td>
                            <td class="px-3 py-2 font-semibold text-blue-700">
                                {{ $user->hasilRekomendasi->negara->nama ?? '-' }}
                            </td>
                            <td class="px-3 py-2">
                                <form action="{{ route('admin.users.reset', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin reset jawaban preferensi user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 text-xs text-black bg-red-500 rounded hover:bg-red-600">
                                        Reset Preferensi
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
