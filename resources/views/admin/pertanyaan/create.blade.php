<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Tambah Pertanyaan</h2>
    </x-slot>

    <div class="max-w-xl p-4 mx-auto mt-4 bg-white rounded shadow" x-data="{
        inputs: [''],
        addField() {
            this.inputs.push('');
        },
        removeField(i) {
            this.inputs.splice(i, 1);
        }
    }">
        <form action="{{ route('admin.pertanyaan.store') }}" method="POST">
            @csrf

            <template x-for="(item, index) in inputs" :key="index">
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Pertanyaan <span x-text="index + 1"></span></label>
                    <textarea :name="'pertanyaan[' + index + ']'" class="w-full px-3 py-2 border rounded" required></textarea>
                    <button type="button" @click="removeField(index)" x-show="inputs.length > 1"
                        class="mt-1 text-sm text-red-600 hover:underline">Hapus</button>
                </div>
            </template>

            <button type="button" @click="addField()" class="px-2 py-1 mb-4 text-sm bg-gray-200 rounded hover:bg-gray-300">
                + Tambah Pertanyaan
            </button>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Kriteria</label>

                <select class="w-full px-3 py-2 bg-gray-100 border rounded" disabled>
                    @foreach($kriterias as $k)
                        <option value="{{ $k->id }}" {{ $selectedKriteriaId == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>

                <input type="hidden" name="kriteria_id" value="{{ $selectedKriteriaId }}">
            </div>


            <button type="submit" class="w-full py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
        </form>
    </div>
</x-app-layout>
