<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index']);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Volunteer Routes
Route::middleware(['auth', 'role:volunteer'])->prefix('volunteer')->group(function () {
    Route::get('/dashboard', [VolunteerController::class, 'dashboard']);
    Route::get('/schedules', [VolunteerController::class, 'schedules']);
    Route::get('/reports', [VolunteerController::class, 'reports']);
    Route::get('/reports/create', [VolunteerController::class, 'createReport']);
    Route::post('/reports', [VolunteerController::class, 'storeReport']);
    Route::get('/announcements', [VolunteerController::class, 'announcements']);
    Route::get('/profile', [VolunteerController::class, 'profile']);
    Route::post('/profile', [VolunteerController::class, 'updateProfile']);
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/volunteers', [AdminController::class, 'volunteers']);
    Route::get('/volunteers/{volunteer}', [AdminController::class, 'showVolunteer']);
    Route::patch('/volunteers/{volunteer}/status', [AdminController::class, 'updateVolunteerStatus']);
    
    Route::get('/schedules', [AdminController::class, 'schedules']);
    Route::post('/schedules', [AdminController::class, 'storeSchedule']);
    Route::patch('/schedules/{schedule}/status', [AdminController::class, 'updateScheduleStatus']);
    Route::delete('/schedules/{schedule}', [AdminController::class, 'deleteSchedule']);
    
    Route::get('/learning-homes', [AdminController::class, 'learningHomes']);
    Route::post('/learning-homes', [AdminController::class, 'storeLearningHome']);
    Route::put('/learning-homes/{learningHome}', [AdminController::class, 'updateLearningHome']);
    Route::delete('/learning-homes/{learningHome}', [AdminController::class, 'deleteLearningHome']);
    
    Route::get('/reports', [AdminController::class, 'reports']);
    
    Route::get('/announcements', [AdminController::class, 'announcements']);
    Route::post('/announcements', [AdminController::class, 'storeAnnouncement']);
    Route::put('/announcements/{announcement}', [AdminController::class, 'updateAnnouncement']);
    Route::delete('/announcements/{announcement}', [AdminController::class, 'deleteAnnouncement']);
    
    Route::get('/galleries', [AdminController::class, 'galleries']);
    Route::post('/galleries', [AdminController::class, 'storeGallery']);
    Route::put('/galleries/{gallery}', [AdminController::class, 'updateGallery']);
    Route::delete('/galleries/{gallery}', [AdminController::class, 'deleteGallery']);
});
