<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BobotNegara;
use App\Models\Negara;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class BobotNegaraController extends Controller
{
    public function index()
    {
        $negaras = Negara::with(['bobotNegaras.kriteria'])->get();
        $kriterias = Kriteria::all();
        return view('admin.bobot-negara.index', compact('negaras', 'kriterias'));
    }

    public function edit(Negara $negara)
    {
        $kriterias = Kriteria::all();
        $bobot = BobotNegara::where('negara_id', $negara->id)->pluck('nilai_bobot', 'kriteria_id');
        return view('admin.bobot-negara.edit', compact('negara', 'kriterias', 'bobot'));
    }

    public function update(Request $request, Negara $negara)
    {
        $request->validate([
            'nilai_bobot' => 'required|array',
            'nilai_bobot.*' => 'nullable|integer|between:1,5',
        ]);

        foreach ($request->nilai_bobot as $kriteria_id => $nilai) {
            BobotNegara::updateOrCreate(
                ['negara_id' => $negara->id, 'kriteria_id' => $kriteria_id],
                ['nilai_bobot' => $nilai]
            );
        }

        return redirect()->route('admin.bobot-negara.index')->with('success', 'Nilai bobot diperbarui.');
    }
}
