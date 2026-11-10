@extends('layout.contentslayout')

@section('title', 'Market Portfolio')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Market Portfolio</li>
@endsection

@section('maincontents')
@php
    $totalInvested = (float) $stocks->sum('invested_amount');
    $currentValue = (float) $stocks->sum(fn ($stock) => $stock->quantity * ($stock->current_price ?? $stock->avg_price ?? 0));
    $totalGainLoss = $currentValue - $totalInvested;
    $roi = $totalInvested > 0 ? ($totalGainLoss / $totalInvested) * 100 : 0;
    $topHolding = $stocks->sortByDesc(fn ($stock) => $stock->quantity * ($stock->current_price ?? $stock->avg_price ?? 0))->first();
    $defaultStock = $stocks->first();
@endphp

<style>
    .portfolio-hero {
        background: linear-gradient(135deg, #f8fbff 0%, #eef6f2 100%);
        border: 1px solid rgba(93, 135, 255, 0.14);
        border-radius: 8px;
        padding: 22px;
    }

    .portfolio-search {
        max-width: 520px;
    }

    .portfolio-kpi {
        border: 1px solid rgba(93, 135, 255, 0.14);
        border-radius: 8px;
        box-shadow: 0 12px 24px rgba(145, 158, 171, 0.12);
        min-height: 124px;
    }

    .portfolio-kpi-icon {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: #fff;
        font-size: 22px;
        flex: 0 0 42px;
    }

    .portfolio-stock-card {
        border: 1px solid rgba(93, 135, 255, 0.14);
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .portfolio-stock-card:hover,
    .portfolio-stock-card.is-active {
        transform: translateY(-2px);
        border-color: rgba(93, 135, 255, 0.45);
        box-shadow: 0 14px 28px rgba(93, 135, 255, 0.14);
    }

    .portfolio-symbol {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: rgba(93, 135, 255, 0.1);
        color: #5d87ff;
        font-weight: 700;
    }

    .portfolio-add-card {
        min-height: 174px;
        border: 1px dashed rgba(93, 135, 255, 0.55);
        border-radius: 8px;
        cursor: pointer;
        transition: border-color 0.18s ease, background-color 0.18s ease;
    }

    .portfolio-add-card:hover {
        background-color: rgba(93, 135, 255, 0.06);
        border-color: #5d87ff;
    }

    .portfolio-chart {
        position: relative;
        min-height: 360px;
    }

    .search-results-panel {
        z-index: 1020;
        max-height: 320px;
        overflow-y: auto;
        box-shadow: 0 16px 32px rgba(33, 37, 41, 0.14);
    }

    .detail-row span:last-child {
        text-align: right;
        font-weight: 600;
    }

    [data-bs-theme="dark"] .portfolio-hero {
        background: #2d2d2d;
        border-color: rgba(255, 255, 255, 0.12);
    }

    [data-bs-theme="dark"] .portfolio-kpi,
    [data-bs-theme="dark"] .portfolio-stock-card,
    [data-bs-theme="dark"] .portfolio-add-card {
        border-color: rgba(255, 255, 255, 0.12);
    }

    [data-bs-theme="dark"] .portfolio-symbol {
        background: rgba(93, 135, 255, 0.22);
    }

    @media (max-width: 767.98px) {
        .portfolio-hero {
            padding: 16px;
        }

        .portfolio-search {
            max-width: 100%;
        }

        .portfolio-chart {
            min-height: 300px;
        }
    }
</style>

<div class="portfolio-hero mb-4">
    <div class="d-flex flex-column flex-xl-row justify-content-between gap-3">
        <div>
            <p class="text-muted fw-semibold mb-1">Investments</p>
            <h1 class="fw-bold mb-1">Market Portfolio</h1>
            <p class="text-muted mb-0">Track holdings, performance, allocation, and linked goals in one place.</p>
        </div>
        <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-2 portfolio-search w-100">
            <div class="position-relative flex-grow-1">
                <input type="text" class="form-control ps-5 py-2" id="text-srh" placeholder="Search stock or fund">
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-secondary ms-3 cls_search_stock"></i>
                <ul class="list-group position-absolute w-100 mt-1 search-results-panel" id="stock-results" style="display: none;"></ul>
            </div>
            <button type="button" class="btn btn-primary d-inline-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addStockModal">
                <i class="ti ti-plus"></i>
                Add Holding
            </button>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card portfolio-kpi h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="portfolio-kpi-icon bg-primary"><i class="ti ti-wallet"></i></div>
                <div>
                    <p class="text-muted mb-1">Total Invested</p>
                    <h4 class="fw-bold mb-0">₹{{ number_format($totalInvested, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card portfolio-kpi h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="portfolio-kpi-icon bg-success"><i class="ti ti-chart-line"></i></div>
                <div>
                    <p class="text-muted mb-1">Current Value</p>
                    <h4 class="fw-bold mb-0">₹{{ number_format($currentValue, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card portfolio-kpi h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="portfolio-kpi-icon {{ $totalGainLoss >= 0 ? 'bg-info' : 'bg-danger' }}">
                    <i class="ti {{ $totalGainLoss >= 0 ? 'ti-trending-up' : 'ti-trending-down' }}"></i>
                </div>
                <div>
                    <p class="text-muted mb-1">Gain / Loss</p>
                    <h4 class="fw-bold mb-0 {{ $totalGainLoss >= 0 ? 'text-success' : 'text-danger' }}">₹{{ number_format($totalGainLoss, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card portfolio-kpi h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="portfolio-kpi-icon bg-warning"><i class="ti ti-percentage"></i></div>
                <div>
                    <p class="text-muted mb-1">Portfolio ROI</p>
                    <h4 class="fw-bold mb-0 {{ $roi >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($roi, 2) }}%</h4>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="ti ti-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="row g-3 mb-4">
    @forelse ($stocks as $stock)
        @php
            $price = (float) ($stock->current_price ?? $stock->avg_price ?? 0);
            $holdingValue = (float) ($stock->quantity * $price);
            $holdingGain = $holdingValue - (float) $stock->invested_amount;
        @endphp
        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card portfolio-stock-card h-100 stock-card" data-id="{{ $stock->id }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <div class="d-flex align-items-center gap-2 min-w-0">
                            <span class="portfolio-symbol">{{ strtoupper(substr($stock->ticker ?: $stock->name, 0, 2)) }}</span>
                            <div class="min-w-0">
                                <h5 class="fw-bold text-truncate mb-1">{{ $stock->name }}</h5>
                                <span class="badge bg-light text-dark">{{ $stock->ticker }}</span>
                            </div>
                        </div>
                        <span class="badge {{ ($stock->change_percent ?? 0) >= 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ ($stock->change_percent ?? 0) >= 0 ? '+' : '' }}{{ number_format((float) ($stock->change_percent ?? 0), 2) }}%
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-end gap-3">
                        <div>
                            <p class="text-muted small mb-1">Holding Value</p>
                            <h4 class="fw-bold mb-1">₹{{ number_format($holdingValue, 2) }}</h4>
                            <span class="small {{ $holdingGain >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $holdingGain >= 0 ? '+' : '' }}₹{{ number_format($holdingGain, 2) }}
                            </span>
                        </div>
                        <div class="text-end">
                            <p class="text-muted small mb-1">Qty</p>
                            <strong>{{ number_format($stock->quantity) }}</strong>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <span class="small text-muted">{{ $stock->sector ?: 'Uncategorized' }}</span>
                        <span class="small text-muted">{{ $stock->exchange ?: 'Exchange N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-xl-9">
            <div class="card h-100">
                <div class="card-body text-center py-5">
                    <i class="ti ti-chart-candle fs-10 text-primary"></i>
                    <h4 class="fw-bold mt-3">No holdings yet</h4>
                    <p class="text-muted mb-3">Add your first stock or fund to start tracking portfolio performance.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStockModal">
                        <i class="ti ti-plus me-1"></i>Add Holding
                    </button>
                </div>
            </div>
        </div>
    @endforelse

    <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
        <div class="card portfolio-add-card h-100 text-center d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addStockModal">
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <span class="portfolio-kpi-icon bg-primary mb-3"><i class="ti ti-plus"></i></span>
                <h5 class="fw-bold mb-1">Add Holding</h5>
                <p class="text-muted mb-0">Track a stock, fund, sector, or goal allocation.</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8 col-lg-12">
        <div class="card h-100">
            <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                <div>
                    <h4 class="card-title mb-1">Performance</h4>
                    <p class="text-muted mb-0" id="stock-title">{{ $defaultStock->name ?? 'Select a holding' }}</p>
                </div>
                @if ($topHolding)
                    <span class="badge bg-light text-dark">Top holding: {{ $topHolding->ticker }}</span>
                @endif
            </div>
            <div class="card-body">
                <div id="main-performance-graph" class="portfolio-chart"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-12">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Holding Details</h4>
                <span class="badge bg-success" id="detail-ticker">---</span>
            </div>
            <ul class="list-group list-group-flush" id="stock-details">
                <li class="list-group-item d-flex justify-content-between detail-row">
                    <span class="text-muted">Previous Close</span>
                    <span id="detail-close">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between detail-row">
                    <span class="text-muted">Day Range</span>
                    <span id="detail-dayrange">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between detail-row">
                    <span class="text-muted">Year Range</span>
                    <span id="detail-yearrange">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between detail-row">
                    <span class="text-muted">Market Cap</span>
                    <span id="detail-marketcap">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between detail-row">
                    <span class="text-muted">Volume</span>
                    <span id="detail-volume">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between detail-row">
                    <span class="text-muted">P/E Ratio</span>
                    <span id="detail-pe">---</span>
                </li>
                <li class="list-group-item d-flex justify-content-between detail-row">
                    <span class="text-muted">Exchange</span>
                    <span id="detail-exchange">---</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="modal fade" id="addStockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('stocks.create') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Add Holding</h5>
                    <p class="text-muted mb-0 small">Enter purchase details to add it to your portfolio.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Ticker</label>
                        <input type="text" name="ticker" class="form-control text-uppercase" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Average Price</label>
                        <input type="number" step="0.01" name="avg_price" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Exchange</label>
                        <input type="text" name="exchange" class="form-control" placeholder="NSE, BSE, NASDAQ">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sector</label>
                        <input type="text" name="sector" class="form-control" placeholder="Technology">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Icon</label>
                        <input type="text" name="icon" class="form-control" placeholder="briefcase">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Color</label>
                        <input type="text" name="color" class="form-control" placeholder="primary">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Link to Goal</label>
                        <select name="goal_id" class="form-control">
                            <option value="">Select Goal</option>
                            @foreach(\App\Models\goal::with('goal_category')->where('user_id', auth()->id())->get() as $goal)
                                <option value="{{ $goal->id }}">{{ $goal->goal_category->name ?? $goal->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>Save Holding
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chartTarget = document.querySelector("#main-performance-graph");
        const chart = chartTarget && typeof ApexCharts !== "undefined"
            ? new ApexCharts(chartTarget, {
                chart: {
                    type: "area",
                    height: 360,
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                series: [{ name: "Price", data: [] }],
                xaxis: {
                    categories: [],
                    labels: { style: { colors: "#7c8fac" } }
                },
                yaxis: {
                    labels: {
                        formatter: value => `₹${Number(value || 0).toLocaleString("en-IN")}`,
                        style: { colors: "#7c8fac" }
                    }
                },
                stroke: { curve: "smooth", width: 3 },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.28,
                        opacityTo: 0.02,
                        stops: [0, 90, 100]
                    }
                },
                colors: ["#5D87FF"],
                markers: { size: 0 },
                dataLabels: { enabled: false },
                grid: { borderColor: "rgba(124, 143, 172, 0.18)" },
                tooltip: {
                    y: {
                        formatter: value => `₹${Number(value || 0).toLocaleString("en-IN")}`
                    }
                },
                noData: {
                    text: "Select a holding to load performance",
                    align: "center",
                    verticalAlign: "middle",
                    style: { color: "#7c8fac", fontSize: "14px" }
                }
            })
            : null;

        if (chart) {
            chart.render().then(() => {
                const firstCard = document.querySelector(".stock-card");
                if (firstCard) firstCard.click();
            });
        }

        function updateText(selector, value) {
            const element = document.querySelector(selector);
            if (element) element.innerText = value ?? "---";
        }

        function updateStockData(data) {
            const prices = Array.isArray(data.prices) ? data.prices.map(price => Number(price || 0)) : [];

            if (chart) {
                chart.updateOptions({ xaxis: { categories: data.dates || [] } });
                chart.updateSeries([{ name: "Price", data: prices }]);
            }

            updateText("#stock-title", data.stockname || data.ticker || "Selected holding");
            updateText("#detail-ticker", data.ticker);
            updateText("#detail-close", data.previous_close);
            updateText("#detail-dayrange", data.day_range);
            updateText("#detail-yearrange", data.year_range);
            updateText("#detail-marketcap", data.market_cap);
            updateText("#detail-volume", data.volume);
            updateText("#detail-pe", data.pe_ratio);
            updateText("#detail-exchange", data.exchange);
        }

        document.querySelectorAll(".stock-card").forEach(card => {
            card.addEventListener("click", function () {
                document.querySelectorAll(".stock-card").forEach(item => item.classList.remove("is-active"));
                this.classList.add("is-active");

                fetch(`/stock-data/${this.dataset.id}`)
                    .then(response => response.json())
                    .then(data => updateStockData(data))
                    .catch(error => console.error("Error fetching stock data:", error));
            });
        });

        const searchInput = document.getElementById("text-srh");
        const searchButton = document.querySelector(".cls_search_stock");
        const resultsEl = document.getElementById("stock-results");

        function escapeHtml(value) {
            return String(value ?? "").replace(/[&<>"']/g, character => ({
                "&": "&amp;",
                "<": "&lt;",
                ">": "&gt;",
                '"': "&quot;",
                "'": "&#039;"
            }[character]));
        }

        function runStockSearch() {
            const query = searchInput.value.trim();

            if (query.length <= 2) {
                resultsEl.style.display = "none";
                return;
            }

            resultsEl.innerHTML = '<li class="list-group-item text-muted">Searching...</li>';
            resultsEl.style.display = "block";

            fetch(`https://finnhub.io/api/v1/search?q=${encodeURIComponent(query)}&token=d38fmjhr01qlbdj59iagd38fmjhr01qlbdj59ib0`)
                .then(response => response.json())
                .then(data => {
                    const results = data.result || [];

                    resultsEl.innerHTML = results.map(stock => `
                        <li class="list-group-item d-flex justify-content-between align-items-center gap-3">
                            <span class="text-truncate">${escapeHtml(stock.description)} (${escapeHtml(stock.displaySymbol)})</span>
                            <small class="text-muted">${escapeHtml(stock.type || "Symbol")}</small>
                        </li>
                    `).join("");

                    if (!results.length) {
                        resultsEl.innerHTML = '<li class="list-group-item text-muted">No matches found</li>';
                    }

                    resultsEl.style.display = "block";
                })
                .catch(error => {
                    console.error("Error:", error);
                    resultsEl.innerHTML = '<li class="list-group-item text-danger">Search failed</li>';
                    resultsEl.style.display = "block";
                });
        }

        if (searchButton) searchButton.addEventListener("click", runStockSearch);
        if (searchInput) {
            searchInput.addEventListener("keydown", event => {
                if (event.key === "Enter") runStockSearch();
            });
        }

        document.addEventListener("click", function(event) {
            if (!searchInput.contains(event.target) && !resultsEl.contains(event.target) && !searchButton.contains(event.target)) {
                resultsEl.style.display = "none";
            }
        });
    });
</script>
@endsection
