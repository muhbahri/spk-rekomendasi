<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function index()
    {
        $pertanyaans = Pertanyaan::with('kriteria')->orderBy('kriteria_id')->get();
        $kriterias = \App\Models\Kriteria::all(); // Tambahkan ini

        return view('admin.pertanyaan.index', compact('pertanyaans', 'kriterias'));     
    }

    public function create( Request $request)
    {
        $kriterias = Kriteria::all();
        $selectedKriteriaId = $request->get('kriteria_id');
        return view('admin.pertanyaan.create', compact('kriterias', 'selectedKriteriaId'));
    }

    public function store(Request $request)
{
    if (is_string($request->pertanyaan)) {
        $request->merge(['pertanyaan' => [$request->pertanyaan]]);
    }

    $request->validate([
        'pertanyaan' => 'required|array|min:1|max:3',
        'pertanyaan.*' => 'required|string',
        'kriteria_id' => 'required|exists:kriterias,id',
    ]);

    $lastUrutan = Pertanyaan::where('kriteria_id', $request->kriteria_id)->max('urutan') ?? 0;

    foreach ($request->pertanyaan as $i => $p) {
        Pertanyaan::create([
            'pertanyaan' => $p,
            'kriteria_id' => $request->kriteria_id,
            'urutan' => $lastUrutan + $i + 1,
        ]);
    }

    return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
}



    public function edit(Pertanyaan $pertanyaan)
    {
        $kriterias = Kriteria::all();
        return view('admin.pertanyaan.edit', compact('pertanyaan', 'kriterias'));
    }

    public function editByKriteria($kriteriaId)
    {
        $kriteria = Kriteria::findOrFail($kriteriaId);
        $kriterias = Kriteria::all();
        $pertanyaans = $kriteria->pertanyaans()->orderBy('urutan')->get();

        return view('admin.pertanyaan.edit', compact('kriteria', 'pertanyaans', 'kriterias'));
    }

    public function updateByKriteria(Request $request, $kriteriaId)
    {
        $data = $request->validate([
            'pertanyaan' => 'required|array|size:3', // wajib 3 pertanyaan
            'pertanyaan.*.id' => 'required|exists:pertanyaans,id',
            'pertanyaan.*.teks' => 'required|string',
            'pertanyaan.*.urutan' => 'required|integer|min:1|max:3',
        ]);

        $urutans = array_column($data['pertanyaan'], 'urutan');
        if (count($urutans) !== count(array_unique($urutans))) {
            return back()->withErrors(['urutan' => 'Urutan pertanyaan tidak boleh sama'])->withInput();
        }

        foreach ($data['pertanyaan'] as $p) {
            \App\Models\Pertanyaan::where('id', $p['id'])->update([
                'pertanyaan' => $p['teks'],
                'urutan' => $p['urutan'],
            ]);
        }

        return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil diperbarui.');
    }



    public function update(Request $request, Pertanyaan $pertanyaan)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'kriteria_id' => 'required|exists:kriterias,id',
            'urutan' => 'required|integer|min:1',
        ]);

        $pertanyaan->update($request->only('pertanyaan', 'kriteria_id', 'urutan'));

        return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy(Pertanyaan $pertanyaan)
    {
        $pertanyaan->delete();
        return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
