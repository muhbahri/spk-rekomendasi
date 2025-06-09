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

            <div class="mb-4">
                <label for="keterampilan" class="block font-bold">Keterampilan</label>
                <input type="text" name="keterampilan" value="{{ old('keterampilan', $user->keterampilan) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="pengalaman_kerja" class="block font-bold">Pengalaman Kerja</label>
                <textarea name="pengalaman_kerja" rows="3" class="w-full border rounded px-3 py-2" required>{{ old('pengalaman_kerja', $user->pengalaman_kerja) }}</textarea>
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">Lanjut ke Preferensi</button>
            </div>
        </form>
    </div>
</x-app-layout>
