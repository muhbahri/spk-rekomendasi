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
        return view('admin.pertanyaan.index', compact('pertanyaans'));
    }

    public function create()
    {
        $kriterias = Kriteria::all();
        return view('admin.pertanyaan.create', compact('kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'kriteria_id' => 'required|exists:kriterias,id',
            'urutan' => 'required|integer|min:1',
        ]);

        Pertanyaan::create($request->only('pertanyaan', 'kriteria_id', 'urutan'));

        return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit(Pertanyaan $pertanyaan)
    {
        $kriterias = Kriteria::all();
        return view('admin.pertanyaan.edit', compact('pertanyaan', 'kriterias'));
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
