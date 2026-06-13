<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MediaController;

Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/team', [TeamController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::post('/inquiries', [InquiryController::class, 'store']);
Route::get('/content', [ContentController::class, 'index']);
Route::get('/settings', [SettingController::class, 'index']);
Route::get('/site-images', [MediaController::class, 'siteImages']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/session', [AuthController::class, 'session'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/properties', [PropertyController::class, 'store']);
    Route::put('/properties/{id}', [PropertyController::class, 'update']);
    Route::patch('/properties/{id}/status', [PropertyController::class, 'updateStatus']);
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);
    Route::post('/team', [TeamController::class, 'store']);
    Route::put('/team/{id}', [TeamController::class, 'update']);
    Route::delete('/team/{id}', [TeamController::class, 'destroy']);
    Route::post('/testimonials', [TestimonialController::class, 'store']);
    Route::put('/testimonials/{id}', [TestimonialController::class, 'update']);
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy']);
    Route::get('/inquiries', [InquiryController::class, 'index']);
    Route::patch('/inquiries/{id}', [InquiryController::class, 'update']);
    Route::delete('/inquiries/{id}', [InquiryController::class, 'destroy']);
    Route::put('/content/{section}', [ContentController::class, 'update']);
    Route::put('/settings', [SettingController::class, 'update']);
    Route::post('/upload-logo', [MediaController::class, 'uploadLogo']);
    Route::post('/upload', [MediaController::class, 'upload']);
    Route::get('/images', [MediaController::class, 'index']);
    Route::delete('/images/{name}', [MediaController::class, 'destroy']);
});
