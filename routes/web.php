<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\OperationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


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
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

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

// ----------wallet---------
Route::get('wallet',[OperationController::class,'wallet'])->name('wallet');

//-------add-account wallet--------
Route::post('add-account',[WalletController::class,'add_wallet'])->name('wallet.add_wallet');

//-------add-transaction wallet--------
Route::post('add-transaction',[WalletController::class,'add_transaction'])->name('wallet.transaction');

// -------------expenses--------------
Route::get('expenses',[OperationController::class,'expenses'])->name('expenses');

//------------create-expense budget.create
Route::post('/create-expenses',[ExpenseController::class,'expenseCreate'])->name('budget.create');


// -------------mutualfunds--------------
Route::get('mutualfunds',[OperationController::class,'mutualfunds'])->name('mutualfunds');

Route::get('/stock-data/{id}', [OperationController::class, 'stockData'])->name('stocks.data');

Route::get('/stocks/create', [OperationController::class, 'create_stock'])->name('stocks.create');


// ------------goals----------
Route::get('goals',[OperationController::class,'goal'])->name('goals');

// -----------create-goal----------
Route::post('/create-goal',[GoalController::class,'goalCreate'])->name('goal.create');

// -------------report--------------
Route::get('report',[OperationController::class,'report'])->name('report');

// ------------------calender------------
Route::get('calender',[OperationController::class,'calender'])->name('calender');

