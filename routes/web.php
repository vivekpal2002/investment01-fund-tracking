<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('contents/index');
});
// -----login------
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/get-login', [AuthController::class, 'get_login'])->name('get_login');

// --------register------
Route::get('/register',[AuthController::class, 'register'])->name('register');
Route::post('/get-register', [AuthController::class, 'get_register'])->name('get_register');

// --------log-out------
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ------- email-verify---------
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
