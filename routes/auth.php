<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::post('request-otp', [AuthenticatedSessionController::class, 'sendOtp'])
    ->middleware('auth')
    ->name('request-otp');

Route::post('verify-otp', [AuthenticatedSessionController::class, 'verifyOtp'])
    ->middleware('auth')
    ->name('verify-otp');

Route::group(['prefix' => 'doc', 'middleware' => 'doctor_routes'], function () {
    Route::get('/get-patients', [DocController::class, 'getPatients'])
        ->middleware('auth')
        ->name('get-patients');

    Route::get('/get-patients-consultations', [DocController::class, 'getPatientConsultations'])
        ->middleware('auth')
        ->name('get-patients-consultations');

    Route::get('/get-patients-history', [DocController::class, 'getPatientHistory'])
        ->middleware('auth')
        ->name('get-patients-history');

    Route::post('/update-patient-demographics', [DocController::class, 'addUpdatePatientDemographic'])
        ->middleware('auth')
        ->name('update-patient-demographics');

    Route::post('/add-patient-consultation', [DocController::class, 'addConsultation'])
        ->middleware('auth')
        ->name('add-patient-demographics');
});
