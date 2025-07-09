@extends('layout.contentslayout')
@section('maincontents')
    @include('barmenu.menu')
    <!--  Header End -->
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <div class="dashbord-front-view">
                <h1 class="font-weight">Dashboard</h1>

                <div class="custom-grid">
                    <!-- W1 -->
                    <div class="widget card" style="min-height: 150px;">
                        <div class="card-body">
                            <h4 class="card-title fw-semibold">Total Balance</h4>
                            <h4 class="fw-semibold mb-3">₹6,820</h4>
                            <div class="d-flex align-items-center">
                                <span
                                    class="me-2 rounded-circle bg-danger-subtle round-20 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-arrow-down-right text-danger"></i>
                                </span>
                                <p class="text-dark me-1 fs-6 mb-0">+9%</p>
                                <p class="fs-6 mb-0">last month</p>
                            </div>
                        </div>
                        <div id="bar_column"></div>
                    </div>

                    <!-- W2 -->
                    <div class="widget card" style="min-height: 150px;">
                        <div class="card-body">
                            <h4 class="card-title fw-semibold">Total Period Balance</h4>
                            <h4 class="fw-semibold mb-3">₹6,820</h4>
                            <div class="d-flex align-items-center">
                                <span
                                    class="me-2 rounded-circle bg-danger-subtle round-20 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-arrow-down-right text-danger"></i>
                                </span>
                                <p class="text-dark me-1 fs-6 mb-0">+9%</p>
                                <p class="fs-6 mb-0">last month</p>
                            </div>
                        </div>
                        <div id="bar_column_1"></div>
                    </div>

                    <!-- W3 - CHART spanning two rows -->
                    <div class="chart card">
                        <div class="card-body">
                            <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                                <h5 class="card-title fw-semibold">Sales Overview</h5>
                                <select class="form-select w-auto">
                                    <option>March 2025</option>
                                    <option>April 2025</option>
                                    <option>May 2025</option>
                                    <option>June 2025</option>
                                </select>
                            </div>
                            <div id="earning" style="min-height: 250px;"></div>
                        </div>
                    </div>

                    <!-- W4 -->
                    <div class="widget card" style="min-height: 150px;">
                        <div class="card-body">
                            <h4 class="card-title fw-semibold">Total Period Expense</h4>
                            <h4 class="fw-semibold mb-3">₹6,820</h4>
                            <div class="d-flex align-items-center">
                                <span
                                    class="me-2 rounded-circle bg-danger-subtle round-20 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-arrow-down-right text-danger"></i>
                                </span>
                                <p class="text-dark me-1 fs-6 mb-0">+9%</p>
                                <p class="fs-6 mb-0">last month</p>
                            </div>
                        </div>
                        <div id="bar_column_2"></div>
                    </div>

                    <!-- W5 -->
                    <div class="widget card" style="min-height: 150px;">
                        <div class="card-body">
                            <h4 class="card-title fw-semibold">Total Period Income</h4>
                            <h4 class="fw-semibold mb-3">₹6,820</h4>
                            <div class="d-flex align-items-center">
                                <span
                                    class="me-2 rounded-circle bg-danger-subtle round-20 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-arrow-down-right text-danger"></i>
                                </span>
                                <p class="text-dark me-1 fs-6 mb-0">+9%</p>
                                <p class="fs-6 mb-0">last month</p>
                            </div>
                        </div>
                        <div id="bar_column_3"></div>
                    </div>
                </div>

                <div class="row g-3">
                    <!-- W1: Top Performers - 75% on large screens -->
                    <div class="col-lg-8 col-12">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-sm-flex d-block align-items-center justify-content-between mb-4">
                                    <div>
                                        <h4 class="card-title fw-semibold">Top Performers</h4>
                                        <p class="card-subtitle">Best Employees</p>
                                    </div>
                                    <div>
                                        <select class="form-select">
                                            <option>March 2024</option>
                                            <option>April 2024</option>
                                            <option>May 2024</option>
                                            <option>June 2024</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table align-middle text-nowrap mb-0">
                                        <thead>
                                            <tr class="text-muted fw-semibold">
                                                <th class="ps-0">Category</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border-top">
                                            <!-- Loop your performer rows here -->
                                            <!-- Example row -->
                                            <tr>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="../assets/images/profile/user-3.jpg"
                                                            class="rounded-circle me-2" width="40" height="40"
                                                            alt="">
                                                        <div>
                                                            <h6 class="fw-semibold mb-1">Sunil Joshi</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="mb-0 fs-3">Elite Admin</p>
                                                </td>
                                                <td style="white-space: normal; word-break: break-word;">
                                                    <p class="mb-0">Grocery items and beverages soft drinks</p>
                                                </td>
                                                <td>
                                                    <p class="fs-3 text-dark mb-0">₹3900</p>
                                                </td>
                                            </tr>
                                            <!-- Add more rows as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- W2: Sales Overview - 25% on large screens -->
                    <div class="col-lg-4 col-12">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title fw-semibold">Sales Overview</h4>
                                <p class="card-subtitle mb-2">Every Month</p>

                                <div id="breakup" class="mb-4" style="min-height: 222px;"></div>

                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="bg-primary-subtle text-primary rounded-2 me-2 p-2 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-grid-dots fs-6"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold text-dark fs-4 mb-0">₹23,450</h6>
                                            <p class="fs-3 mb-0 fw-normal">Profit</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="bg-secondary-subtle text-secondary rounded-2 me-2 p-2 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-grid-dots fs-6"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold text-dark fs-4 mb-0">₹23,450</h6>
                                            <p class="fs-3 mb-0 fw-normal">Expense</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
