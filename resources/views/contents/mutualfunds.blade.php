@extends('layout.contentslayout')
@section('title', 'Mutual-Funds')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Mutual-Funds</li>
@endsection
@section('maincontents')
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch from Alpha Vantage API
$json = file_get_contents('https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=IBM&apikey=demo');
$data = json_decode($json, true);

$stockname=($data['Meta Data']['2. Symbol']);
// Extract time series data
$timeSeries = $data['Time Series (Daily)'] ?? [];

// Prepare arrays
$dates = [];
$navs = [];

// Loop through only the last 10 entries
foreach (array_slice($timeSeries, 0, 10) as $date => $info) {
    $formattedDate = date('M d', strtotime($date)); // Format as "Jul 17"
    $dates[] = $formattedDate;
    $navs[] = (float)$info['4. close'];
}

// Reverse for chronological order
$dates = array_reverse($dates);
$navs = array_reverse($navs);
?>



    <h1 class="font-weight">Mutual-Funds</h1>
    <div class="row">

        @foreach ($investments as $investment)
            <div class="col-xl-3 col-lg-6 col-sm-6 col-12 pb-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <button type="button" class="btn btn-sm btn-{{ $investment->color ?? 'dark' }} rounded-pill">
                                <i class="fa fa-{{ $investment->icon ?? 'briefcase' }} me-1"></i>
                                {{ $investment->name }}
                            </button>
                            <div class="text-end">
                                <a href="#" class="text-dark fw-semibold d-block">{{ $investment->ticker }}</a>
                                <span class="{{ $investment->change >= 0 ? 'text-success' : 'text-danger' }} small">
                                    {{ $investment->change >= 0 ? '+' : '' }}{{ $investment->change }}%
                                </span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Portfolio</p>
                                <h4 class="fw-bold mb-0">₹{{ number_format($investment->value, 2) }}</h4>
                            </div>
                            <div class="sparkline-chart" style="width: 100px; height: 40px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-xl-3 col-lg-6 col-sm-6 col-12 pb-3">
            <div class="card shadow-sm border-dashed border-1 border-secondary h-100 text-center d-flex align-items-center justify-content-center"
                style="min-height: 150px;">
                {{-- <a href="{{ route('investments.create') }}" class="text-secondary text-decoration-none"> --}}
                <i class="fa fa-plus-circle fa-2x mb-2"></i>
                <p class="mb-0">Add Stock</p>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8 col-lg-12 pt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">📈 NAV Performance</h3>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3"> {{$stockname}}</h5>

                    <!-- Chart Container -->
                    <div id="main-performance-graph" style="height: 350x;"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-12 mb-4 pt-4">
            <h4 class="mb-3 d-flex justify-content-between align-items-center">
                <span>Details</span>
            </h4>

            <!-- Info Card -->
            <div class="card mb-3 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="text-success mb-0">S&P 500</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            24 h
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="ti-import me-2"></i>Import</a></li>
                            <li><a class="dropdown-item" href="#"><i class="ti-export me-2"></i>Export</a></li>
                            <li><a class="dropdown-item" href="#"><i class="ti-printer me-2"></i>Print</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="ti-settings me-2"></i>Settings</a></li>
                        </ul>
                    </div>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Previous Close</span>
                        <span>4,500.50</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Day Range</span>
                        <span>3,588 – 5,415</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Year Range</span>
                        <span>6,200 – 4,500</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Market Cap</span>
                        <span>$90.3T USD</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Volume</span>
                        <span>3,852,852</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">P/E Ratio</span>
                        <span>51.05</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Exchange</span>
                        <span>Index</span>
                    </li>
                </ul>
            </div>

            <!-- Market Cap Card -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <strong class="fs-4">M</strong>
                        </div>
                        <div class="ms-3">
                            <p class="mb-1 text-muted small">Market Cap</p>
                            <h5 class="mb-0 fw-semibold">$40</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        let categories = <?php echo json_encode($dates); ?>;
        let dataPoints = <?php echo json_encode($navs); ?>;

        let largeChartOptions = {
            chart: {
                type: 'line',
                zoom: {
            enabled: false
          },
                height: 335,
                toolbar: { show: false }
            },
            series: [{
                name: 'NAV',
                data: dataPoints
            }],
            xaxis: {
                categories: categories
            },
            stroke: { curve: 'smooth', width: 3 },
            colors: ['#007bff'],
            markers: { size: 4 }
        };

        new ApexCharts(document.querySelector("#main-performance-graph"), largeChartOptions).render();
    </script>

@endsection
