<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public SaaS Marketing & School Registration
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/register-school', [LandingController::class, 'showRegisterForm'])->name('register.school');
Route::post('/register-school', [LandingController::class, 'registerTenant']);

// Multi-role global Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Tenant-scoped Authentication and Expired page
Route::get('/s/{slug}/login', [AuthController::class, 'showLoginForm'])->name('school.login');
Route::post('/s/{slug}/login', [AuthController::class, 'login']);
Route::get('/s/{slug}/expired', [AuthController::class, 'expired'])->name('tenant.expired');

// 1. SuperAdmin (SaaS Owner Panel)
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/tenant/{id}/status', [SuperAdminController::class, 'updateStatus'])->name('tenant.status');
    Route::post('/tenant/{id}/extend', [SuperAdminController::class, 'extendPackage'])->name('tenant.extend');
    Route::delete('/tenant/{id}', [SuperAdminController::class, 'deleteTenant'])->name('tenant.delete');
});

// 2. Tenant Admin (School Control Panel)
Route::middleware(['auth', 'tenant', 'role:admin'])->prefix('s/{slug}/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Majors
    Route::get('/majors', [AdminController::class, 'majors'])->name('majors');
    Route::post('/majors', [AdminController::class, 'storeMajor']);
    Route::delete('/majors/{id}', [AdminController::class, 'deleteMajor'])->name('major.delete');

    // Classes
    Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
    Route::post('/classes', [AdminController::class, 'storeClass']);
    Route::delete('/classes/{id}', [AdminController::class, 'deleteClass'])->name('class.delete');

    // Subjects
    Route::get('/subjects', [AdminController::class, 'subjects'])->name('subjects');
    Route::post('/subjects', [AdminController::class, 'storeSubject']);
    Route::delete('/subjects/{id}', [AdminController::class, 'deleteSubject'])->name('subject.delete');

    // Teachers
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('teachers');
    Route::post('/teachers', [AdminController::class, 'storeTeacher']);
    Route::delete('/teachers/{id}', [AdminController::class, 'deleteTeacher'])->name('teacher.delete');

    // Students
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::post('/students', [AdminController::class, 'storeStudent']);
    Route::delete('/students/{id}', [AdminController::class, 'deleteStudent'])->name('student.delete');
});

// 3. Teacher Module
Route::middleware(['auth', 'tenant', 'role:teacher'])->prefix('s/{slug}/teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    
    // Questions bank
    Route::get('/questions', [TeacherController::class, 'questions'])->name('questions');
    Route::post('/questions', [TeacherController::class, 'storeQuestion']);
    Route::delete('/questions/{id}', [TeacherController::class, 'deleteQuestion'])->name('question.delete');

    // Exam scheduling
    Route::get('/exams', [TeacherController::class, 'exams'])->name('exams');
    Route::post('/exams', [TeacherController::class, 'storeExam']);
    Route::post('/exams/{id}/toggle', [TeacherController::class, 'toggleExam'])->name('exam.toggle');
    Route::delete('/exams/{id}', [TeacherController::class, 'deleteExam'])->name('exam.delete');

    // Results rekap
    Route::get('/results', [TeacherController::class, 'results'])->name('results');
});

// 4. Student Module (CBT exam runner)
Route::middleware(['auth', 'tenant', 'role:student'])->prefix('s/{slug}')->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/exams', [StudentController::class, 'exams'])->name('student.exams');
    Route::post('/student/exam/{id}/start', [StudentController::class, 'startExam'])->name('student.exam.start');
    
    // CBT Exam Engine
    Route::get('/exam/{id}', [StudentController::class, 'examPage'])->name('student.exam.page');
    Route::post('/exam/{id}/save', [StudentController::class, 'saveAnswer'])->name('student.exam.save');
    Route::post('/exam/{id}/submit', [StudentController::class, 'submitExam'])->name('student.exam.submit');
});
