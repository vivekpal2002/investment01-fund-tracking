@extends('layout.contentslayout')
@section('title', 'Goal')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Goal</li>
@endsection
@section('maincontents')
    <h1 class="font-weight">Goal</h1>
    <div class="goals-tab">
        <div class="row g-0">
            <div class="col-xl-3">
                <div class="nav d-block" role="tablist">
                    <div class="row">
                        @foreach ($goals as $index => $goal)
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-10 mb-4">
                                <div class="card shadow-sm h-100 {{ $index == 0 ? 'border-primary' : '' }}"
                                    data-bs-toggle="pill" data-bs-target="#{{ $goal['id'] }}"
                                    aria-selected="{{ $index == 0 ? 'true' : 'false' }}" role="tab"
                                    tabindex="{{ $index == 0 ? '0' : '-1' }}">

                                    <div class="card-body">
                                        <div class="d-flex flex-column justify-content-between h-100">
                                            <!-- Title -->
                                            <h5 class="card-title mb-2">{{ $goal['title'] }}</h5>

                                            <!-- Progress Text -->
                                            <p class="card-text text-muted mb-2">
                                                <strong>₹{{ number_format($goal['current'], 2) }}</strong>
                                                &nbsp;/ ₹{{ number_format($goal['target'], 2) }}
                                            </p>

                                            <!-- Progress Bar -->
                                            @php
                                                $percent =
                                                    $goal['target'] > 0
                                                        ? round(($goal['current'] / $goal['target']) * 100, 2)
                                                        : 0;
                                            @endphp

                                            <div class="progress rounded-pill" style="height: 6px;">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ min($percent, 100) }}%;">
                                                </div>
                                            </div>

                                            <!-- Bottom text -->
                                            <div class="d-flex justify-content-between mt-2 small text-muted">
                                                <span>{{ $percent }}%</span>
                                                <span>{{ $percent >= 100 ? 'Goal Achieved' : 'In Progress' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="add-goals-link">
                    <h5 class="mb-0">Add new goals</h5>
                    <a href="{{ url('add-new-account.html') }}">
                        <i class="fi fi-rr-square-plus"></i>
                    </a>
                </div>
            </div>


            <div class="col-xl-9">
                <div class="tab-content goals-tab-content">
                    @foreach ($goals as $index => $goal)
                        <div class="tab-pane {{ $index === 0 ? 'active show' : '' }}" id="{{ $goal['id'] }}"
                            role="tabpanel">
                            <div class="goals-tab-title">
                                <h3>{{ $goal['title'] }}</h3>
                            </div>

                            {{-- Saved & Goal Card --}}
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span>Saved</span>
                                                    <h3>₹{{ number_format($goal['current'], 2) }}</h3>
                                                </div>
                                                <div class="text-end">
                                                    <span>Goals</span>
                                                    <h3>₹{{ number_format($goal['target'], 2) }}</h3>
                                                </div>
                                            </div>
                                            @php
                                                $percent = round(($goal['current'] / $goal['target']) * 100);
                                                $remaining = 100 - $percent;
                                            @endphp
                                            <div class="progress">
                                                <div class="progress-bar" style="width: {{ $percent }}%;"
                                                    role="progressbar"></div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span>{{ $percent }}%</span>
                                                <span>{{ $remaining }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Goals Widgets --}}
                                <div class="col-xxl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                    <div class="goals-widget">
                                                        <p>Last Month</p>
                                                        <h3>₹42,678</h3>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                    <div class="goals-widget">
                                                        <p>Expenses</p>
                                                        <h3>₹1,798</h3>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                    <div class="goals-widget">
                                                        <p>Taxes</p>
                                                        <h3>₹255.25</h3>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                    <div class="goals-widget">
                                                        <p>Debt</p>
                                                        <h3>₹365,478</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Wallet Section --}}
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Available by Wallet</h4>
                                        </div>
                                        <div class="card-body available-wallet">
                                            @foreach ($goal['wallets'] as $wallet)
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="{{ $wallet['bg'] }}"><i
                                                                    class="fi {{ $wallet['icon'] }}"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">{{ $wallet['name'] }}</h5>
                                                                <p class="mb-0">₹{{ $wallet['amount'] }}</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: {{ $wallet['percent'] }}%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- History Table --}}
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">History</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table mb-0 table-responsive-sm goals-history-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Wallet</th>
                                                            <th>Description</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($goal['history'] as $row)
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    {{ $row['date'] }}</td>
                                                                <td><span><i class="fi fi-rr-credit-card"></i></span>
                                                                    {{ $row['wallet'] }}</td>
                                                                <td>{{ $row['desc'] }}</td>
                                                                <td>
                                                                    <h5>{{ $row['amount'] }}</h5>
                                                                    <span>{{ $row['balance'] }}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
