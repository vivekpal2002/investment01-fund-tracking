<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StockController extends Controller
{
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
                'goal_id'       => [
                    'nullable',
                    Rule::exists('goals', 'id')->where('user_id', Auth::id()),
                ],
            ]);
    
            $validated['user_id'] = Auth::id();
            $validated['invested_amount'] = $validated['quantity'] * $validated['avg_price'];
    
            Stock::create($validated);
    
            return redirect()->route('mutualfunds')->with('success', 'Stock added successfully!');
    }
    protected function api_stock($ticker)
    {
        $apiKey = env('ALPHA_VANTAGE_KEY');
        if (!$apiKey) {
            return $this->emptyStockData($ticker);
        }

        $data = Cache::remember("stock_daily_{$ticker}", now()->addMinutes(30), function () use ($ticker, $apiKey) {
            try {
                $response = Http::timeout(8)
                    ->retry(2, 250)
                    ->get('https://www.alphavantage.co/query', [
                        'function' => 'TIME_SERIES_DAILY',
                        'symbol' => $ticker,
                        'apikey' => $apiKey,
                    ]);

                if (!$response->successful()) {
                    Log::warning('Stock API request failed', [
                        'ticker' => $ticker,
                        'status' => $response->status(),
                    ]);

                    return [];
                }

                return $response->json() ?? [];
            } catch (\Throwable $exception) {
                Log::warning('Stock API request exception', [
                    'ticker' => $ticker,
                    'message' => $exception->getMessage(),
                ]);

                return [];
            }
        });

        $timeSeries = $data['Time Series (Daily)'] ?? [];
        $dates = [];
        $prices = [];
        foreach (array_slice($timeSeries, 0, 20) as $date => $info) {
            $dates[] = date('M d', strtotime($date));
            $prices[] = (float) $info['4. close'];
        }
        // dd($dates ,$prices);
        return [
            'dates' => array_reverse($dates),
            'prices' => array_reverse($prices),
            'symbol' => $ticker,
            'ticker' => $ticker,
            'stockname' => $data['Meta Data']['2. Symbol'] ?? $ticker
        ];
    }

    protected function emptyStockData($ticker)
    {
        return [
            'dates' => [],
            'prices' => [],
            'symbol' => $ticker,
            'ticker' => $ticker,
            'stockname' => $ticker,
        ];
    }
}
