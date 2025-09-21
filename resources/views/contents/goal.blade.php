@extends('layout.contentslayout')
@section('title', 'Goals')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Goals</li>
@endsection

@section('maincontents')
<h1 class="font-weight-bold">Goals</h1>

<div class="row g-0 goals-tab">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    {{-- LEFT SIDE: Goal Cards --}}
    <div class="col-xl-3">
        <div class="nav d-block" role="tablist">
            <div class="row" style="max-height: 550px; width: 350px; overflow-y: auto;">
            @foreach ($goals as $index => $goal)
            <div class="col-12 mb-2 mt-3">
                @php
                    $percent = $goal->target_amount > 0 
                        ? round(($goal->current_amount / $goal->target_amount) * 100, 2)
                        : 0;

                    // Determine progress bar color
                    if($percent >= 100) $barColor = 'bg-success';
                    elseif($percent >= 50) $barColor = 'bg-warning';
                    else $barColor = 'bg-danger';
                @endphp

                <div class="card mb-3 shadow-sm h-100 {{ $index == 0 ? 'border-primary' : '' }}"
                     data-bs-toggle="pill"
                     data-bs-target="#goal-{{ $goal->id }}"
                     role="tab"
                     aria-selected="{{ $index == 0 ? 'true' : 'false' }}"
                     tabindex="{{ $index == 0 ? '0' : '-1' }}">
                    <div class="card-body">
                        <h5>{{ $goal->goal_category->name }}</h5>

                        {{-- Status Badge --}}
                        <span class="badge 
                            @if($goal->status == 'achieved') bg-success
                            @elseif($goal->status == 'in_progress') bg-primary
                            @elseif($goal->status == 'hold') bg-warning
                            @elseif($goal->status == 'cancelled') bg-danger
                            @endif">
                            {{ ucfirst(str_replace('_',' ',$goal->status)) }}
                        </span>

                        {{-- Progress Info --}}
                        <p class="text-muted mb-2 mt-1">
                            <strong>₹{{ number_format($goal->current_amount, 2) }}</strong> / 
                            ₹{{ number_format($goal->target_amount, 2) }}
                        </p>

                        {{-- Color-coded Progress Bar --}}
                        <div class="progress rounded-pill" style="height:6px;">
                            <div class="progress-bar {{ $barColor }}" style="width: {{ min($percent,100) }}%;"></div>
                        </div>

                        {{-- Percentage / Milestone Notification --}}
                        <div class="d-flex justify-content-between mt-2 small text-muted">
                            <span>{{ $percent }}%</span>
                            <span>
                                @if($percent >= 100)
                                    Goal Achieved! 🎉
                                @elseif($percent >= 75)
                                    Almost there! 🔔
                                @elseif($percent >= 50)
                                    Halfway done! ⚡
                                @else
                                    In Progress
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

            {{-- Add Goal Link --}}
            <div class="mt-2">
                <h5 class="mb-0 text-primary" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#addgoal">
                    Add New Goal <i class="ti ti-circle-plus ps-2"></i>
                </h5>
            </div>
        </div>
    </div>

    {{-- RIGHT SIDE: Goal Details --}}
    <div class="col-xl-9">
        <div class="tab-content goals-tab-content">
            @foreach ($goals as $index => $goal)
                @php
                    $percent = $goal->target_amount > 0 
                        ? round(($goal->current_amount / $goal->target_amount) * 100, 2)
                        : 0;
                    
                    if($percent >= 100) $barColor = 'bg-success';
                    elseif($percent >= 50) $barColor = 'bg-warning';
                    else $barColor = 'bg-danger';
                @endphp

                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="goal-{{ $goal->id }}" role="tabpanel">

                    {{-- Goal Header --}}
                    <div class="mb-1 d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-semibold mb-1">{{ $goal->goal_category->name }} </h3>
                            <p>{{ $goal->description ?? '' }}</p>
                        </div>

                        {{-- Status Badge --}}
                        <span class="badge 
                            @if($goal->status == 'achieved') bg-success
                            @elseif($goal->status == 'in_progress') bg-primary
                            @elseif($goal->status == 'hold') bg-warning
                            @elseif($goal->status == 'cancelled') bg-danger
                            @endif fs-6">
                            {{ ucfirst(str_replace('_',' ',$goal->status)) }}
                        </span>
                    </div>

                    {{-- Progress Card --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span>Saved</span>
                                    <h3>₹{{ number_format($goal->current_amount, 2) }}</h3>
                                </div>
                                <div class="text-end">
                                    <span>Target</span>
                                    <h3>₹{{ number_format($goal->target_amount, 2) }}</h3>
                                </div>
                            </div>
                            <div class="progress mt-2" style="height:6px;">
                                <div class="progress-bar {{ $barColor }}" style="width: {{ min($percent,100) }}%;"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 small">
                                <span>{{ $percent }}%</span>
                                <span>{{ 100 - $percent }}%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Wallet Contributions --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Wallet Contributions</h5>
                        </div>
                        <div class="card-body">
                            @forelse($goal->wallets as $wallet)
                                @php
                                    $walletPercent = $goal->target_amount > 0
                                        ? round(($wallet->pivot->amount / $goal->target_amount) * 100, 2)
                                        : 0;
                                @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $wallet->name }}</strong>
                                        <span>₹{{ number_format($wallet->pivot->amount,2) }} ({{ $walletPercent }}%)</span>
                                    </div>
                                    <div class="progress" style="height:6px;">
                                        <div class="progress-bar bg-info" style="width: {{ min($walletPercent,100) }}%;"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No wallet contributions yet.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Transaction History --}}
                    <div class="card">
                        <div class="card-header">
                            <h5>Transaction History</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Wallet</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Balance After</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($goal->transactions()->latest()->get() as $transaction)
                                        <tr>
                                            <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                                            <td>{{ $transaction->wallet->name }}</td>
                                            <td>{{ $transaction->description ?? '-' }}</td>
                                            <td>₹{{ number_format($transaction->amount, 2) }}</td>
                                            <td>₹{{ number_format($transaction->balance_after, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No transactions yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>

</div>

{{-- Add Goal Modal --}}
              <!--Add Goal Modal -->
              <div class="modal fade" id="addgoal" tabindex="-1" aria-labelledby="addgoal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title">Add / Update Expense</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('goal.create') }}" method="POST" id="expenseForm">
                                @csrf
                                <input type="hidden" name="category_id" id="category_id">

                                <div class="mb-3">
                                    <label class="form-label">Goal Name</label>
                                    <input type="text" class="form-control" name="gname" id="gname" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Target (₹)</label>
                                    <input type="number" step="0.01" class="form-control" name="target" id="target"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Current (₹)</label>
                                    <input type="number" step="0.01" class="form-control" name="current" id="current"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="date" class="form-label">Targeted Date</label>
                                    <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="date" class="form-label">Status</label>
                                    <select name="status" class="form-select" id="status">
                                        <option value="in_progress">In_progress</option>
                                        <option value="achieved">Achieved</option>
                                        <option value="hold">Hold</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Goal</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
             document.querySelectorAll('.card[data-bs-toggle="pill"]').forEach(card => {
               card.addEventListener('click', function() {
                const targetId = this.getAttribute('data-bs-target');
                const targetContent = document.querySelector(targetId);
                if (!targetContent) return; // safety check
                // Remove 'show active' from all tab panes
                document.querySelectorAll('.goals-tab-content .tab-pane').forEach(pane => {
                    pane.classList.remove('show', 'active');
                });
                // Show the selected pane
                targetContent.classList.add('show', 'active');
    });
});
            </script>
@endsection
