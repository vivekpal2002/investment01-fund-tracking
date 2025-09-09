<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\transaction;
use App\Models\wallet;
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
         })->orderBy('date', 'desc')->get();

       $total_balance = $wallets->sum('balance');
       $personal_funds = $wallets->where('type',1)->sum('balance');
       $credit_cards = $wallets->where('type',2)->sum('balance');
       $investments = $wallets->where('type',11)->sum('balance');
        return view('contents.wallet',compact('categories','wallets','Trans_categories','total_balance','personal_funds','credit_cards','investments','transactions'));
    }
    public function expenses(){
        $budgets = [
            [
                'id' => 'a1',
                'name' => 'Grocery',
                'icon' => 'fi fi-rr-carrot',
                'amount' => 1458.30,
                'spent' => 650.75,
                'budget' => 850,
                'period' => 'Overtime',
                'chartId' => 'chartjsBudgetPeriod1',
                'last_month' => 42678,
                'expenses' => 1798,
                'taxes' => 255.25,
                'debt' => 365478,
            ],
            [
                'id' => 'a2',
                'name' => 'Clothes',
                'icon' => 'fi fi-rr-shirt-long-sleeve',
                'amount' => 158.30,
                'spent' => 50.75,
                'budget' => 850,
                'period' => 'Week',
                'chartId' => 'chartjsBudgetPeriod2',
                'last_month' => 678,
                'expenses' => 198,
                'taxes' => 25.25,
                'debt' => 3478,
            ],
            // Add more as needed
        ];

        return view('contents.expenses',compact('budgets'));
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
