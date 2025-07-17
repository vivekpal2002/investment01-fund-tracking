<?php

namespace App\Http\Controllers;

use App\Models\expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ExpenseController extends Controller
{
    public function byDate(Request $request)
{

    // $userId = auth()->id(); // or pass ID in query param

    // $expenses = DB::table('expenses')
    //     ->selectRaw('DATE(date) as date, SUM(amount) as total')
    //     // ->where('user_id', $userId)
    //     ->groupBy(DB::raw('DATE(date)'))
    //     ->get();

    // $events = $expenses->map(function ($expense) {
    //     return [
    //         'title' => '$' . number_format($expense->total, 2) . ' spent',
    //         'start' => $expense->date,
    //     ];
    // });
    $start = $request->query('start');
    $end = $request->query('end');

    $events = [
        ['title' => '₹250 spent', 'start' => '2025-07-16'],
        ['title' => '₹100 spent', 'start' => '2025-07-15'],
        // ...
    ];

    return response()->json($events);
    // dd($request->all());
    // $start = $request->query('start'); // FullCalendar sends these as ISO strings
    // $end = $request->query('end');

    // if (!$start || !$end) {
    //     return response()->json(['error' => 'Missing date range'], 400);
    // }

    // // For guest testing, use sample data. If user logged in, use auth()->id()
    // $expenses = expense::whereBetween('date', [$start, $end])
    //     ->when(Auth::check(), function ($query) {
    //         $query->where('user_id', Auth::id());
    //     })
    //     ->get();

    // $events = $expenses->map(function ($expense) {
    //     return [
    //         'title'=>$expense->title,
    //         'Amount' => '₹' . $expense->amount,
    //         'start' => $expense->date,
    //         'color' => '#f44336'
    //     ];
    // });

    // return response()->json($events);
}

}
