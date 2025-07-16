@extends('layout.contentslayout')

@section('title', 'Reports & Analytics')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Reports & Analytics</li>
@endsection

@section('maincontents')
    <h1 class="font-weight-bold">Reports & Analytics</h1>
    <div class="row active" >
        <div class="col-xxl-12 col-xl-12 show mt-3" >
            <div class="row g-4" >
                <div class="col-12 col-sm-6 col-lg-3" >
                    <div class="card" >
                        <div class="bg-primary text-white p-3 card-img-top" >
                            <div class="d-flex justify-content-between align-items-center" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up">
                                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                    <polyline points="16 7 22 7 22 13"></polyline>
                                </svg>
                                <span class="small fw-medium">↑ +12.5%</span>
                            </div>
                            <h3 class="mt-2 fs-4 fw-bold text-white mb-0">$6,840.50</h3>
                        </div>
                        <div class="card-body" >
                            <p class="small text-muted fw-medium mb-0">Monthly Income</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3" >
                    <div class="card" >
                        <div class="bg-danger text-white p-3 card-img-top" >
                            <div class="d-flex justify-content-between align-items-center" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="M10 9H8"></path>
                                    <path d="M16 13H8"></path>
                                    <path d="M16 17H8"></path>
                                </svg>
                                <span class="small fw-medium">↑ +5.2%</span>
                            </div>
                            <h3 class="mt-2 fs-4 fw-bold text-white mb-0">$4,385.75</h3>
                        </div>
                        <div class="card-body" >
                            <p class="small text-muted fw-medium mb-0">Monthly Expenses</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3" >
                    <div class="card" >
                        <div class="bg-warning text-white p-3 card-img-top" >
                            <div class="d-flex justify-content-between align-items-center" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-chart-column">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="M8 18v-1"></path>
                                    <path d="M12 18v-6"></path>
                                    <path d="M16 18v-3"></path>
                                </svg>
                                <span class="small fw-medium">↑ +18.3%</span>
                            </div>
                            <h3 class="mt-2 fs-4 fw-bold text-white mb-0">$2,454.75</h3>
                        </div>
                        <div class="card-body" >
                            <p class="small text-muted fw-medium mb-0">Total Savings</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3" >
                    <div class="card" >
                        <div class="bg-success text-white p-3 card-img-top" >
                            <div class="d-flex justify-content-between align-items-center" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-pie">
                                    <path d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z">
                                    </path>
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                </svg>
                                <span class="small fw-medium">– No change</span>
                            </div>
                            <h3 class="mt-2 fs-4 fw-bold text-white mb-0 ">12</h3>
                        </div>
                        <div class="card-body" >
                            <p class="small text-muted fw-medium mb-0">Active Categories</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-xl-3 col-sm-6">
                <div class="analytics-widget">
                    <div class="widget-icon me-3 bg-primary"><span><i class="fi fi-rr-mobile"></i></span>
                    </div>
                    <div class="widget-content">
                        <p>Daily Average</p>
                        <h3>$5470.36</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="analytics-widget">
                    <div class="widget-icon me-3 bg-success"><span><i class="fi fi-rr-replace"></i></span>
                    </div>
                    <div class="widget-content">
                        <p>Change</p>
                        <h3>+47.36%</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="analytics-widget">
                    <div class="widget-icon me-3 bg-warning"><span><i class="fi fi-rs-receipt"></i></span>
                    </div>
                    <div class="widget-content">
                        <p>Total Transaction</p>
                        <h3>354</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="analytics-widget">
                    <div class="widget-icon me-3 bg-danger">
                        <span><i class="fi fi-ss-confetti"></i></span>
                    </div>
                    <div class="widget-content">
                        <p>Categories</p>
                        <h3>40</h3>
                    </div>
                </div>
            </div>
                <div class="col-xl-12" >
                    <div class="card" >
                        <div class="card-header" >
                            <h4 class="card-title">Weekly Expenses </h4>
                        </div>
                        <div class="card-body" ><div class="chartjs-size-monitor" ><div class="chartjs-size-monitor-expand" ><div class="" ></div></div><div class="chartjs-size-monitor-shrink" ><div class="" ></div></div></div>
                            <canvas id="chartjsWeeklyExpenses" height="590" style="display: block; height: 295px; width: 1248px;" width="2496" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
