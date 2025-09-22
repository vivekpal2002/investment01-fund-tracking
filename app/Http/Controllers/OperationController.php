<?php

namespace App\Http\Controllers;

use App\Models\goal;
use App\Models\Stock;
use App\Models\wallet;
use App\Models\expense;
use App\Models\category;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Providers\FoundationServiceProvider;

class OperationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
    
        // ==========================
        // 1. BALANCE
        // ==========================
        $balance = wallet::where('user_id', $userId)->sum('balance');
    
        $lastMonthBalance = wallet::where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('balance');
        $balancePercent = $lastMonthBalance > 0 
            ? round((($balance - $lastMonthBalance) / $lastMonthBalance) * 100, 2) 
            : 0;
    
        // 📊 Balance Chart (last 6 months wallet sum)
        $balanceChart = wallet::where('user_id', $userId)
            ->selectRaw('MONTH(created_at) as month, SUM(balance) as total')
            ->where('created_at', '>=', now()->subMonths(5))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
    
        // ==========================
        // 2. MONTHLY EXPENSE
        // ==========================
        $monthlyExpense = transaction::where('user_id', $userId)
            ->where('payment_type', '0') // expense
            ->whereMonth('date', now()->month)
            ->sum('amount');
    
        $lastMonthExpense = transaction::where('user_id', $userId)
            ->where('payment_type', '0')
            ->whereMonth('date', now()->subMonth()->month)
            ->sum('amount');
        $monthlyPercent = $lastMonthExpense > 0
            ? round((($monthlyExpense - $lastMonthExpense) / $lastMonthExpense) * 100, 2)
            : 0;
    
        // 📊 Monthly Expense Chart (last 6 months)
        $monthlyChart = transaction::where('user_id', $userId)
            ->where('payment_type', '0')
            ->where('date', '>=', now()->subMonths(5))
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
    
        // ==========================
        // 3. SAVINGS
        // ==========================
        $saving = goal::where('user_id', $userId)->sum('current_amount');
        $lastMonthSaving = goal::where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('current_amount');
        $savingPercent = $lastMonthSaving > 0
            ? round((($saving - $lastMonthSaving) / $lastMonthSaving) * 100, 2)
            : 0;
    
        // 📊 Saving Chart (last 6 months)
        $savingChart = goal::where('user_id', $userId)
            ->where('created_at', '>=', now()->subMonths(5))
            ->selectRaw('MONTH(created_at) as month, SUM(current_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
    
        // ==========================
        // 4. INCOME
        // ==========================
        $periodIncome = transaction::where('user_id', $userId)
            ->where('payment_type', '1') // income
            ->sum('amount');
    
        $lastMonthIncome = transaction::where('user_id', $userId)
            ->where('payment_type', '1')
            ->whereMonth('date', now()->subMonth()->month)
            ->sum('amount');
        $periodIncomePercent = $lastMonthIncome > 0
            ? round((($periodIncome - $lastMonthIncome) / $lastMonthIncome) * 100, 2)
            : 0;
    
        // 📊 Income Chart (last 6 months)
        $incomeChart = transaction::where('user_id', $userId)
            ->where('payment_type', '1')
            ->where('date', '>=', now()->subMonths(5))
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
    
        // ==========================
        // 5. RECENT TRANSACTIONS
        // ==========================
        $recenttransactions = transaction::with('category')
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();
    
        // ==========================
        // 6. SPEND CHART GROWTH
        // ==========================
        $thisMonthSpend = transaction::where('user_id', $userId)
            ->where('payment_type', '0')
            ->whereMonth('date', now()->month)
            ->sum('amount');
        $chartGrowth = $lastMonthExpense > 0
            ? round((($thisMonthSpend - $lastMonthExpense) / $lastMonthExpense) * 100, 2)
            : 0;

        // 📊 Spend Chart Data (last 6 months expenses)
        $spendChart = transaction::where('user_id', $userId)
        ->where('payment_type', '0')
        ->where('date', '>=', now()->subMonths(5))
        ->selectRaw('MONTH(date) as month, SUM(amount) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

        $profit  = transaction::where('user_id', $userId)
            ->where('payment_type', '1')
            ->whereMonth('date', now()->month)
            ->sum('amount');

        $expense = transaction::where('user_id', $userId)
            ->where('payment_type', '0')
            ->whereMonth('date', now()->month)
            ->sum('amount');

        // Chart data
        $breakupChart = [
            'series' => [$profit, $expense], 
            'labels' => ['Profit', 'Expense'],
            'colors' => ["#5D87FF", "#ecf2ff", "#F9F9FD"]
        ];

        return view('contents.index', [
            'balanace'          => $balance,
            'balanace_perecent' => $balancePercent,
            'Monthly'           => $monthlyExpense,
            'Monthly_percent'   => $monthlyPercent,
            'Saving'            => $saving,
            'Saving_perecent'   => $savingPercent,
            'Period_Income'     => $periodIncome,
            'Period_Income_percent' => $periodIncomePercent,
            'Chart_growth'      => $chartGrowth,
            'recenttransactions'=> $recenttransactions,
    
            // charts
            'balanceChart'      => array_values($balanceChart->toArray()),
            'monthlyChart'      => array_values($monthlyChart->toArray()),
            'savingChart'       => array_values($savingChart->toArray()),
            'incomeChart'       => array_values($incomeChart->toArray()),
            'spendChart'       => array_values($spendChart->toArray()),
            'breakupChart' => $breakupChart,
        ]);
    }
    


    public function goal(){
        $goals= goal::with('goal_category')->where('user_id',Auth::id())->get();

        return view('contents.goal', compact('goals'));
    }
    public function report(){
        return view('contents.reports');
    }
    public function calender(){
        return view('contents.calender');
    }
   

}
