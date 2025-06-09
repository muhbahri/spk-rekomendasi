<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HasilRekomendasi;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\JawabanUser;
use App\Models\Negara;
use App\Services\MooraService;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function showPreferensi()
    {
    $pertanyaans = Pertanyaan::with('kriteria')->orderBy('kriteria_id')->orderBy('urutan')->get();
    return view('form.preferensi', compact('pertanyaans'));

    $jawabanCount = JawabanUser::where('user_id', Auth::id())->count();
    if ($jawabanCount > 0) {
    return redirect()->route('hasil.rekomendasi')->with('info', 'Kamu sudah mengisi preferensi sebelumnya, jika ingin mengisikan ulang Konfirmasi pada pihak Rekruter');
}
    }   

    public function submitPreferensi(Request $request)
    {
        $user = Auth::user();

        foreach ($request->input('jawaban') as $id_pertanyaan => $nilai) {
            JawabanUser::create([
                'user_id' => $user->id,
                'pertanyaan_id' => $id_pertanyaan,
                'nilai_jawaban' => $nilai
            ]);
        }

        // 🧠 Hitung MOORA
        $scores = MooraService::hitung($user->id);
        $negaraTerbaikNama = array_key_first($scores);
        $skorTertinggi = $scores[$negaraTerbaikNama];

        $negara = Negara::where('nama', $negaraTerbaikNama)->first();

        if ($negara) {
            HasilRekomendasi::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'negara_id' => $negara->id,
                    'skor' => $skorTertinggi
                ]
            );
        }

        return redirect()->route('hasil.rekomendasi');
    }
}
