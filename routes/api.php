<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;
// routes/api.php
Route::middleware('api')->get('/expenses/by-date', [ExpenseController::class, 'byDate']);

