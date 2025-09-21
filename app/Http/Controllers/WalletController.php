<?php

namespace App\Http\Controllers;

use App\Models\wallet;
use App\Models\transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function add_wallet(Request $request){
     $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'balance' => 'required|numeric|min:0',
        'type' => 'required|exists:categories,id',
        'bank_name' => 'nullable|string|max:255',
        'expiry_date' => 'nullable|date_format:Y-m', // only for Credit/Debit cards
        'notes' => 'nullable|string|max:500',
        'acc_created_at' => 'nullable|date',
    ]);

    // Save account
    $account = new wallet();
    $account->user_id = Auth::id();
    $account->name = $validatedData['name'];
    $account->balance = $validatedData['balance'];
    $account->bank_name = $validatedData['bank_name'] ;
    $account->type = $validatedData['type'];
    $account->expiry_date =$request->expiry_date ? $request->expiry_date . '-01' : null;;
    $account->notes = $validatedData['notes'] ?? null;
    $account->acc_created_at = $validatedData['acc_created_at'] ?? now();
    $account->save();

    return redirect()->back()->with('success', 'Account created successfully!');
    }

    public function add_transaction(Request $request){

        $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|exists:categories,id',   // must match a category (Income/Expense/Transfer)
        'amount' => 'required|numeric|min:0.01',    // positive number only
        'wallet_id' => 'required|exists:wallets,id', // must be a valid wallet
        'category_id' => 'nullable|exists:categories,id', // optional, but must exist if provided
        'date' => 'required|date',
        'notes' => 'nullable|string|max:500',
        'status' => 'required|in:' . implode(',', config('app.transaction_statuses')),
        'payment_type' => 'required|in:' . implode(',', config('app.payment_type')),

    ]);

    // Save transaction
    $transaction = new transaction();
    $transaction->title = $validatedData['title'];
    $transaction->type = $validatedData['type'];
    $transaction->amount = $validatedData['amount'];
    $transaction->payment_type = array_search($validatedData['payment_type'], config('app.payment_type'));
    $transaction->wallet_id = $validatedData['wallet_id'];
    $transaction->category_id = $validatedData['category_id'] ?? null;
    $transaction->date = $validatedData['date'];
    $transaction->user_id = Auth::id();
    $transaction->status =array_search($validatedData['payment_type'], config('app.transaction_statuses'));
    $transaction->notes = $validatedData['notes'] ?? null;
    $transaction->save();

    // Update wallet balance
    $wallet = wallet::where('user_id',Auth::id())->find($validatedData['wallet_id']);
    if ($wallet) {
        if ($validatedData['payment_type'] == 'Money received') { // Income
            $wallet->balance += $validatedData['amount'];
        } elseif ($validatedData['payment_type'] == 'Money sent') { // Expense
            $wallet->balance -= $validatedData['amount'];
        }
    }
        $wallet->save();

    return redirect()->back()->with('success', 'Transaction added successfully!');

    }
}
