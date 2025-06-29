<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\PertanyaanController;
use App\Http\Controllers\Admin\NegaraController;
use App\Http\Controllers\Admin\BobotNegaraController;

// Landing page
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard - auto redirect ke admin / user
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // Dashboard user
    Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Form biodata + preferensi
    Route::get('/biodata', [BiodataController::class, 'show'])->name('biodata.show');
    Route::post('/biodata', [BiodataController::class, 'update'])->name('biodata.update');

    Route::get('/form/preferensi', [FormController::class, 'showPreferensi'])->name('form.preferensi');
    Route::post('/form/preferensi', [FormController::class, 'submitPreferensi'])->name('form.submit');

    // Hasil rekomendasi
    Route::get('/hasil', [HasilController::class, 'show'])->name('hasil.rekomendasi');
});

// ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Kriteria
    Route::resource('kriteria', KriteriaController::class)->except(['show']);

    // Negara
    Route::resource('negara', NegaraController::class)->except(['show']);

    // Pertanyaan
    Route::resource('pertanyaan', PertanyaanController::class)->except(['show']);
    Route::get('/pertanyaan/edit-kriteria/{kriteria}', [PertanyaanController::class, 'editByKriteria'])->name('pertanyaan.edit.kriteria');
    Route::put('/pertanyaan/edit-kriteria/{kriteria}', [PertanyaanController::class, 'updateByKriteria'])->name('pertanyaan.update.kriteria');

    Route::get('/admin/pertanyaan/urutan', function (Illuminate\Http\Request $request) {
        $last = \App\Models\Pertanyaan::where('kriteria_id', $request->kriteria_id)->max('urutan');
        return response()->json(['urutan' => ($last ? $last + 1 : 1)]);
    })->middleware(['auth', 'admin'])->name('admin.pertanyaan.urutan');


    

    // Bobot Negara
    Route::get('bobot-negara', [BobotNegaraController::class, 'index'])->name('bobot-negara.index');
    Route::get('bobot-negara/{negara}/edit', [BobotNegaraController::class, 'edit'])->name('bobot-negara.edit');
    Route::put('bobot-negara/{negara}', [BobotNegaraController::class, 'update'])->name('bobot-negara.update');

    // Manajemen User Calon PMI
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}/reset-preferensi', [UserController::class, 'resetPreferensi'])->name('users.reset');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
});

require __DIR__.'/auth.php';
