<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilRekomendasi;
use App\Models\JawabanUser;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function resetPreferensi(User $user): RedirectResponse
    {
        // Hapus jawaban preferensi
        JawabanUser::where('user_id', $user->id)->delete();

        // Hapus hasil rekomendasi
        HasilRekomendasi::where('user_id', $user->id)->delete();

        return back()->with('success', "Jawaban preferensi untuk {$user->name} berhasil direset.");
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $name = Str::slug($request->name);
        $date = now();
        $count = User::whereDate('created_at', $date->toDateString())->count() + 1;
        $email = "{$name}" . str_pad($count, 2, '0', STR_PAD_LEFT) . $date->format('dmY') . "@pmi.id";
        $password = "{$name}" . $date->format('dmY');

        User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'user',
        ]);

        return redirect()->route('admin.dashboard')->with('success', "User berhasil dibuat: {$email}");
    }

}
