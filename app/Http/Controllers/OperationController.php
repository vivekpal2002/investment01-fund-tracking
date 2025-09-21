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
    public function wallet(){
        $categories = Category::whereNull('user_id')->orWhere('user_id', Auth::id())->get();

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
    public function expenses()
{
    $userId = Auth::id();

    // Fetch all transactions of the user
    $transactions = Transaction::where('user_id', $userId)->get();

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
        $expenseTarget = Expense::where('category_id', $categoryId)
            ->first();

        $targetAmount = $expenseTarget->target ?? 0;

        // Taxes example
        $taxes = $spent * 0.02;

        // Debt example (type=3)
        $debt = $items->where('type', 3)->sum('amount');

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

    
    // public function mutualfunds(){

    //     $stocks = Stock::where('user_id', Auth::id())->get();

    

    //     $investments = collect([
    //         (object)[
    //             'name' => 'Tesla Inc',
    //             'ticker' => 'TSLA',
    //             'value' => 10225.40,
    //             'change' => 1.66,
    //             'icon' => 'angellist',
    //             'color' => 'info'
    //         ],
    //         (object)[
    //             'name' => 'Apple Inc',
    //             'ticker' => 'AAPL',
    //             'value' => 15215.70,
    //             'change' => 0.66,
    //             'icon' => 'apple',
    //             'color' => 'dark'
    //         ],
    //         (object)[
    //             'name' => 'Tesla Inc',
    //             'ticker' => 'TSLA',
    //             'value' => 10225.40,
    //             'change' => 1.66,
    //             'icon' => 'angellist',
    //             'color' => 'info'
    //         ],
    //         (object)[
    //             'name' => 'Amazon Inc',
    //             'ticker' => 'AMZN',
    //             'value' => 40500.20,
    //             'change' => 2.56,
    //             'icon' => 'amazon',
    //             'color' => 'warning'
    //         ]
    //     ]);
    //     // $investments=collect([]);

    //     return view('contents.mutualfunds', compact('investments', 'dates', 'navs', 'symbol','stockname'));

    // }

    public function mutualfunds()
{
    $stocks = Stock::where('user_id', Auth::id())->get();

    // If user has at least one stock, show its chart initially
    $firstStock = $stocks->first();

    $chartData = $firstStock 
        ? $this->api_stock($firstStock->ticker)
        : ['dates' => [], 'prices' => [], 'symbol' => null, 'stockname' => null];

    return view('contents.mutualfunds', [
        'stocks' => $stocks,
        'dates' => $chartData['dates'],
        'navs' => $chartData['prices'],
        'symbol' => $chartData['symbol'],
        'stockname' => $chartData['stockname']
    ]);
}
public function stockData($id)
{
    $stock = Stock::where('user_id', Auth::id())->findOrFail($id);
    $chartData = $this->api_stock($stock->ticker);

    return response()->json($chartData);
}

public function create_stock(Request $request){
    
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'ticker'        => 'required|string|max:20',
            'quantity'      => 'required|integer|min:0',
            'avg_price'     => 'required|numeric|min:0',
            'exchange'      => 'nullable|string|max:50',
            'sector'        => 'nullable|string|max:100',
            'icon'          => 'nullable|string|max:50',
            'color'         => 'nullable|string|max:20',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['invested_amount'] = $validated['quantity'] * $validated['avg_price'];

        Stock::create($validated);

        return redirect()->route('stocks.index')->with('success', 'Stock added successfully!');
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
    protected function api_stock($ticker)
    {
        $apiKey = env('ALPHA_VANTAGE_KEY');
        // $apiKey='demo';
        $url = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol={$ticker}&apikey={$apiKey}";
        $data = json_decode(file_get_contents($url), true);
    
        $timeSeries = $data['Time Series (Daily)'] ?? [];
        $dates = [];
        $prices = [];
        foreach (array_slice($timeSeries, 0, 20) as $date => $info) {
            $dates[] = date('M d', strtotime($date));
            $prices[] = (float) $info['4. close'];
        }
        return [
            'dates' => array_reverse($dates),
            'prices' => array_reverse($prices),
            'symbol' => $ticker,
            'stockname' => $data['Meta Data']['2. Symbol'] ?? $ticker
        ];
    }
    

}
