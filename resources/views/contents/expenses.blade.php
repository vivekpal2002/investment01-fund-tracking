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
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-10 ">
                                <div class="card shadow-sm w-100 {{ $index === 0 ? 'border-primary' : '' }}"
                                    data-bs-toggle="pill" data-bs-target="#{{ $budget['id'] }}"
                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}" role="tab">

                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <!-- Header Section -->
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                <div>
                                                    <h5 class="mb-0">{{ $budget['name'] }}</h5>
                                                    <small class="text-muted">₹{{ $budget['amount'] }}</small><br>
                                                    @if ($budget['amount'] <= 0)
                                                        <small class="text-danger fw-bolder"> • Add the your traget of this
                                                            month</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Progress Section -->
                                        <div class="mt-4">
                                            <div class="d-flex justify-content-between small text-muted mb-1">
                                                <span>₹{{ $budget['spent'] }}</span>
                                                <span>₹{{ $budget['budget'] }}</span>
                                            </div>
                                            <div class="progress rounded-pill" style="height: 6px;">
                                                <div class="progress-bar bg-primary"
                                                    style="width: {{ round(($budget['spent'] / $budget['budget']) * 100, 2) }}%;">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2 small">
                                                <span
                                                    class="fw-semibold">{{ round(($budget['spent'] / $budget['budget']) * 100) }}%</span>
                                                <span class="text-success">On track</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-12 col-sm-6 col-md-6 col-lg-5 col-xl-12 p-3">
                            <div class="budgets-nav w-75">
                                <h5 class="mb-0" data-bs-toggle="modal" data-bs-target="#addexpense">Add new budget <i class="ti ti-circle-plus ps-xl-2"></i></h5>
                            </div>
                        </div>
                        <!--Add Expense Modal -->
                        <div class="modal fade" id="addexpense" tabindex="-1" aria-labelledby="addexpense"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <h4 class="modal-title" id="myLargeModalLabel">
                                            Add Expense
                                        </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action={{ route('budget.create') }} method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="name" class="form-label">Account Name</label>
                                                <input type="text" class="form-control" name="name" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="name" class="form-label">Bank Account Name</label>
                                                <input type="text" class="form-control" name="bank_name" required
                                                    placeholder="e.g., SBI Bank, Indian Bank...">
                                            </div>
                                            <div class="mb-3">
                                                <label for="balance" class="form-label">Initial Balance (₹)</label>
                                                <input type="number" step="0.01" class="form-control" name="balance"
                                                    required>
                                            </div>

                                            <div class="mb-3" id="expiryDiv" style="display: none;">
                                                <label for="expiry_date" class="form-label">Expiry Date</label>
                                                <input type="month" class="form-control" name="expiry_date"
                                                    placeholder="MM/YYYY">
                                            </div>

                                            <div class="mb-3">
                                                <label for="notes" class="form-label">Notes (optional)</label>
                                                <textarea name="notes" class="form-control" rows="2" placeholder="e.g., My main bank account"></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="acc_created_at" class="form-label">Date Created</label>
                                                <input type="date" name="acc_created_at" class="form-control">
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary  waves-effect text-start"
                                            data-bs-dismiss="modal">
                                            Create Expense
                                        </button>
                                        <button type="button"
                                            class="btn bg-danger-subtle text-danger  waves-effect text-start"
                                            data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        </form>
                                    </div>
                                </div>
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
                                    <x-budget-card title="Total Budget" value="₹{{ $budget['budget'] }}"
                                        icon="fi fi-rr-dollar" color="primary" />
                                </div>
                                <div class="col-md-4">
                                    <x-budget-card title="Spent" value="₹{{ $budget['spent'] }}" icon="fi fi-rr-dollar"
                                        color="secondary" />
                                </div>
                                <div class="col-md-4">
                                    <x-budget-card title="Remaining" value="₹{{ $budget['budget'] - $budget['spent'] }}"
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
                                        <div class="fw-medium">₹{{ $budget['spent'] }} spent</div>
                                        <div class="text-muted">₹{{ $budget['budget'] }} total</div>
                                    </div>
                                    <div class="progress rounded-pill">
                                        <div class="progress-bar bg-warning"
                                            style="width: {{ round(($budget['spent'] / $budget['budget']) * 100) }}%;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Comparative Analysis -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h4 class="fw-medium">Comparative Analysis</h4>
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <span>Previous Period</span>
                                        <span>₹{{ $budget['last_month']['expense'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <span>Current Period</span>
                                        <span>₹{{ $budget['spent'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between pt-2">
                                        <span>Variance</span>
                                        @php
                                            $variance = $budget['spent'] - $budget['last_month']['expense'];
                                        @endphp
                                        <span class="{{ $variance >= 0 ? 'text-danger' : 'text-success' }}">
                                            {{ $variance >= 0 ? '+' : '-' }}
                                            {{ abs($variance) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- ChartJS -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h4 class="card-title">Budget Period</h4>
                                </div>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <canvas id="overallBudgetChart" data-budgets='@json($budgets)' height="100"></canvas>
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
