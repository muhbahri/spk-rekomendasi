@section('title', 'Admin - Daftar Bobot Negara')
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Bobot Negara</h2>
    </x-slot>

    <div class="p-4">
        <div class="p-4 overflow-x-auto bg-white rounded shadow">
            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 border">Negara</th>
                        @foreach($kriterias as $k)
                            <th class="px-3 py-2 border">{{ $k->nama }}</th>
                        @endforeach
                        <th class="px-3 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($negaras as $negara)
                        <tr>
                            <td class="px-3 py-2 border">{{ $negara->nama }}</td>
                            @foreach($kriterias as $k)
                                @php
                                    $nilai = $negara->bobotNegaras->firstWhere('kriteria_id', $k->id)?->nilai_bobot ?? '-';
                                @endphp
                                <td class="px-3 py-2 text-center border">{{ $nilai }}</td>
                            @endforeach
                            <td class="px-3 py-2 border">
                                <a href="{{ route('admin.bobot-negara.edit', $negara->id) }}" class="text-sm text-blue-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
