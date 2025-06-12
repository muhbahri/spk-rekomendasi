<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilRekomendasi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $users = User::with('hasilRekomendasi.negara')
            ->where('role', 'user')
            ->when($keyword, fn($q) => $q->where('name', 'like', "%$keyword%")->orWhere('email', 'like', "%$keyword%"))
            ->latest()
            ->get();

        // Statistik Ringkas
        $jumlahPMI = $users->count();
        $sudahMengisi = $users->filter(fn($u) => $u->hasilRekomendasi)->count();
        $belumMengisi = $jumlahPMI - $sudahMengisi;

        $trenNegara = HasilRekomendasi::with('negara')
            ->selectRaw('negara_id, COUNT(*) as total')
            ->groupBy('negara_id')
            ->orderByDesc('total')
            ->first();

        $negaraTerbanyak = $trenNegara?->negara?->nama ?? '-';

        return view('admin.dashboard', compact(
            'users', 'keyword',
            'jumlahPMI', 'sudahMengisi', 'belumMengisi', 'negaraTerbanyak'
        ));
    }
}
