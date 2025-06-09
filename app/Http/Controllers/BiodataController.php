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
        'keterampilan' => 'required|string',
        'pengalaman_kerja' => 'required|string',
    ]);

    $user = Auth::user();

    $user->usia = $request->usia;
    $user->keterampilan = $request->keterampilan;
    $user->pengalaman_kerja = $request->pengalaman_kerja;
    $user->save();

    $sudahIsi = \App\Models\JawabanUser::where('user_id', $user->id)->exists();

    if ($sudahIsi) {
        return redirect()->route('hasil.rekomendasi')->with('info', 'Kamu sudah pernah mengisi preferensi. Ini hasil rekomendasimu.');
    }

    // Kalau belum isi, lanjut ke form preferensi
    return redirect()->route('form.preferensi')->with('success', 'Biodata berhasil disimpan. Silakan isi preferensimu.');
}


}
