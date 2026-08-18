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

    // ---------- Module Élèves ----------
    Route::middleware('role:administrateur,enseignant')->group(function () {
        Route::resource('students', \App\Http\Controllers\StudentController::class);
    });

    // ---------- Module Paiements ----------
    Route::middleware('role:administrateur,comptable')->group(function () {
        Route::get('/students/{student}/payments', [\App\Http\Controllers\PaymentController::class, 'index'])
            ->name('payments.index');
        Route::get('/students/{student}/payments/create', [\App\Http\Controllers\PaymentController::class, 'create'])
            ->name('payments.create');
        Route::post('/students/{student}/payments', [\App\Http\Controllers\PaymentController::class, 'store'])
            ->name('payments.store');
    });

    // ---------- Module Cours ----------
    Route::middleware('role:administrateur,enseignant')->group(function () {
        Route::resource('courses', \App\Http\Controllers\CourseController::class)
            ->except(['show']);
    });

    // ---------- Module Examens ----------
    Route::middleware('role:administrateur,enseignant')->group(function () {

        // Planification des examens
        Route::resource('exams', \App\Http\Controllers\ExamController::class)
            ->except(['show']);

        // Saisie des notes pour un examen donné
        Route::get('/exams/{exam}/grades', [\App\Http\Controllers\GradeController::class, 'edit'])
            ->name('grades.edit');
        Route::put('/exams/{exam}/grades', [\App\Http\Controllers\GradeController::class, 'update'])
            ->name('grades.update');

        // Bulletins
        Route::get('/bulletins', [\App\Http\Controllers\BulletinController::class, 'select'])
            ->name('bulletins.select');
        Route::get('/bulletins/{student}', [\App\Http\Controllers\BulletinController::class, 'show'])
            ->name('bulletins.show');

    });

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
