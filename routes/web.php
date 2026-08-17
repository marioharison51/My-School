<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    // Redirection générique après connexion selon le rôle
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return redirect()->route(\App\Enums\Role::from($role)->dashboardRoute());
    })->name('dashboard');

    Route::middleware('role:administrateur')->group(function () {
        Route::get('/admin', fn () => view('dashboards.admin'))->name('admin.dashboard');
    });

    Route::middleware('role:enseignant')->group(function () {
        Route::get('/enseignant', fn () => view('dashboards.enseignant'))->name('enseignant.dashboard');
    });

    Route::middleware('role:eleve')->group(function () {
        Route::get('/eleve', fn () => view('dashboards.eleve'))->name('eleve.dashboard');
    });

    Route::middleware('role:parent')->group(function () {
        Route::get('/parent', fn () => view('dashboards.parent'))->name('parent.dashboard');
    });

    Route::middleware('role:comptable')->group(function () {
        Route::get('/comptable', fn () => view('dashboards.comptable'))->name('comptable.dashboard');
    });

    Route::middleware('role:administrateur,enseignant')->group(function () {
        Route::resource('students', \App\Http\Controllers\StudentController::class);
    });

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
