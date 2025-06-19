<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Kriteria;
use App\Models\Negara;
use App\Models\JawabanUser;
use App\Models\BobotNegara;
use App\Models\Pertanyaan;

class HasilController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $pertanyaans = Pertanyaan::with([
            'kriteria',
            'jawabanUser' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ])->get();

        // 1. Agregasi nilai jawaban per kriteria user
        $userScores = Kriteria::with(['pertanyaans' => function ($q) use ($user) {
            $q->with(['jawabanUser' => fn($query) => $query->where('user_id', $user->id)]);
        }])->get()->mapWithKeys(function ($kriteria) {
            $total = 0;
            $count = 0;

            foreach ($kriteria->pertanyaans as $p) {
                if ($p->jawabanUser->first()) {
                    $total += $p->jawabanUser->first()->nilai_jawaban;
                    $count++;
                }
            }

            $avg = $count > 0 ? $total / $count : 0;
            return [$kriteria->id => $avg];
        });

        // 2. Ambil data matrix negara (Xij)
        $matrix = [];
        $sumSquares = [];

        foreach (Negara::all() as $negara) {
            $matrix[$negara->nama] = [];
            foreach (Kriteria::all() as $kriteria) {
                if (!isset($sumSquares[$kriteria->id]) || $sumSquares[$kriteria->id] == 0) {
        
    }
                // Ambil nilai bobot untuk negara dan kriteria
                $nilai = BobotNegara::where('negara_id', $negara->id)
                    ->where('kriteria_id', $kriteria->id)
                    ->value('nilai_bobot');

                $matrix[$negara->nama][$kriteria->id] = $nilai;
                $sumSquares[$kriteria->id] = ($sumSquares[$kriteria->id] ?? 0) + pow($nilai, 2);
            }
        }

        // 3. Normalisasi & Hitung Yi
        $scores = [];
        foreach ($matrix as $negara => $kriteriaSet) {
            $Yi = 0;
            foreach ($kriteriaSet as $kriteria_id => $xij) {
                $denom = sqrt($sumSquares[$kriteria_id]);
                $norm = $denom > 0 ? $xij / $denom : 0;
                
                $isBenefit = Kriteria::find($kriteria_id)->is_benefit;

                $Yi += $isBenefit ? $norm * $userScores[$kriteria_id] : -($norm * $userScores[$kriteria_id]);
            }
            $scores[$negara] = $Yi;
        }

        // 4. Urutkan dan kirim ke view
        arsort($scores);
        $topCountry = array_key_first($scores);
        $alternatifCountries = array_slice($scores, 1, 4, true);

        // dd([
        //     'userScores' => $userScores,
        //     'matrix' => $matrix,
        //     'sumSquares' => $sumSquares,
        //     'scores' => $scores,
        // ]);
        return view('hasil.index', compact('scores', 'topCountry', 'alternatifCountries'));
        

    }
}
