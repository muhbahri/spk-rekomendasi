<?php

namespace App\Http\Controllers;

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

        // 1. Ambil dan hitung bobot rata-rata jawaban user per kriteria
        $userScores = Kriteria::with(['pertanyaans' => function ($q) use ($user) {
            $q->with(['jawabanUser' => fn($query) => $query->where('user_id', $user->id)]);
        }])->get()->mapWithKeys(function ($kriteria) use ($user) {
            $total = 0;
            $count = 0;

            foreach ($kriteria->pertanyaans as $p) {
                if ($j = $p->jawabanUser->first()) {
                    $total += $j->nilai_jawaban;
                    $count++;
                }
            }

            $avg = $count > 0 ? $total / $count : 0;
            return [$kriteria->id => $avg];
        })->toArray();

        // 2. Normalisasi bobot agar total 1
        $totalWeight = array_sum($userScores);
        if ($totalWeight > 0) {
            foreach ($userScores as $kriteriaId => $w) {
                $userScores[$kriteriaId] = ($w / $totalWeight);
            }
        }

        // 3. Ambil data bobot negara per kriteria
        $matrix = [];
        $sumSquares = [];
        $negaraList = Negara::all();
        $kriteriaList = Kriteria::all();

        foreach ($negaraList as $negara) {
            $matrix[$negara->nama] = [];
            foreach ($kriteriaList as $kriteria) {
                $nilai = BobotNegara::where('negara_id', $negara->id)
                    ->where('kriteria_id', $kriteria->id)
                    ->value('nilai_bobot') ?? 0;

                $matrix[$negara->nama][$kriteria->id] = $nilai;
                $sumSquares[$kriteria->id] = ($sumSquares[$kriteria->id] ?? 0) + pow($nilai, 2);
            }
        }

        // 4. Hitung skor MOORA Yi
        $scores = [];

        foreach ($matrix as $negaraName => $kriteriaValues) {
            $Yi = 0;

            foreach ($kriteriaValues as $kriteriaId => $xij) {
                $denom = sqrt($sumSquares[$kriteriaId] ?? 1); // hindari 0

                // r_ij: normalisasi matriks
                $r = $denom > 0 ? ($xij / $denom) : 0;

                $isBenefit = optional(Kriteria::find($kriteriaId))->is_benefit;
                $weight = ($userScores[$kriteriaId] ?? 0);

                $Yi += $isBenefit ? ($r * $weight) : -($r * $weight);
            }

            $scores[$negaraName] = round($Yi, 3); // membulatkan hasil akhir
        }

        arsort($scores);

        $topCountry = array_key_first($scores);
        $alternatifCountries = array_slice($scores, 1, 4, true);

        return view('hasil.index', compact('scores', 'topCountry', 'alternatifCountries', 'userScores'));
    }
}
