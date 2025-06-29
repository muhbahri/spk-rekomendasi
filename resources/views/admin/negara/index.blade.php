@section('title', 'Admin - Daftar Negara')
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Daftar Negara</h2>
    </x-slot>

    <div class="p-4" x-data="{ showCreate: false, showEdit: false, editNama: '', editId: null, newNama: '' }">
        <button @click="showCreate = true"
            class="inline-block px-4 py-2 mb-4 text-white bg-green-600 rounded hover:bg-green-700">
            Tambah Negara
        </button>

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
                            <button
                                @click="
                                    showEdit = true;
                                    editNama = '{{ $negara->nama }}';
                                    editId = {{ $negara->id }};
                                "
                                class="text-blue-600 hover:underline"
                            >
                                Edit
                            </button>

                            <form x-data
                                x-on:submit.prevent="
                                    const namaNegara = $el.dataset.nama;
                                    Swal.fire({
                                        title: `Hapus negara ${namaNegara}?`,
                                        icon: 'error',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya, hapus!',
                                        cancelButtonText: 'Batal',
                                        confirmButtonColor: '#e3342f',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $el.submit();
                                        }
                                    })
                                "
                                data-nama="{{ $negara->nama }}"
                                action="{{ route('admin.negara.destroy', $negara) }}"
                                method="POST"
                                class="inline"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Modal Create -->
        <div
            x-show="showCreate" x-transition
            style="display: none"
            @keydown.escape.window="showCreate = false"
            x-init="$watch('showCreate', value => value && $nextTick(() => $refs.nameInput.focus()))"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        >
            <div class="relative w-full max-w-md p-6 bg-white rounded shadow-md">
                <button @click="showCreate = false" class="absolute text-4xl text-gray-500 top-3 right-4 hover:text-red-600">
                    &times;
                </button>

                <h2 class="mb-4 text-lg font-bold">Tambah Negara</h2>

                <form method="POST" action="{{ route('admin.negara.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Nama Negara</label>
                        <input type="text" name="nama" id="nama" required
                                        x-ref="nameInput"
                                        class="w-full px-3 py-2 border rounded">
                    </div>

                    <button type="submit" class="w-full py-2 text-white bg-green-600 rounded hover:bg-green-700">
                        Simpan Negara
                    </button>
                </form>
            </div>
        </div>


        <!-- Modal Edit -->
        <div
            x-show="showEdit" x-transition
            style="display: none"
            x-init="$watch('showEdit', value => value && $nextTick(() => $refs.nameEdit.focus()))"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            @keydown.escape.window="showEdit = false"
        >
            <div class="relative w-full max-w-md p-6 bg-white rounded shadow-md">
                <button @click="showEdit = false" class="absolute text-4xl text-gray-500 top-3 right-4 hover:text-red-600">
                    &times;
                </button>

                <h2 class="mb-4 text-lg font-bold">Edit Negara</h2>

                <form method="POST" :action="`/admin/negara/${editId}`">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Nama Negara</label>
                        <input type="text" name="nama" x-model="editNama" x-ref="nameEdit" class="w-full px-3 py-2 border rounded" required>
                    </div>

                    <button type="submit" class="w-full py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

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

