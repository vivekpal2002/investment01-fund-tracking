@extends('layout.contentslayout')
@section('title', 'Stocks')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Stocks</li>
@endsection

@section('maincontents')
<div class="col d-flex align-items-center justify-content-between mb-3">
    <!-- Left side: Heading -->
    <h1 class="mb-0 fw-bold">Stocks</h1>

    <!-- Center: Search box -->
    <div class="mx-auto position-relative" style="width: 500px;">
        <input type="text" class="form-control ps-5 py-2" id="text-srh" placeholder="Search Stock">
        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-secondary ms-3 cls_search_stock"></i>

        <!-- Dropdown results -->
        <ul class="list-group position-absolute w-100 mt-1" id="stock-results" style="z-index: 1000; display: none;"></ul>
    </div>
</div>



<div class="row">

    {{-- Stock Cards --}}
    @foreach ($stocks as $stock)
        <div class="col-xl-3 col-lg-6 col-sm-6 col-12 pb-3">
            <div class="card shadow-sm border-0 h-100 stock-card" 
                 data-id="{{ $stock->id }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button type="button" 
                                class="btn btn-sm btn-{{ $stock->color ?? 'dark' }} rounded-pill">
                            <i class="fa fa-{{ $stock->icon ?? 'briefcase' }} me-1"></i>
                            {{ $stock->name }}
                        </button>
                        <div class="text-end">
                            <a href="#" class="text-dark fw-semibold d-block">{{ $stock->ticker }}</a>
                            <span class="{{ $stock->change_percent >= 0 ? 'text-success' : 'text-danger' }} small">
                                {{ $stock->change_percent >= 0 ? '+' : '' }}{{ $stock->change_percent }}%
                            </span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Portfolio Value</p>
                            <h4 class="fw-bold mb-0">₹{{ number_format($stock->quantity * $stock->current_price, 2) }}</h4>
                        </div>
                        <div class="sparkline-chart" style="width: 100px; height: 40px;"></div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Add Stock Card --}}

        <div class="col-xl-3 col-lg-6 col-sm-6 col-12 pb-3">
            <div class="card shadow-sm border-dashed border-1 border-secondary h-100 text-center d-flex align-items-center justify-content-center"
                style="min-height: 150px;" data-bs-toggle="modal" data-bs-target="#addStockModal">
                <i class="fa fa-plus-circle fa-2x mb-2"></i>
                <p class="mb-0">Add Stock</p>
            </div>
        </div>
</div>

{{-- Chart + Details Section --}}
<div class="row">
    <div class="col-xl-8 col-lg-12 pt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">📈 Stock Performance</h3>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-3" id="stock-title">{{ $defaultStock->name ?? 'Select a Stock' }}</h5>

                <!-- Chart Container -->
                <div id="main-performance-graph" style="height: 350px;"></div>
            </div>
        </div>
    </div>

    {{-- Right Panel - Stock Info --}}
    <div class="col-xl-4 col-lg-6 col-md-12 mb-4 pt-4">
        <h4 class="mb-3 d-flex justify-content-between align-items-center">
            <span>Details</span>
        </h4>

        <div class="card mb-3 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-success mb-0" id="detail-ticker">---</h5>
            </div>
            <ul class="list-group list-group-flush" id="stock-details">
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Previous Close</span>
                    <span id="detail-close">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Day Range</span>
                    <span id="detail-dayrange">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Year Range</span>
                    <span id="detail-yearrange">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Market Cap</span>
                    <span id="detail-marketcap">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Volume</span>
                    <span id="detail-volume">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">P/E Ratio</span>
                    <span id="detail-pe">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Exchange</span>
                    <span id="detail-exchange">---</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1">
    <div class="modal-dialog">
      <form method="POST" action="{{ route('stocks.create') }}">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add New Stock</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Stock Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Ticker</label>
                <input type="text" name="ticker" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Average Price</label>
                <input type="number" step="0.01" name="avg_price" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Exchange</label>
                <input type="text" name="exchange" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Sector</label>
                <input type="text" name="sector" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Icon</label>
                <input type="text" name="icon" class="form-control" placeholder="fa-briefcase">
              </div>
              <div class="mb-3">
                <label class="form-label">Color</label>
                <input type="text" name="color" class="form-control" placeholder="primary">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save Stock</button>
            </div>
          </div>
      </form>
    </div>
  </div>
  
  

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize chart
        let chartOptions = {
            chart: {
                type: 'line',
                height: 335,
                toolbar: { show: false }
            },
            series: [{ name: 'Price', data: [] }],
            xaxis: { categories: [] },
            stroke: { curve: 'smooth', width: 3 },
            colors: ['#007bff'],
            markers: { size: 4 }
        };
    
        let chart = new ApexCharts(document.querySelector("#main-performance-graph"), chartOptions);
        chart.render().then(() => {
            // Optionally load first stock on page load
            let firstCard = document.querySelector('.stock-card');
            if(firstCard) firstCard.click();
        });
    
        // Function to update chart and details
        function updateStockData(data) {
            // Ensure numeric prices
            data.prices = data.prices.map(p => parseFloat(p));
    
            // Update chart
            chart.updateOptions({ xaxis: { categories: data.dates } });
            chart.updateSeries([{ name: "Price", data: data.prices }]);
    console.log( data)
            // Update stock info panel
            document.querySelector("#stock-title").innerText = data.stockname;
            document.querySelector("#detail-ticker").innerText = data.ticker;
            document.querySelector("#detail-close").innerText = data.previous_close ?? "---";
            document.querySelector("#detail-dayrange").innerText = data.day_range ?? "---";
            document.querySelector("#detail-yearrange").innerText = data.year_range ?? "---";
            document.querySelector("#detail-marketcap").innerText = data.market_cap ?? "---";
            document.querySelector("#detail-volume").innerText = data.volume ?? "---";
            document.querySelector("#detail-pe").innerText = data.pe_ratio ?? "---";
            document.querySelector("#detail-exchange").innerText = data.exchange ?? "---";
        }
    
        // Card click handler
        document.querySelectorAll('.stock-card').forEach(card => {
            card.addEventListener('click', function () {
                let stockId = this.dataset.id;
                fetch(`/stock-data/${stockId}`)
                    .then(res => res.json())
                    .then(data => updateStockData(data))
                    .catch(err => console.error("Error fetching stock data:", err));
            });
        });

        document.querySelector(".cls_search_stock").addEventListener("click", function () {
    let query = document.getElementById("text-srh").value.trim();
    let resultsEl = document.getElementById("stock-results");

    if (query.length > 2) {
        fetch(`https://finnhub.io/api/v1/search?q=${query}&token=d38fmjhr01qlbdj59iagd38fmjhr01qlbdj59ib0`)
            .then(res => res.json())
            .then(data => {
                let results = data.result || [];
                let output = "";

                results.forEach(stock => {
                    output += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${stock.description} (${stock.displaySymbol})</span>
                            <small class="text-muted">${stock.type}</small>
                        </li>
                    `;
                });

                resultsEl.innerHTML = output;
                resultsEl.style.display = results.length ? "block" : "none";
            })
            .catch(err => console.error("Error:", err));
    } else {
        resultsEl.style.display = "none"; // hide if query too short
    }
});

// Optional: hide dropdown when clicking outside
document.addEventListener("click", function(e){
    if (!document.getElementById("text-srh").contains(e.target) &&
        !document.querySelector(".cls_search_stock").contains(e.target)) {
        document.getElementById("stock-results").style.display = "none";
    }
});

    });
    </script>
    
@endsection
