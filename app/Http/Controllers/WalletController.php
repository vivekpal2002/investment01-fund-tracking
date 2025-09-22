<?php

namespace App\Http\Controllers;

use App\Models\wallet;
use App\Models\category;

use App\Models\transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class WalletController extends Controller
{
    public function wallet(){
        $categories = category::whereNull('user_id')->orWhere('user_id', Auth::id())->get();

        // $Trans_categories =  category::where('type',2)->get();
       $wallets = Wallet::with('category')->where('user_id', Auth::id())->get();

        $transactions =transaction::with('category','wallet')->whereHas('wallet', function($query) {
        $query->where('user_id', Auth::id());
        })->orderBy('date', 'desc')->paginate(5);

       $total_balance = $wallets->sum('balance');
       $personal_funds = $wallets->where('type',1)->sum('balance');
       $credit_cards = $wallets->where('type',2)->sum('balance');
       $investments = $wallets->where('type',11)->sum('balance');
        return view('contents.wallet',compact('categories','wallets','total_balance','personal_funds','credit_cards','investments','transactions'));
    }
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
    $transaction->trxn_type = $validatedData['type'];
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
    public function exportTransactions()
{
    $userId = Auth::id();

    // Fetch only current user's transactions
    $transactions = transaction::where('user_id', $userId)
        ->orderBy('date', 'desc')
        ->get([
            'id', 'title', 'user_id', 'trxn_type', 'amount', 'wallet_id', 
            'category_id', 'payment_type', 'date', 'status', 'notes', 
            'created_at', 'updated_at'
        ]);

    // Define CSV headers
    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=transactions.csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $columns = [
        'ID', 'Title', 'User ID', 'Transaction Type', 'Amount', 'Wallet ID', 
        'Category ID', 'Payment Type', 'Date', 'Status', 'Notes', 
        'Created At', 'Updated At'
    ];

    // Callback to generate CSV content
    $callback = function() use ($transactions, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($transactions as $txn) {
            fputcsv($file, [
                $txn->id,
                $txn->title,
                $txn->user_id,
                $txn->trxn_type,
                $txn->amount,
                $txn->wallet_id,
                $txn->category_id,
                $txn->payment_type,
                $txn->date,
                $txn->status,
                $txn->notes,
                $txn->created_at,
                $txn->updated_at
            ]);
        }

        fclose($file);
    };

    return Response::stream($callback, 200, $headers);
}
}
