@extends('layout.contentslayout')
@section('title', 'Expense Management')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Expense Management</li>
@endsection
@section('maincontents')
    <h1 class="font-weight">Expense Management</h1>
    <div class="budgets-tab">
        <div class="row g-0">
            <div class="col-xl-3">
                <div class="nav d-block" role="tablist">
                    <div class="row">
                        @foreach ($budgets as $index => $budget)
                            <div class="col-xl-12 col-md-6">
                                <div class="budgets-nav {{ $index === 0 ? 'active' : '' }}" data-bs-toggle="pill"
                                    data-bs-target="#{{ $budget['id'] }}"
                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}" role="tab">
                                    <div class="budgets-nav-content">
                                        <div class="budgets-nav-icon">
                                            <span><i class="{{ $budget['icon'] }}"></i></span>
                                        </div>
                                        <div class="budgets-nav-text">
                                            <h3>{{ $budget['name'] }}</h3>
                                            <p>${{ $budget['amount'] }}</p>
                                        </div>
                                        <span class="show-time">{{ $budget['period'] }}</span>
                                    </div>
                                    <!-- Progress -->
                                    <div class="mt-4 budgets-nav-progress">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div class="fw-medium small">${{ $budget['spent'] }}</div>
                                            <div class="text-dark-50 small">${{ $budget['budget'] }}</div>
                                        </div>
                                        <div class="progress rounded-pill" style="height: 6px;">
                                            <div class="progress-bar"
                                                style="width: {{ round(($budget['spent'] / $budget['budget']) * 100, 2) }}%;">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2 small">
                                            <div class="fw-medium">
                                                {{ round(($budget['spent'] / $budget['budget']) * 100) }}%</div>
                                            <div class="text-dark-50">On track</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-xl-12 col-md-6">
                            <div class="budgets-nav w-75">
                                <h5 class="mb-0">Add new budget
                                    {{-- <a href="{{ route('budget.create') }}"><i class="ti ti-circle-plus ps-xl-2"></i></a> --}}
                                </h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-9">
            <div class="tab-content budgets-tab-content">
                @foreach ($budgets as $index => $budget)
                    <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}" id="{{ $budget['id'] }}"
                        role="tabpanel">
                        <div class="d-flex justify-content-between align-items-start pb-3">
                            <div>
                                <h3 class="fw-semibold mb-1">{{ $budget['name'] }}</h3>
                                <p class="mb-0">Budget overview and analysis</p>
                            </div>
                            <!-- Add tab switchers and buttons as needed -->
                        </div>

                        <!-- Cards: Total Budget, Spent, Remaining -->
                        <div class="row g-3">
                            <div class="col-md-4">
                                <x-budget-card title="Total Budget" value="${{ $budget['budget'] }}" icon="fi fi-rr-dollar"
                                    color="primary" />
                            </div>
                            <div class="col-md-4">
                                <x-budget-card title="Spent" value="${{ $budget['spent'] }}" icon="fi fi-rr-dollar"
                                    color="secondary" />
                            </div>
                            <div class="col-md-4">
                                <x-budget-card title="Remaining" value="${{ $budget['budget'] - $budget['spent'] }}"
                                    icon="fi fi-rr-dollar" color="info" />
                            </div>
                        </div>

                        <!-- Utilization Progress -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <h4 class="fw-medium mb-0">Budget Utilization</h4>
                            </div>
                            <div class="card-body pt-0">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="fw-medium">${{ $budget['spent'] }} spent</div>
                                    <div class="text-muted">${{ $budget['budget'] }} total</div>
                                </div>
                                <div class="progress rounded-pill">
                                    <div class="progress-bar bg-warning"
                                        style="width: {{ round(($budget['spent'] / $budget['budget']) * 100) }}%;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Comparative Analysis -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <h4 class="fw-medium">Comparative Analysis</h4>
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <span>Previous Period</span>
                                    <span>${{ $budget['last_month'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <span>Current Period</span>
                                    <span>${{ $budget['spent'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between pt-2">
                                    <span>Variance</span>
                                    <span class="text-success">
                                        {{ $budget['spent'] - $budget['last_month'] >= 0 ? '+' : '-' }}
                                        {{ abs($budget['spent'] - $budget['last_month']) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- ChartJS -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h4 class="card-title">Budget Period</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="{{ $budget['chartId'] }}"></canvas>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </div>
    </div>
@endsection
