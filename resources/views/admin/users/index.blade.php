<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Data Calon PMI
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full table-auto border text-sm">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-3 py-2 border">Nama</th>
                        <th class="px-3 py-2 border">Email</th>
                        <th class="px-3 py-2 border">Usia</th>
                        <th class="px-3 py-2 border">Keterampilan</th>
                        <th class="px-3 py-2 border">Pengalaman Kerja</th>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada user calon PMI.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
