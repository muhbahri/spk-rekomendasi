<?php
namespace App\Services;

use App\Models\Kriteria;
use App\Models\Negara;
use App\Models\JawabanUser;
use App\Models\BobotNegara;

class MooraService
{
    public static function hitung($user_id)
    {
        $userScores = Kriteria::with(['pertanyaans' => function ($q) use ($user_id) {
            $q->with(['jawabanUser' => fn($query) => $query->where('user_id', $user_id)]);
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

        $matrix = [];
        $sumSquares = [];

        foreach (Negara::all() as $negara) {
            $matrix[$negara->nama] = [];
            foreach (Kriteria::all() as $kriteria) {
                $nilai = BobotNegara::where('negara_id', $negara->id)
                    ->where('kriteria_id', $kriteria->id)
                    ->value('nilai_bobot') ?? 0;

                $matrix[$negara->nama][$kriteria->id] = $nilai;
                $sumSquares[$kriteria->id] = ($sumSquares[$kriteria->id] ?? 0) + pow($nilai, 2);
            }
        }

        $scores = [];
        foreach ($matrix as $negara => $kriteriaSet) {
            $Yi = 0;
            foreach ($kriteriaSet as $kriteria_id => $xij) {
                $denom = sqrt($sumSquares[$kriteria_id]);
                $norm = $denom > 0 ? $xij / $denom : 0;
                $isBenefit = Kriteria::find($kriteria_id)->is_benefit;
                $Yi += $isBenefit ? $norm * ($userScores[$kriteria_id] ?? 0) : -($norm * ($userScores[$kriteria_id] ?? 0));
            }
            $scores[$negara] = $Yi;
        }

        arsort($scores);
        return $scores;
    }
}
