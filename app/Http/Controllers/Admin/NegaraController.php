<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Negara;
use Illuminate\Http\Request;

class NegaraController extends Controller
{
    public function index()
    {
        $negaras = Negara::all();
        return view('admin.negara.index', compact('negaras'));
    }

    public function create()
    {
        return view('admin.negara.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:negaras,nama',
        ]);

        Negara::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.negara.index')->with('success', 'Negara berhasil ditambahkan.');
    }

    public function edit(Negara $negara)
    {
        return view('admin.negara.edit', compact('negara'));
    }

    public function update(Request $request, Negara $negara)
    {
        $request->validate([
            'nama' => 'required|string|unique:negaras,nama,' . $negara->id,
        ]);

        $negara->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.negara.index')->with('success', 'Negara berhasil diperbarui.');
    }

    public function destroy(Negara $negara)
    {
        $negara->delete();
        return redirect()->route('admin.negara.index')->with('success', 'Negara berhasil dihapus.');
    }
}
