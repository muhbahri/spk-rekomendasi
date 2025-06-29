<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all();
        return view('admin.kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:kriterias,nama',
            'is_benefit' => 'required|boolean',
        ]);

        $kriteria = Kriteria::create([
            'nama' => $request->nama,
            'is_benefit' => $request->is_benefit,
        ]);

        return redirect()->route('admin.pertanyaan.create', ['kriteria_id' => $kriteria->id])->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Kriteria $kriteria)
    {
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::find($id);

        // if (!$kriteria) {
        //     abort(404, 'Kriteria tidak ditemukan.');
        // }

        $request->validate([
            'nama' => 'required|string|max:255',
            'is_benefit' => 'required|in:0,1',
        ]);

        $kriteria->update([
            'nama' => $request->nama,
            'is_benefit' => $request->is_benefit,
        ]);

        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }



    public function destroy($id)
    {

        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }

}
