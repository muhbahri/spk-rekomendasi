<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Edit Pertanyaan untuk Kriteria: {{ $kriteria->nama }}</h2>
    </x-slot>

    <div class="max-w-3xl p-4 mx-auto mt-4 bg-white rounded shadow">
        <form action="{{ route('admin.pertanyaan.update.kriteria', $kriteria->id) }}" method="POST">
            @csrf @method('PUT')

            @foreach ($pertanyaans as $index => $p)
                <div class="mb-6 border-b pb-4">
                    <input type="hidden" name="pertanyaan[{{ $index }}][id]" value="{{ $p->id }}">

                    <label class="block font-semibold mb-1">Pertanyaan #{{ $index + 1 }}</label>
                    <textarea name="pertanyaan[{{ $index }}][teks]" class="w-full border rounded px-3 py-2 mb-2" required>{{ $p->pertanyaan }}</textarea>

                    <label class="block font-semibold mb-1">Urutan</label>
                    <select 
                        name="pertanyaan[{{ $index }}][urutan]"
                        class="urutan-dropdown w-full border rounded px-3 py-2"
                        data-index="{{ $index }}"
                        required
                    >
                        @for ($i = 1; $i <= 3; $i++)
                            <option value="{{ $i }}" @selected($p->urutan == $i)>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            @endforeach

            <button class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan Semua</button>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const dropdowns = document.querySelectorAll('.urutan-dropdown');

                    dropdowns.forEach((dropdown) => {
                        dropdown.addEventListener('change', function () {
                            const currentIndex = this.dataset.index;
                            const selectedValue = this.value;

                            dropdowns.forEach((other) => {
                                if (other !== this && other.value === selectedValue) {
                                    // Temukan nilai unik yang belum dipakai
                                    const used = Array.from(dropdowns).map(d => parseInt(d.value));
                                    for (let i = 1; i <= 3; i++) {
                                        if (!used.includes(i)) {
                                            other.value = i;
                                            break;
                                        }
                                    }
                                }
                            });
                        });
                    });
                });
            </script>
        </form>
    </div>
</x-app-layout>
