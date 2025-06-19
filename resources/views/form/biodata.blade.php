@section('title', 'Lengkapi Biodata')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lengkapi Biodata') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('biodata.update') }}" class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label for="usia" class="block font-bold">Usia</label>
                <input type="number" name="usia" value="{{ old('usia', $user->usia) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Keterampilan -->
            <div class="mb-4">
                <label class="block font-bold mb-2">Keterampilan atau Pengalaman Kerja (maks. 3)</label>
                @php
                    $keterampilanOptions = [
                        'Caregiver (Perawat Lansia)',
                        'Asisten Rumah Tangga',
                        'Operator Pabrik',
                        'Pekerja Konstruksi',
                        'Juru Masak',
                        'Welding',
                        'Kerja Gudang (Logistik)',
                        'Lainnya'
                    ];
                    $selected = old('keterampilan', $user->keterampilan ? explode(', ', $user->keterampilan) : []);
                @endphp

                @foreach($keterampilanOptions as $option)
                    <label class="flex items-center space-x-2 mb-1">
                        <input 
                            type="checkbox" 
                            name="keterampilan[]" 
                            value="{{ $option }}"
                            @checked(in_array($option, $selected))
                            class="keterampilan-checkbox"
                        >
                        <span>{{ $option }}</span>
                    </label>
                @endforeach

                <!-- Input Lainnya -->
                <div class="mt-2 mb-4" x-transition>
                    <input 
                        type="text" 
                        name="keterampilan_lainnya"
                        placeholder="(-) Jika tidak memiliki keterampilan lain"
                        style="display: none"
                        class="w-full px-3 py-2 border rounded keterampilan-lainnya-input"
                    >
                </div>
            </div>

            <!-- Pengalaman Kerja -->
            <div class="mb-4" x-data="{ status: '{{ old('status_kerja', 'fresh') }}' }">
                <label class="block font-bold mb-2">Status Pengalaman Terakhir</label>
                
                <label class="flex items-center space-x-2 mb-1">
                    <input type="radio" name="status_kerja" value="fresh" x-model="status">
                    <span>Fresh Graduate</span>
                </label>

                <label class="flex items-center space-x-2 mb-1">
                    <input type="radio" name="status_kerja" value="bekerja" x-model="status">
                    <span>Pernah Bekerja</span>
                </label>

                <!-- Jika Pernah Bekerja -->
                <div x-show="status === 'bekerja'" x-transition class="mt-2">
                    <input type="text" name="bidang_kerja" placeholder="Bidang kerja (contoh: Logistik)" value="{{ old('bidang_kerja') }}" class="w-full border rounded px-3 py-2 mb-2">
                    <select name="lama_kerja" class="w-full border rounded px-3 py-2">
                        <option value=""><-- Pilih Lama Bekerja --></option>
                        <option value="< 6 Bulan" @selected(old('lama_kerja') === '< 6 Bulan')>< 6 Bulan</option>
                        <option value="6 - 12 Bulan" @selected(old('lama_kerja') === '6 - 12 Bulan')>6 - 12 Bulan</option>
                        <option value="> 12 Bulan" @selected(old('lama_kerja') === '> 12 Bulan')>> 12 Bulan</option>
                    </select>
                </div>
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lanjut ke Preferensi</button>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const checkboxes = document.querySelectorAll('.keterampilan-checkbox');
                    const lainnyaCheckbox = Array.from(checkboxes).find(cb => cb.value.toLowerCase().includes('lainnya'));
                    const inputLainnya = document.querySelector('.keterampilan-lainnya-input');

                    checkboxes.forEach(cb => {
                        cb.addEventListener('change', () => {
                            const selected = Array.from(checkboxes).filter(c => c.checked);

                            if (cb === lainnyaCheckbox && cb.checked) {
                                // Jika memilih "Lainnya", kosongkan semua yang lain
                                checkboxes.forEach(c => {
                                    if (c !== lainnyaCheckbox) c.checked = false;
                                });
                                inputLainnya.style.display = 'block';

                            } else if (cb !== lainnyaCheckbox && cb.checked) {
                                // Jika memilih salah satu selain "Lainnya", uncheck "Lainnya"
                                lainnyaCheckbox.checked = false;
                                inputLainnya.style.display = 'none';
                                inputLainnya.value = '';
                            }

                            if (selected.length > 3) {
                                cb.checked = false;
                            }
                        });
                    });
                });
            </script>

            </div>


        </form>
    </div>
</x-app-layout>
