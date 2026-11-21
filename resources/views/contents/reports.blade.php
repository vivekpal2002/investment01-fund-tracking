@extends('layout.contentslayout')

@section('title', 'Reports & Analytics')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Reports & Analytics</li>
@endsection

@section('maincontents')
    <style>
        .report-summary-card {
            overflow: hidden;
        }

        .report-stat-value {
            word-break: break-word;
        }

        .report-analytics-widget {
            min-height: 96px;
            background: var(--bs-card-bg, #fff);
            border: 1px solid rgba(93, 135, 255, 0.14);
            border-radius: 8px;
            box-shadow: 0 12px 24px rgba(145, 158, 171, 0.12);
            padding: 16px;
        }

        .report-analytics-widget .widget-icon {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 44px;
            border-radius: 8px;
            color: #fff;
            font-size: 22px;
        }

        .report-analytics-widget p,
        .report-analytics-widget h3 {
            margin-bottom: 0;
        }

        .report-chart {
            position: relative;
            width: 100%;
            height: 280px;
        }

        .report-chart-sm {
            height: 230px;
        }

        .report-chart-lg {
            height: 340px;
        }

        @media (max-width: 575.98px) {
            .report-chart,
            .report-chart-sm,
            .report-chart-lg {
                height: 260px;
            }
        }

        @media print {
            .left-sidebar,
            .app-header,
            .app-topstrip,
            .breadcrumb,
            .report-export-btn {
                display: none !important;
            }

            .body-wrapper,
            .body-wrapper-inner {
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
        <h1 class="font-weight-bold mb-0">Reports & Analytics</h1>
        <button type="button" class="btn btn-outline-primary report-export-btn" onclick="window.print()">
            <i class="ti ti-download me-1"></i> Export PDF
        </button>
    </div>
    <div class="row active">
        <div class="col-xxl-12 col-xl-12 show mt-3">
            <div class="row g-4" >
                <div class="col-12 col-sm-6 col-lg-3" >
                    <div class="card report-summary-card h-100" >
                        <div class="bg-primary text-white p-3 card-img-top" >
                            <div class="d-flex justify-content-between align-items-center" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up">
                                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                    <polyline points="16 7 22 7 22 13"></polyline>
                                </svg>
                                <span class="small fw-medium">{{ $incomeChange >= 0 ? '↑ +' : '↓ ' }}{{ $incomeChange }}%</span>
                            </div>
                            <h3 class="mt-2 fs-4 fw-bold text-white mb-0 report-stat-value">₹{{ number_format($monthlyIncome, 2) }}</h3>
                        </div>
                        <div class="card-body" >
                            <p class="small text-muted fw-medium mb-0">Monthly Income</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3" >
                    <div class="card report-summary-card h-100" >
                        <div class="bg-danger text-white p-3 card-img-top" >
                            <div class="d-flex justify-content-between align-items-center" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="M10 9H8"></path>
                                    <path d="M16 13H8"></path>
                                    <path d="M16 17H8"></path>
                                </svg>
                                <span class="small fw-medium">{{ $expenseChange >= 0 ? '↑ +' : '↓ ' }}{{ $expenseChange }}%</span>
                            </div>
                            <h3 class="mt-2 fs-4 fw-bold text-white mb-0 report-stat-value">₹{{ number_format($monthlyExpenses, 2) }}</h3>
                        </div>
                        <div class="card-body" >
                            <p class="small text-muted fw-medium mb-0">Monthly Expenses</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3" >
                    <div class="card report-summary-card h-100" >
                        <div class="bg-warning text-white p-3 card-img-top" >
                            <div class="d-flex justify-content-between align-items-center" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-chart-column">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="M8 18v-1"></path>
                                    <path d="M12 18v-6"></path>
                                    <path d="M16 18v-3"></path>
                                </svg>
                                <span class="small fw-medium">Current total</span>
                            </div>
                            <h3 class="mt-2 fs-4 fw-bold text-white mb-0 report-stat-value">₹{{ number_format($totalSavings, 2) }}</h3>
                        </div>
                        <div class="card-body" >
                            <p class="small text-muted fw-medium mb-0">Total Savings</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3" >
                    <div class="card report-summary-card h-100" >
                        <div class="bg-success text-white p-3 card-img-top" >
                            <div class="d-flex justify-content-between align-items-center" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-pie">
                                    <path d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z">
                                    </path>
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                </svg>
                                <span class="small fw-medium">– No change</span>
                            </div>
                            <h3 class="mt-2 fs-4 fw-bold text-white mb-0 ">{{ $activeCategories }}</h3>
                        </div>
                        <div class="card-body" >
                            <p class="small text-muted fw-medium mb-0">Active Categories</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-1" >
                <div class="col-xl-3 col-sm-6">
                <div class="report-analytics-widget d-flex align-items-center">
                    <div class="widget-icon me-3 bg-primary"><span><i class="ti ti-calendar-stats"></i></span>
                    </div>
                    <div class="widget-content">
                        <p>Daily Average</p>
                        <h3>₹{{ number_format($dailyAverage, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="report-analytics-widget d-flex align-items-center">
                    <div class="widget-icon me-3 bg-success"><span><i class="ti ti-refresh"></i></span>
                    </div>
                    <div class="widget-content">
                        <p>Change</p>
                        <h3>{{ $expenseChange >= 0 ? '+' : '' }}{{ $expenseChange }}%</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="report-analytics-widget d-flex align-items-center">
                    <div class="widget-icon me-3 bg-warning"><span><i class="ti ti-receipt"></i></span>
                    </div>
                    <div class="widget-content">
                        <p>Total Transaction</p>
                        <h3>{{ $transactionCount }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="report-analytics-widget d-flex align-items-center">
                    <div class="widget-icon me-3 bg-danger">
                        <span><i class="ti ti-category"></i></span>
                    </div>
                    <div class="widget-content">
                        <p>Categories</p>
                        <h3>{{ $activeCategories }}</h3>
                    </div>
                </div>
            </div>
                <div class="col-xl-8 mt-3">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Net Worth Timeline</h4>
                            <span class="text-muted small">Wallets + investments + goals</span>
                        </div>
                        <div class="card-body">
                            <div class="report-chart report-chart-lg">
                                <canvas id="netWorthTimeline"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mt-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Top Spending Categories</h4>
                        </div>
                        <div class="card-body">
                            <div class="report-chart report-chart-sm">
                                <canvas id="topCategoriesChart"></canvas>
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table table-sm align-middle mb-0">
                                    <tbody>
                                        @forelse($topCategories as $category => $amount)
                                            <tr>
                                                <td>{{ $category }}</td>
                                                <td class="text-end">₹{{ number_format($amount, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-muted text-center">No spending this month</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mt-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Month-over-Month Cashflow</h4>
                        </div>
                        <div class="card-body">
                            <div class="report-chart">
                                <canvas id="monthlyCashflowChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mt-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="card-title mb-0">SIP / Goal Planner</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Target Amount</label>
                                    <input type="number" min="0" step="0.01" class="form-control" id="plannerTarget" placeholder="500000">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Current Amount</label>
                                    <input type="number" min="0" step="0.01" class="form-control" id="plannerCurrent" placeholder="100000">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Target Date</label>
                                    <input type="date" class="form-control" id="plannerDate">
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Required Monthly SIP</p>
                                        <h3 class="mb-0" id="plannerMonthly">₹0.00</h3>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3 h-100">
                                        <p class="text-muted mb-1">Months Remaining</p>
                                        <h3 class="mb-0" id="plannerMonths">0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mt-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="card-title mb-0">By Sector</h4>
                        </div>
                        <div class="card-body">
                            <div class="report-chart report-chart-sm">
                                <canvas id="sectorAllocationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mt-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="card-title mb-0">By Exchange</h4>
                        </div>
                        <div class="card-body">
                            <div class="report-chart report-chart-sm">
                                <canvas id="exchangeAllocationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mt-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="card-title mb-0">By Goal</h4>
                        </div>
                        <div class="card-body">
                            <div class="report-chart report-chart-sm">
                                <canvas id="goalAllocationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mt-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="card-title mb-0">By Asset Type</h4>
                        </div>
                        <div class="card-body">
                            <div class="report-chart report-chart-sm">
                                <canvas id="assetTypeAllocationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12" >
                    <div class="card" >
                        <div class="card-header" >
                            <h4 class="card-title">Weekly Expenses </h4>
                        </div>
                        <div class="card-body">
                            <div class="report-chart report-chart-lg">
                                <canvas id="chartjsWeeklyExpenses"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') return;

            const chartColors = ['#5D87FF', '#13DEB9', '#FFAE1F', '#FA896B', '#49BEFF', '#7C8FAC'];
            const currency = new Intl.NumberFormat('en-IN', {
                style: 'currency',
                currency: 'INR',
                maximumFractionDigits: 2
            });

            function chartElement(id) {
                return document.getElementById(id);
            }

            function hasData(values) {
                return Array.isArray(values) && values.some(value => Number(value) > 0);
            }

            function doughnutChart(id, labels, values) {
                const canvas = chartElement(id);
                if (!canvas || !hasData(values)) return;

                new Chart(canvas, {
                    type: 'doughnut',
                    data: {
                        labels,
                        datasets: [{
                            data: values,
                            backgroundColor: chartColors,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 10 }
                            }
                        }
                    }
                });
            }

            const weeklyCanvas = chartElement('chartjsWeeklyExpenses');
            if (weeklyCanvas) {
                new Chart(weeklyCanvas, {
                    type: 'bar',
                    data: {
                        labels: @json($weeklyLabels),
                        datasets: [{
                            label: 'Expenses',
                            data: @json($weeklyExpenses),
                            backgroundColor: '#5D87FF',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            const netWorthCanvas = chartElement('netWorthTimeline');
            if (netWorthCanvas) {
                new Chart(netWorthCanvas, {
                    type: 'line',
                    data: {
                        labels: @json($monthLabels),
                        datasets: [
                            {
                                label: 'Net Worth',
                                data: @json($netWorthSeries),
                                borderColor: '#5D87FF',
                                backgroundColor: 'rgba(93, 135, 255, 0.12)',
                                fill: true,
                                tension: 0.35
                            },
                            {
                                label: 'Wallets',
                                data: @json($walletBalanceSeries),
                                borderColor: '#13DEB9',
                                tension: 0.35
                            },
                            {
                                label: 'Investments',
                                data: @json($investmentValueSeries),
                                borderColor: '#FFAE1F',
                                tension: 0.35
                            },
                            {
                                label: 'Goals',
                                data: @json($goalValueSeries),
                                borderColor: '#FA896B',
                                tension: 0.35
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom' } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            const cashflowCanvas = chartElement('monthlyCashflowChart');
            if (cashflowCanvas) {
                new Chart(cashflowCanvas, {
                    type: 'bar',
                    data: {
                        labels: @json($monthLabels),
                        datasets: [
                            {
                                label: 'Income',
                                data: @json($monthlyIncomeSeries),
                                backgroundColor: '#13DEB9',
                                borderRadius: 6
                            },
                            {
                                label: 'Expenses',
                                data: @json($monthlyExpenseSeries),
                                backgroundColor: '#FA896B',
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom' } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            doughnutChart('topCategoriesChart', @json($topCategories->keys()->values()), @json($topCategories->values()->values()));
            doughnutChart('sectorAllocationChart', @json($sectorAllocation->keys()->values()), @json($sectorAllocation->values()->values()));
            doughnutChart('exchangeAllocationChart', @json($exchangeAllocation->keys()->values()), @json($exchangeAllocation->values()->values()));
            doughnutChart('goalAllocationChart', @json($goalAllocation->keys()->values()), @json($goalAllocation->values()->values()));
            doughnutChart('assetTypeAllocationChart', @json($assetTypeAllocation->keys()->values()), @json($assetTypeAllocation->values()->values()));

            const targetInput = chartElement('plannerTarget');
            const currentInput = chartElement('plannerCurrent');
            const dateInput = chartElement('plannerDate');
            const monthlyOutput = chartElement('plannerMonthly');
            const monthsOutput = chartElement('plannerMonths');

            function updatePlanner() {
                const target = Number(targetInput.value || 0);
                const current = Number(currentInput.value || 0);
                const targetDate = dateInput.value ? new Date(dateInput.value + 'T00:00:00') : null;
                const today = new Date();

                let months = 0;
                if (targetDate && targetDate > today) {
                    months = Math.max(1, ((targetDate.getFullYear() - today.getFullYear()) * 12) + targetDate.getMonth() - today.getMonth());
                }

                const remaining = Math.max(0, target - current);
                const monthly = months > 0 ? remaining / months : 0;

                monthlyOutput.textContent = currency.format(monthly);
                monthsOutput.textContent = months;
            }

            [targetInput, currentInput, dateInput].forEach(input => {
                if (input) input.addEventListener('input', updatePlanner);
            });

            updatePlanner();
        });
    </script>
@endsection
