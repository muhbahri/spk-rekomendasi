<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Dashboard Admin — Data Calon PMI
        </h2>
    </x-slot>
        <div class="grid grid-cols-2 gap-4 m-4 sm:grid-cols-2 md:grid-cols-4">
            <div class="p-4 text-center bg-white rounded-lg shadow">
                <div class="text-sm text-gray-500">Total Calon PMI</div>
                <div class="text-2xl font-bold text-blue-800">{{ $jumlahPMI }}</div>
            </div>
            <div class="p-4 text-center bg-white rounded-lg shadow">
                <div class="text-sm text-gray-500">Sudah Isi Preferensi</div>
                <div class="text-2xl font-bold text-green-600">{{ $sudahMengisi }}</div>
            </div>
            <div class="p-4 text-center bg-white rounded-lg shadow">
                <div class="text-sm text-gray-500">Belum Isi Preferensi</div>
                <div class="text-2xl font-bold text-yellow-500">{{ $belumMengisi }}</div>
            </div>
            <div class="p-4 text-center bg-white rounded-lg shadow">
                <div class="text-sm text-gray-500">Rekomendasi Terbanyak</div>
                <div class="text-xl font-semibold text-purple-700">{{ $negaraTerbanyak }}</div>
            </div>
        </div>


        <div class="p-4 m-4 overflow-x-auto bg-white rounded shadow">
            <h3 class="mb-4 text-lg font-semibold">Daftar Calon PMI</h3>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex gap-2 mb-4">
                    <input type="text" name="search" value="{{ $keyword }}" placeholder="Cari nama atau email"
                    class="w-64 px-3 border rounded">
                    <button class="px-4 text-white bg-blue-600 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400"">Cari</button>
                </form>
                <div x-data="{ showModal: false }"  @keydown.escape.window="showModal = false">
                    <button @click="showModal = true"
                        class="inline-block px-4 py-2 mb-4 text-white bg-green-600 rounded hover:bg-green-700">
                        ➕ Tambah Calon PMI Baru
                    </button>
                    <div x-show="showModal" x-transition
                        style="display: none"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
                            
                            <!-- Close button -->
                            <button @click="showModal = false"
                                class="absolute text-4xl text-gray-500 top-3 right-4 hover:text-red-500">&times;</button>

                            <h2 class="mb-4 text-lg font-semibold text-gray-700">Tambah Calon PMI Baru</h2>

                            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="name" class="block mb-1 text-sm font-medium">Nama</label>
                                    <input type="text" name="name" id="name" required
                                        class="w-full px-3 py-2 border rounded">
                                </div>

                                <button type="submit"
                                    class="w-full py-2 font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">
                                    Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
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
                                    <button class="px-3 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600">
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
            <div x-data="{ showModal: false }">
                <!-- Modal -->
                <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
                        <button @click="showModal = false"
                            class="absolute text-xl text-gray-500 top-2 right-2 hover:text-red-500">&times;</button>

                        <h2 class="mb-4 text-lg font-semibold text-gray-700">Tambah Calon PMI Baru</h2>

                        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                            @csrf

                            <div>
                                <label for="name" class="block text-sm font-medium">Nama Calon PMI</label>
                                <input type="text" name="name" id="name" required
                                    class="w-full px-3 py-2 border rounded">
                            </div>

                            <button type="submit"
                                class="w-full py-2 font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
