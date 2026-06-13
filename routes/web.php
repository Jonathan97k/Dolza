<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MediaController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('properties', AdminPropertyController::class)->names('admin.properties');
        Route::patch('properties/{id}/status', [AdminPropertyController::class, 'updateStatus'])->name('admin.properties.status');
        Route::resource('team', TeamController::class)->names('admin.team');
        Route::resource('testimonials', TestimonialController::class)->names('admin.testimonials');
        Route::resource('inquiries', InquiryController::class)->only(['index', 'show', 'destroy'])->names('admin.inquiries');
        Route::patch('inquiries/{id}/read', [InquiryController::class, 'markRead'])->name('admin.inquiries.read');
        Route::get('content', [ContentController::class, 'index'])->name('admin.content');
        Route::put('content/{section}', [ContentController::class, 'update'])->name('admin.content.update');
        Route::get('settings', [SettingController::class, 'index'])->name('admin.settings');
        Route::put('settings', [SettingController::class, 'update'])->name('admin.settings.update');
        Route::post('upload', [MediaController::class, 'upload'])->name('admin.upload');
        Route::get('images', [MediaController::class, 'index'])->name('admin.images');
        Route::delete('images/{name}', [MediaController::class, 'destroy'])->name('admin.images.destroy');
    });
});
