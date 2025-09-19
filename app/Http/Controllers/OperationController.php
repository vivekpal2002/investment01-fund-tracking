<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\transaction;
use App\Models\wallet;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class OperationController extends Controller
{
    public function wallet(){
        $categories = category::where('type',1)->get();
        $Trans_categories =  category::where('type',2)->get();
       $wallets = Wallet::with('category')->where('user_id', Auth::id())->get();

        $transactions =transaction::with('category','wallet')->whereHas('wallet', function($query) {
        $query->where('user_id', Auth::id());
        })->orderBy('date', 'desc')->paginate(5);

       $total_balance = $wallets->sum('balance');
       $personal_funds = $wallets->where('type',1)->sum('balance');
       $credit_cards = $wallets->where('type',2)->sum('balance');
       $investments = $wallets->where('type',11)->sum('balance');
        return view('contents.wallet',compact('categories','wallets','Trans_categories','total_balance','personal_funds','credit_cards','investments','transactions'));
    }
    public function expenses(){
        $transactions = transaction::where('user_id', Auth::id())
        ->get();

    $grouped = $transactions->groupBy('category_id');

        $budgets = $grouped->map(function ($items, $categoryId) {
            $categoryName = $items->first()->category->name ?? 'Unknown';
            $categoryIcon = $items->first()->category->icon ?? 'fi fi-rr-folder';
           
        
            // Calculate Income & Expense
            $spent = $items->where('payment_type', 5)->sum('amount');   // Expense
            $income = $items->where('payment_type', 1)->sum('amount');  // Income
        
            // Last Month Data
            $lastMonthSpent = $items->where('payment_type', 1)
                ->whereBetween('created_at', [
                    now()->subMonth()->startOfMonth(),
                    now()->subMonth()->endOfMonth(),
                ])->sum('amount');
        
            $lastMonthIncome = $items->where('payment_type', 0)
                ->whereBetween('created_at', [
                    now()->subMonth()->startOfMonth(),
                    now()->subMonth()->endOfMonth(),
                ])->sum('amount');
        
            // Taxes Example (2% of expense, make your own logic)
            $taxes = $spent * 0.02;
        
            // Debt Example (sum of transactions marked as "debt")
            $debt = $items->where('type', 'debt')->sum('amount');  // assuming you have type column
            
            return [
                'id'          => $categoryId,
                'name'        => $categoryName,
                'icon'        => $categoryIcon,
                'amount'      => $income,
                'spent'       => $spent,
                'budget'      => $income - $spent,
                'last_month'  => [
                    'income'  => $lastMonthIncome,
                    'expense' => $lastMonthSpent,
                ],
                'expenses'    => $spent,
                'taxes'       => $taxes,
                'debt'        => $debt,
            ];
        })->values();
        
        return view('contents.expenses',compact('budgets'));
    }
     
    public function expenseCreate(Request $request){
dd($request->all());
    }



    public function mutualfunds(){
        $investments = collect([
            (object)[
                'name' => 'Tesla Inc',
                'ticker' => 'TSLA',
                'value' => 10225.40,
                'change' => 1.66,
                'icon' => 'angellist',
                'color' => 'info'
            ],
            (object)[
                'name' => 'Apple Inc',
                'ticker' => 'AAPL',
                'value' => 15215.70,
                'change' => 0.66,
                'icon' => 'apple',
                'color' => 'dark'
            ],
            (object)[
                'name' => 'Tesla Inc',
                'ticker' => 'TSLA',
                'value' => 10225.40,
                'change' => 1.66,
                'icon' => 'angellist',
                'color' => 'info'
            ],
            (object)[
                'name' => 'Amazon Inc',
                'ticker' => 'AMZN',
                'value' => 40500.20,
                'change' => 2.56,
                'icon' => 'amazon',
                'color' => 'warning'
            ]
        ]);
        // $investments=collect([]);

        return view('contents.mutualfunds', compact('investments'));

    }
    public function goal(){
        $goals = [
            [
                'id' => 'a1',
                'title' => 'Car',
                'current' => 145.30,
                'target' => 40580.85,
                'wallets' => [
                    ['name' => 'City Bank', 'amount' => 150, 'percent' => 75, 'icon' => 'fi-rr-bank', 'bg' => 'bg-yellow-500'],
                    ['name' => 'Cash Wallet', 'amount' => 150, 'percent' => 25, 'icon' => 'fi-rr-money-bills-simple', 'bg' => 'bg-indigo-500'],
                    ['name' => 'Visa Card', 'amount' => 150, 'percent' => 50, 'icon' => 'fi-rr-credit-card', 'bg' => 'bg-purple-500'],
                ],
                'history' => [
                    ['date' => '29 Jan 2024', 'wallet' => 'Master Card', 'desc' => 'Necessities', 'amount' => '+100.00$', 'balance' => '12.368$'],

                ]
            ],
            [
                'id' => 'a2',
                'title' => 'Laptop',
                'current' => 1858.30,
                'target' => 450.85,
                'wallets' => [
                    ['name' => 'City Bank', 'amount' => 150, 'percent' => 75, 'icon' => 'fi-rr-bank', 'bg' => 'bg-yellow-500'],
                    ['name' => 'Cash Wallet', 'amount' => 150, 'percent' => 25, 'icon' => 'fi-rr-money-bills-simple', 'bg' => 'bg-indigo-500'],
                    ['name' => 'Visa Card', 'amount' => 150, 'percent' => 50, 'icon' => 'fi-rr-credit-card', 'bg' => 'bg-purple-500'],
                ],
                'history' => [
                    ['date' => '29 Jan 2024', 'wallet' => 'Master Card', 'desc' => 'Necessities', 'amount' => '+100.00$', 'balance' => '12.368$'],

                ]
            ],
            [
                'id' => 'a3',
                'title' => 'Phone',
                'current' => 2458.30,
                'target' => 458000.85,
                'wallets' => [
                    ['name' => 'City Bank', 'amount' => 150, 'percent' => 75, 'icon' => 'fi-rr-bank', 'bg' => 'bg-yellow-500'],
                    ['name' => 'Cash Wallet', 'amount' => 150, 'percent' => 25, 'icon' => 'fi-rr-money-bills-simple', 'bg' => 'bg-indigo-500'],
                    ['name' => 'Visa Card', 'amount' => 150, 'percent' => 50, 'icon' => 'fi-rr-credit-card', 'bg' => 'bg-purple-500'],
                ],
                'history' => [
                    ['date' => '29 Jan 2024', 'wallet' => 'Master Card', 'desc' => 'Necessities', 'amount' => '+100.00$', 'balance' => '12.368$'],

                ]
            ],
            // ... other goals
        ];

        return view('contents.goal', compact('goals'));
    }
    public function report(){
        return view('contents.reports');
    }
    public function calender(){
        return view('contents.calender');
    }


}
