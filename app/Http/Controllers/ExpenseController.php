<?php

namespace App\Http\Controllers;

use App\Models\expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ExpenseController extends Controller
{
    public function byDate(Request $request)
{
    dd($request->all());
    $start = $request->query('start'); // FullCalendar sends these as ISO strings
    $end = $request->query('end');

    if (!$start || !$end) {
        return response()->json(['error' => 'Missing date range'], 400);
    }

    // For guest testing, use sample data. If user logged in, use auth()->id()
    $expenses = expense::whereBetween('date', [$start, $end])
        ->when(Auth::check(), function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->get();

    $events = $expenses->map(function ($expense) {
        return [
            'title'=>$expense->title,
            'Amount' => '₹' . $expense->amount,
            'start' => $expense->date,
            'color' => '#f44336'
        ];
    });

    return response()->json($events);
}

}
