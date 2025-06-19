<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiodataController extends Controller
{
    public function show()
{
    $user = Auth::user();
    return view('form.biodata', compact('user'));
}

public function update(Request $request)
{
    $request->validate([
        'usia' => 'required|integer',
        'status_kerja' => 'required|in:fresh,bekerja',
        'bidang_kerja' => 'nullable|string|max:100',
        'lama_kerja' => 'nullable|string|max:50',
        'keterampilan' => 'nullable|array|max:3',
        'keterampilan.*' => 'string',
        'keterampilan_lainnya' => 'nullable|string|max:100',
    ]);

    $user = Auth::user();

    $keterampilan = $request->keterampilan_lainnya
        ? [$request->keterampilan_lainnya]
        : ($request->keterampilan ?? []);

    $user->usia = $request->usia;
    $user->keterampilan = implode(', ', $keterampilan);

    $user->pengalaman_kerja = $request->status_kerja === 'bekerja'
        ? trim("{$request->bidang_kerja}, {$request->lama_kerja}")
        : 'Fresh Graduate';

    $user->save();

    $sudahIsi = \App\Models\JawabanUser::where('user_id', $user->id)->exists();

    return $sudahIsi
        ? redirect()->route('hasil.rekomendasi')->with('info', 'Kamu sudah pernah mengisi preferensi. Ini hasil rekomendasimu.')
        : redirect()->route('form.preferensi')->with('success', 'Biodata berhasil disimpan. Silakan isi preferensimu.');
}



}
