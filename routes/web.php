<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LearningHomeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\VolunteerController as AdminVolunteerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');
});

// Volunteer Routes
Route::middleware(['auth', 'role:volunteer'])->prefix('volunteer')->name('volunteer.')->group(function () {
    Route::get('/dashboard', [VolunteerController::class, 'dashboard'])->name('dashboard');
    Route::get('/attend/{schedule}/{token}', [VolunteerController::class, 'showAttend'])->name('attend.show');
    Route::post('/attend/{schedule}/{token}', [VolunteerController::class, 'processAttend'])->name('attend.process');
    Route::get('/schedules', [VolunteerController::class, 'schedules'])->name('schedules');
    Route::get('/reports', [VolunteerController::class, 'reports'])->name('reports');
    Route::get('/reports/create', [VolunteerController::class, 'createReport'])->name('reports.create');
    Route::post('/reports', [VolunteerController::class, 'storeReport'])->name('reports.store')->middleware('throttle:3,1');
    Route::get('/announcements', [VolunteerController::class, 'announcements'])->name('announcements');
    Route::get('/profile', [VolunteerController::class, 'profile'])->name('profile');
    Route::post('/profile', [VolunteerController::class, 'updateProfile'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/settings/toggle-registration', [DashboardController::class, 'toggleRegistration'])->name('settings.toggle-registration');

    Route::get('/volunteers', [AdminVolunteerController::class, 'index'])->name('volunteers');
    Route::get('/volunteers/{volunteer}', [AdminVolunteerController::class, 'show'])->name('volunteers.show');
    Route::patch('/volunteers/{volunteer}/status', [AdminVolunteerController::class, 'updateStatus'])->name('volunteers.updateStatus');

    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/{schedule}/qr', [ScheduleController::class, 'showQrCode'])->name('schedules.qr');
    Route::patch('/schedules/{schedule}/status', [ScheduleController::class, 'updateStatus'])->name('schedules.updateStatus');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

    Route::get('/learning-homes', [LearningHomeController::class, 'index'])->name('learning-homes');
    Route::post('/learning-homes', [LearningHomeController::class, 'store'])->name('learning-homes.store');
    Route::put('/learning-homes/{learningHome}', [LearningHomeController::class, 'update'])->name('learning-homes.update');
    Route::delete('/learning-homes/{learningHome}', [LearningHomeController::class, 'destroy'])->name('learning-homes.destroy');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/export', [ReportController::class, 'exportCsv'])->name('reports.export');

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    Route::get('/galleries', [GalleryController::class, 'index'])->name('galleries');
    Route::post('/galleries', [GalleryController::class, 'store'])->name('galleries.store');
    Route::put('/galleries/{gallery}', [GalleryController::class, 'update'])->name('galleries.update');
    Route::delete('/galleries/{gallery}', [GalleryController::class, 'destroy'])->name('galleries.destroy');

    Route::get('/activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs');
});
