@extends('layout.contentslayout')
@section('maincontents')
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!--  App Topstrip -->
        <div class="app-topstrip bg-dark py-3 px-4 w-100 d-lg-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center justify-content-center gap-3 mb-3 mb-lg-0">
                <a class="d-flex justify-content-center"
                    href="\">
          <img  src="{{ asset('images/logos/Investment-2.png') }}" alt=""
                    width="150">
                </a>
            </div>

            <div class="d-lg-flex align-items-center gap-3">

                <div class="d-sm-flex align-items-center justify-content-center gap-8">
                    <div class="d-flex align-items-center justify-content-center gap-8">
                    </div>
                </div>
            </div>

        </div>
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="/" class="text-nowrap logo-img">
                        <img src="{{ asset('images/logos/Investment.png') }}" width="180" height="50"
                            alt="Investment Tracker Logo">
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-6"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/" aria-expanded="false">
                                <i class="ti ti-atom"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <!-- ---------------------------------- -->
                        <!-- Dashboard -->
                        <!-- ---------------------------------- -->

                        <li>
                            <span class="sidebar-divider lg"></span>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Auth</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/login" aria-expanded="false">
                                <i class="ti ti-login"></i>
                                <span class="hide-menu">Login</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/register" aria-expanded="false">
                                <i class="ti ti-user-plus"></i>
                                <span class="hide-menu">Register</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light ">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link " href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ti ti-bell"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-animate-up cls_notiicon" aria-labelledby="drop1">
                                <div class="message-body">
                                    <a href="javascript:void(0)" class="dropdown-item">
                                        Item 1
                                    </a>
                                    <a href="javascript:void(0)" class="dropdown-item">
                                        Item 2
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="search ">
                        <form action="#">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Search Here">
                            </div>
                        </form>
                    </div>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <h4 class="btn btn-primary">Hi {{ Auth::user()->name ?? 'User' }}! </h4>
                            <li class="nav-item dropdown">
                                <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{ asset('images/profile/user-1.jpg') }}" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">My Account</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-list-check fs-6"></i>
                                            <p class="mb-0 fs-3">My Task</p>
                                        </a>
                                        <a href="/logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="body-wrapper-inner">
                <div class="container-fluid">
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

    @endsection
