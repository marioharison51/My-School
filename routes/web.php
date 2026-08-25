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
        Route::get('/admin', function () {
            $totalStudents = \App\Models\Student::count();
            $totalTeachers = \App\Models\User::where('role', 'enseignant')->count();
            $totalPayments = \App\Models\Payment::sum('amount');
            $recentPayments = \App\Models\Payment::with('student')->latest('paid_at')->limit(5)->get();

            return view('dashboards.admin', compact('totalStudents', 'totalTeachers', 'totalPayments', 'recentPayments'));
        })->name('admin.dashboard');

        Route::get('/admin/users', [\App\Http\Controllers\UserManagementController::class, 'index'])
            ->name('admin.users.index');
        Route::patch('/admin/users/{user}/role', [\App\Http\Controllers\UserManagementController::class, 'updateRole'])
            ->name('admin.users.updateRole');
    });

    Route::middleware('role:enseignant')->group(function () {
        Route::get('/enseignant', function () {
            $myCourses = \App\Models\Course::count();
            $totalStudents = \App\Models\Student::count();
            $upcomingExams = \App\Models\Exam::orderBy('exam_date')->limit(5)->get();

            return view('dashboards.enseignant', compact('myCourses', 'totalStudents', 'upcomingExams'));
        })->name('enseignant.dashboard');
    });

    Route::middleware('role:eleve')->group(function () {
        Route::get('/eleve', function () {
            $student = auth()->user()->student;
            $payments = $student ? $student->payments()->latest('paid_at')->limit(5)->get() : collect();

            return view('dashboards.eleve', compact('student', 'payments'));
        })->name('eleve.dashboard');
    });

    Route::middleware('role:parent')->group(function () {
        Route::get('/parent', function () {
            $children = auth()->user()->children()->with(['payments' => function ($q) {
                $q->latest('paid_at')->limit(3);
            }])->get();

            return view('dashboards.parent', compact('children'));
        })->name('parent.dashboard');
    });

    Route::middleware('role:comptable')->group(function () {
        Route::get('/comptable', function () {
            $totalPayments = \App\Models\Payment::sum('amount');
            $paymentsCount = \App\Models\Payment::count();
            $recentPayments = \App\Models\Payment::with('student', 'recordedBy')->latest('paid_at')->limit(10)->get();
            $byMethod = \App\Models\Payment::selectRaw('method, SUM(amount) as total')->groupBy('method')->get();

            return view('dashboards.comptable', compact('totalPayments', 'paymentsCount', 'recentPayments', 'byMethod'));
        })->name('comptable.dashboard');
    });

    // ---------- Module Élèves ----------
    Route::middleware('role:administrateur,enseignant')->group(function () {
        Route::resource('students', \App\Http\Controllers\StudentController::class)
            ->except(['destroy']);
    });

    Route::middleware('role:administrateur')->group(function () {
        Route::delete('/students/{student}', [\App\Http\Controllers\StudentController::class, 'destroy'])
            ->name('students.destroy');
    });

    // ---------- Module Paiements ----------
    Route::middleware('role:administrateur,comptable')->group(function () {
        Route::get('/students/{student}/payments', [\App\Http\Controllers\PaymentController::class, 'index'])
            ->name('payments.index');
        Route::get('/students/{student}/payments/create', [\App\Http\Controllers\PaymentController::class, 'create'])
            ->name('payments.create');
        Route::post('/students/{student}/payments', [\App\Http\Controllers\PaymentController::class, 'store'])
            ->name('payments.store');
        Route::get('/students/{student}/payments/{payment}/receipt', [\App\Http\Controllers\PaymentReceiptController::class, 'show'])
            ->name('payments.receipt');
    });

    // ---------- Écolage : montant mensuel par élève (admin) ----------
    Route::middleware('role:administrateur')->group(function () {
        Route::get('/students/{student}/fee', [\App\Http\Controllers\StudentFeeController::class, 'edit'])
            ->name('student-fees.edit');
        Route::put('/students/{student}/fee', [\App\Http\Controllers\StudentFeeController::class, 'update'])
            ->name('student-fees.update');
    });

    // ---------- Factures / échéances ----------
    Route::middleware('role:administrateur,comptable')->group(function () {
        Route::get('/invoices', [\App\Http\Controllers\InvoiceController::class, 'index'])
            ->name('invoices.index');
        Route::get('/students/{student}/invoices', [\App\Http\Controllers\InvoiceController::class, 'forStudent'])
            ->name('invoices.student');
    });

    // ---------- Blocage / déblocage de comptes (admin / direction) ----------
    Route::middleware('role:administrateur')->group(function () {
        Route::post('/accounts/{user}/block-parent', [\App\Http\Controllers\AdminAccountController::class, 'blockParent'])
            ->name('accounts.blockParent');
        Route::post('/accounts/{user}/block-student', [\App\Http\Controllers\AdminAccountController::class, 'blockStudent'])
            ->name('accounts.blockStudent');
        Route::post('/accounts/{user}/unblock', [\App\Http\Controllers\AdminAccountController::class, 'unblock'])
            ->name('accounts.unblock');
        Route::post('/students/{student}/graduate', [\App\Http\Controllers\AdminAccountController::class, 'markGraduated'])
            ->name('students.markGraduated');
        Route::delete('/students/{student}/expel', [\App\Http\Controllers\AdminAccountController::class, 'destroy'])
            ->name('students.expel');
    });

    // ---------- Blocage / déblocage temporaire (enseignant) ----------
    Route::middleware('role:enseignant')->group(function () {
        Route::post('/students/{student}/teacher-block', [\App\Http\Controllers\TeacherAccountController::class, 'block'])
            ->name('teacher.students.block');
        Route::post('/students/{student}/teacher-unblock', [\App\Http\Controllers\TeacherAccountController::class, 'unblockTemporary'])
            ->name('teacher.students.unblockTemporary');
    });

    // ---------- Blocage / déblocage pour paiement (comptable) ----------
    Route::middleware('role:comptable')->group(function () {
        Route::post('/accounts/{user}/accountant-block', [\App\Http\Controllers\AccountantAccountController::class, 'block'])
            ->name('accountant.accounts.block');
        Route::post('/accounts/{user}/unblock-missed-payments', [\App\Http\Controllers\AccountantAccountController::class, 'unblockAfterMissedPayments'])
            ->name('accountant.accounts.unblockMissedPayments');
        Route::post('/accounts/{user}/unblock-late-payment', [\App\Http\Controllers\AccountantAccountController::class, 'unblockAfterLatePayment'])
            ->name('accountant.accounts.unblockLatePayment');
    });

    // ---------- Module Cours (gestion admin/enseignant) ----------
    Route::middleware('role:administrateur,enseignant')->group(function () {
        Route::resource('courses', \App\Http\Controllers\CourseController::class)
            ->except(['show']);

        // Ressources de cours (PDF, vidéos, quiz)
        Route::get('/courses/{course}/resources', [\App\Http\Controllers\CourseResourceController::class, 'index'])
            ->name('courses.resources.index');
        Route::get('/courses/{course}/resources/create', [\App\Http\Controllers\CourseResourceController::class, 'create'])
            ->name('courses.resources.create');
        Route::post('/courses/{course}/resources', [\App\Http\Controllers\CourseResourceController::class, 'store'])
            ->name('courses.resources.store');
        Route::delete('/courses/{course}/resources/{resource}', [\App\Http\Controllers\CourseResourceController::class, 'destroy'])
            ->name('courses.resources.destroy');
    });

    // ---------- Consultation des cours (élève / parent) ----------
    Route::middleware(['role:eleve,parent', 'exam.block'])->group(function () {
        Route::get('/mes-cours', [\App\Http\Controllers\StudentCourseController::class, 'index'])
            ->name('student.courses.index');
        Route::get('/mes-cours/{course}', [\App\Http\Controllers\StudentCourseController::class, 'show'])
            ->name('student.courses.show');
    });

    // ---------- Gestion de la période d'examens (admin uniquement) ----------
    Route::middleware('role:administrateur')->group(function () {
        Route::get('/exam-periods', [\App\Http\Controllers\ExamPeriodController::class, 'index'])
            ->name('exam-periods.index');
        Route::post('/exam-periods', [\App\Http\Controllers\ExamPeriodController::class, 'store'])
            ->name('exam-periods.store');
        Route::patch('/exam-periods/{examPeriod}/toggle', [\App\Http\Controllers\ExamPeriodController::class, 'toggle'])
            ->name('exam-periods.toggle');
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

    // ---------- Module Communication ----------
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])
        ->name('messages.index');
    Route::get('/messages/create', [\App\Http\Controllers\MessageController::class, 'create'])
        ->name('messages.create');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])
        ->name('messages.store');
    Route::get('/messages/{message}', [\App\Http\Controllers\MessageController::class, 'show'])
        ->name('messages.show');

    // ---------- Annonces & Événements ----------
    Route::get('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'index'])
        ->name('announcements.index');
    Route::middleware('role:administrateur')->group(function () {
        Route::get('/announcements/create', [\App\Http\Controllers\AnnouncementController::class, 'create'])
            ->name('announcements.create');
        Route::post('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'store'])
            ->name('announcements.store');
        Route::delete('/announcements/{announcement}', [\App\Http\Controllers\AnnouncementController::class, 'destroy'])
            ->name('announcements.destroy');
    });

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
