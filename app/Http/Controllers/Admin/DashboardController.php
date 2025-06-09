<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $users = User::with('hasilRekomendasi.negara')
            ->where('role', 'user')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            })
            ->latest()
            ->get();


        return view('admin.dashboard', compact('users', 'keyword'));
    }
}
