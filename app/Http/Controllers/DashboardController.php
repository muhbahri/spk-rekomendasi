<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek apakah user sudah menjawab preferensi
        $sudahMengisiPreferensi = $user->jawabanUser()->exists();

        return view('dashboard', compact('sudahMengisiPreferensi'));
    }
}
