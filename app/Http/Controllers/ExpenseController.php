<?php

namespace App\Http\Controllers;

use App\Models\expense;
use App\Models\category;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
public function expenses()
{
    $userId = Auth::id();

    // Fetch all transactions of the user
    $transactions = transaction::where('user_id', $userId)->get();

    // Group transactions by category
    $grouped = $transactions->groupBy('category_id');
   

    // Only categories where user has transactions
    $budgets = $grouped->map(function ($items, $categoryId) use ($userId) {
        $category = $items->first()->category; // get the category model

        // Current month date range
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Current month expenses & income
        $spent = $items->where('payment_type', 0)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        $income = $items->where('payment_type', 1)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Last month expenses & income
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd   = now()->subMonth()->endOfMonth();

        $lastMonthSpent = $items->where('payment_type', 0)
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');

        $lastMonthIncome = $items->where('payment_type', 1)
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');

        // Get monthly target from Expense table (linked to category)
        $expenseTarget = Expense::where('category_id', $categoryId)->where('user_id',$userId)
            ->first();

        $targetAmount = $expenseTarget->target ?? 0;

        // Taxes example
        $taxes = $spent * 0.02;

        // Debt example (type=3)
        $debt = $items->where('trxn_type', 3)->sum('amount');

        // Utilization percentage
        $utilization = $targetAmount > 0 ? round(($spent / $targetAmount) * 100, 2) : 0;

        return [
            'id'          => $categoryId,
            'name'        => $category->name ?? 'Unknown',
            'icon'        => $category->icon ?? 'fi fi-rr-folder',
            'budget'      => $targetAmount,
            'spent'       => $spent,
            'income'      => $income,
            'amount'      => $spent, // spent amount for frontend
            'last_month'  => [
                'expense' => $lastMonthSpent,
                'income'  => $lastMonthIncome
            ],
            'taxes'       => $taxes,
            'debt'        => $debt,
            'utilization' => $utilization
        ];
    })->values();
    // dd($budgets);
    $summaryCards = [
        [
            'title' => 'Total Budget',
            'value' => '₹' . ($budget['budget'] ?? 0),
            'icon'  => 'fi fi-rr-dollar',
            'color' => 'primary'
        ],
        [
            'title' => 'Spent',
            'value' => '₹' . ($budget['spent'] ?? 0),
            'icon'  => 'fi fi-rr-dollar',
            'color' => 'secondary'
        ],
        [
            'title' => 'Remaining',
            'value' => '₹' . (($budget['budget'] ?? 0) - ($budget['spent'] ?? 0)),
            'icon'  => 'fi fi-rr-dollar',
            'color' => 'info'
        ]
    ];
    

    return view('contents.expenses', compact('budgets','summaryCards'));
}

    public function expenseCreate(Request $request)
    {
        
        $validate = $request->validate([
            'ename'        => 'required|string|max:255',
            'type_of_fund' => 'required|numeric',
            'target'       => 'required|numeric|min:0',
        ]);
        $categoryId = $request->category_id;

        if($categoryId){
            // Update existing category / expense
            $category = category::find($categoryId);
            $category->name = $request->ename;
            $category->type = $request->type_of_fund;
            $category->update();

            $expense = expense::where('category_id', $categoryId)->first();

            if($expense){
                $expense->target = $request->target;
                $expense->save();
            }else{
                $expense = new Expense();
                $expense->category_id = $category->id;
                $expense->target = $request->target;
                $expense->save();
            }
        } else {
            // Create new category and expense
            $category = new Category();
            $category->name = $request->ename;
            $category->type = $request->type_of_fund;
            $category->user_id = Auth::id();
            $category->save();

            $expense = new Expense();
            $expense->category_id = $category->id;
            $expense->target = $request->target;
            $expense->save();
        }

    
        return redirect()->back()->with('message', 'Expense Category & Budget Created');
    }

    public function byDate(Request $request)
    {
        $start = $request->query('start'); // ISO string from FullCalendar
        $end   = $request->query('end');
    
        if (!$start || !$end) {
            return response()->json(['error' => 'Missing date range'], 400);
        }
    
        // Get current user ID
        $userId = Auth::id();
    
        // Fetch only the authenticated user's transactions
        $transactions = transaction::where('user_id', $userId)
            ->whereBetween('date', [$start, $end])
            ->get();
    
        // Map to FullCalendar format
        $events = $transactions->map(function ($txn) {
            return [
                'title' => $txn->title . ' (₹' . $txn->amount . ')',
                'start' => $txn->date,
                'color' => '#f44336', // Optional
            ];
        });
    
        return response()->json($events);
    }
    
  
}


