<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\OperationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/', function () {
    
});
Route::get('/', [OperationController::class, 'index'])->name('index');

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
})->middleware('auth')->name(name: 'verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ----------wallet---------
Route::get('wallet',[WalletController::class,'wallet'])->middleware('auth')->name('wallet');

//-------add-account wallet--------
Route::post('add-account',[WalletController::class,'add_wallet'])->middleware('auth')->name('wallet.add_wallet');

//-------add-transaction wallet--------
Route::post('add-transaction',[WalletController::class,'add_transaction'])->middleware('auth')->name('wallet.transaction');

//------export transaction
Route::get('/transactions/export', [WalletController::class, 'exportTransactions'])->middleware('auth')->name('transactions.export');

// -------------expenses--------------
Route::get('expenses',[ExpenseController::class,'expenses'])->name('expenses');

//------------create-expense budget.create
Route::post('/create-expenses',[ExpenseController::class,'expenseCreate'])->middleware('auth')->name('budget.create');


// -------------mutualfunds--------------
Route::get('mutualfunds',[StockController::class,'mutualfunds'])->name('mutualfunds');

// -------------stock-search-mutualfunds--------------

Route::get('/stock-data/{id}', [StockController::class, 'stockData'])->name('stocks.data');

// -------------create-stock-mutualfunds--------------
Route::post('/stocks/create', [StockController::class, 'create_stock'])->middleware('auth')->name('stocks.create');


// ------------goals----------
Route::get('goals',[OperationController::class,'goal'])->name('goals');

// -----------create-goal----------
Route::post('/create-goal',[GoalController::class,'goalCreate'])->middleware('auth')->name('goal.create');

// -------------report--------------
Route::get('report',[OperationController::class,'report'])->name('report');

// ------------------calender------------
Route::get('calender',[OperationController::class,'calender'])->name('calender');

