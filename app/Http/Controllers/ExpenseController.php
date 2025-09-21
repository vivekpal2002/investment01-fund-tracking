<?php

namespace App\Http\Controllers;

use App\Models\expense;
use App\Models\category;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function byDate(Request $request)
{
        $start = $request->query('start'); // ISO string from FullCalendar
        $end = $request->query('end');

        if (!$start || !$end) {
            return response()->json(['error' => 'Missing date range'], 400);
        }

        // Fetch transactions for the authenticated user (or guest logic)
        $transactions = transaction::whereBetween('date', [$start, $end])
            ->when(Auth::check(), function ($query) {
                $query->where('user_id', Auth::id());
            })
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
            $category->save();

            $expense = expense::where('category_id', $categoryId)->first();
            if($expense){
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
  
}


