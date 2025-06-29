@section('title', 'Admin - Daftar Pertanyaan')
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Daftar Pertanyaan Preferensi</h2>
    </x-slot>

    <div class="p-4" x-data="{ showCreate: false, selectedKriteria: '', urutan: 1 }">
        <button @click="showCreate = true" class="inline-block px-4 py-2 mb-4 text-white bg-green-600 rounded hover:bg-green-700">
                Tambah Pertanyaan
            </button>

        <table class="w-full text-sm bg-white border rounded shadow table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Kriteria</th>
                    <th class="px-4 py-2 border">Pertanyaan</th>
                    <th class="px-4 py-2 border">Urutan</th>
                    <th class="px-3 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pertanyaans as $p)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $p->kriteria->nama }}</td>
                        <td class="px-4 py-2">{{ $p->pertanyaan }}</td>
                        <td class="px-4 py-2">{{ $p->urutan }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.pertanyaan.edit.kriteria', $p->kriteria_id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.pertanyaan.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pertanyaan ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            
            <!-- Modal -->
            <div x-show="showCreate" x-transition style="display: none"
                @keydown.escape.window="showCreate = false"
                x-init="$watch('showCreate', v => v && $nextTick(() => $refs.pertanyaan.focus()))"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            >
                <div class="relative w-full max-w-md p-6 bg-white rounded shadow-md">
                    <button @click="showCreate = false" class="absolute text-4xl text-gray-500 top-3 right-4 hover:text-red-600">&times;</button>
                    <h2 class="mb-4 text-lg font-bold">Tambah Pertanyaan</h2>

                    <form method="POST" action="{{ route('admin.pertanyaan.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Pertanyaan</label>
                            <textarea name="pertanyaan" x-ref="pertanyaan" class="w-full px-3 py-2 border rounded" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Kriteria</label>
                            <select name="kriteria_id" x-model="selectedKriteria" class="w-full px-3 py-2 border rounded" required @change="getUrutan()">
                                <option value="">-- Pilih Kriteria --</option>
                                @foreach($kriterias as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="urutan" :value="urutan">

                        <button type="submit" class="w-full py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function getUrutan() {
                fetch(`/admin/pertanyaan/urutan?kriteria_id=${document.querySelector('[x-model="selectedKriteria"]').value}`)
                    .then(res => res.json())
                    .then(data => {
                        document.querySelector('[x-data]').__x.$data.urutan = data.urutan;
                    });
            }
        </script>

    </div>
</x-app-layout>

@if(session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 2000)" 
        x-show="show"
        x-transition
        :class="{
            'fixed inset-x-0 top-0 z-50 flex px-4 py-3 shadow-md border-b bg-green-100 text-green-800 border-green-300': !('{{ session('success') }}'.toLowerCase().includes('hapus')),
            'fixed inset-x-0 top-0 z-50 flex px-4 py-3 shadow-md border-b bg-red-100 text-red-800 border-red-300': '{{ session('success') }}'.toLowerCase().includes('hapus')
        }"
    >
        <div class="flex items-center w-full max-w-3xl gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M5 13l4 4L19 7" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

