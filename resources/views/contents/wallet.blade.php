@extends('layout.contentslayout')
@section('title', 'Wallet & Transactions')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Wallet & Transactions</li>
@endsection
@section('maincontents')
    <h1 class="font-weight">Wallet & Transactions</h1>
    <div class="row mt-7 justify-content-sm-between">

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="d-flex flex-column gap-3">
                <button type="button" class="btn rounded-pill btn-outline-primary fs-5" data-bs-toggle="modal"
                    data-bs-target="#addaccount">
                    <i class="ti ti-circle-plus me-2"></i> Add New Account
                </button>
                <button type="button" class="btn rounded-pill btn-outline-primary fs-5" data-bs-toggle="modal"
                    data-bs-target="#addtransaction">
                    <i class="ti ti-circle-plus me-2"></i> Add Transaction
                </button>
            </div>
        </div>
        <!--Add account Modal -->
        <div class="modal fade" id="addaccount" tabindex="-1" aria-labelledby="addaccount" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Add Account
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action={{ route('wallet.add_wallet') }} method="POST">
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
                                <input type="number" step="0.01" class="form-control" name="balance" required>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Account Type</label>
                                <select name="type" class="form-select" id="accountType" required>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3" id="expiryDiv" style="display: none;">
                                <label for="expiry_date" class="form-label">Expiry Date</label>
                                <input type="month" class="form-control" name="expiry_date" placeholder="MM/YYYY">
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
                        <button type="submit" class="btn btn-primary  waves-effect text-start" data-bs-dismiss="modal">
                            Create Account
                        </button>
                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start"
                            data-bs-dismiss="modal">
                            Close
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Add transaction Modal -->
        <div class="modal fade" id="addtransaction" tabindex="-1" aria-labelledby="addtransaction" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Add Transaction
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action={{ route('wallet.transaction') }} method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Transaction Title</label>
                                <input type="text" class="form-control" name="title" required
                                    placeholder="e.g., Grocery, Uber Ride">
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Transaction Method</label>
                                <select name="type" class="form-select" required>
                                   @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Payment Type</label>
                                <select name="payment_type" class="form-select" required>
                                    @foreach (config('app.payment_type') as $key => $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount (₹)</label>
                                <input type="number" step="0.01" class="form-control" name="amount" required>
                            </div>

                            <div class="mb-3">
                                <label for="wallet_id" class="form-label">Select Wallet</label>
                                <select name="wallet_id" class="form-select" required>
                                    @foreach ($wallets as $wallet)
                                        <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category (optional)</label>
                                <select name="category_id" class="form-select"  size="5" style="max-height: 150px; overflow-y: auto;">

                                    @foreach ($Trans_categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    @foreach (config('app.transaction_statuses') as $key => $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success  waves-effect text-start" data-bs-dismiss="modal">
                            Add Transaction
                        </button>
                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-end"
                            data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                     </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-3">
        {{-- <div class="col-12 col-md-4 mx-3 h-100 rounded-3"> --}}
            <div class="card  bg-primary-subtle">
                <div class="card-body">
                    <p class="mb-1 fs-3">Total Balance</p>
                    <h2 class="mb-2 fs-4">₹{{$total_balance}}</h2>

                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0 fs-3">Personal Funds</p>
                        <span class="fw-medium fs-4">₹{{$personal_funds ??0.00}}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0 fs-3">Credit Limits</p>
                        <span class="fw-medium fs-4">₹{{ $credit_cards ?? 0.00}}</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p class="text-muted mb-0 fs-3">Investments</p>
                        <span class="fw-medium fs-4">₹{{ $investments ?? 0.00}}</span>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-12 col-md-4 mx-3 rounded-3"> --}}
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-3">
            <div id="cardCarousel" class="carousel slide carousel-dark" data-bs-ride="carousel">
                <div class="carousel-inner" id="cardCarouselInner">
                    <!-- Cards will be injected here via JS -->
                </div>
                <a class="carousel-control-prev" href="#cardCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#cardCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>

        </div>

    </div>
    <div>
        <div class="product-list">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
                        <form class="position-relative">
                            <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                                placeholder="Search Product">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                        <a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Filter list">
                            <i class="ti ti-filter"></i>
                        </a>
                    </div>
                    <div class="table-responsive border rounded">
                        <table class="table align-middle text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col"> Category</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$transactions->isEmpty())
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->title }}</td>
                                            <td>{{ $transaction->category->name ?? '—' }}</td>
                                            <td>{{ $transaction->date }}</td>
                                            <td>
                                                <span class="text-bg-success p-1 m-2 rounded-circle"></span>
                                                <span class="badge {{ $transaction->status == 1 ? 'text-bg-warning' : ($transaction->status == 0 ? 'text-bg-success' : ($transaction->status == 2 ? 'text-bg-danger' : 'text-bg-secondary')) }} p-1 m-2 rounded-circle"></span>
                                                {{ config('app.transaction_statuses')[$transaction->status] ?? $transaction->status }}
                                            </td>
                                            <td>{{ $transaction->amount }}</td>
                                            <td>{{ $transaction->notes ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">No Transactions</td>
                                    </tr>
                                @endif
                            </tbody>                            
                        </table>
                        {{ $transactions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>



    <script>
const data_cardsData = @json($wallets);

let cardsData = [];

if (data_cardsData && data_cardsData.length > 0) {
    cardsData = data_cardsData.map(wallet => ({
        type: wallet.category?.name ?? 'N/A',
        balance: "₹" + wallet.balance,
        bank_name: wallet.bank_name ?? '',
        holder: wallet.name,
        expires: wallet.expiry_date ?? '—'
    }));
} else {
    cardsData = [
        {
            type: 'N/A',
            balance: "₹0.00",
            bank_name: 'No Accounts',
            holder: 'No Accounts',
            expires: '—'
        }
    ];
}

        const carouselInner = document.getElementById('cardCarouselInner');

        cardsData.forEach((card, index) => {
            const isActive = index === 0 ? 'active' : '';

            const cardHTML = `
            <div class="carousel-item ${isActive}">
                <div class="card text-white bg-primary mx-auto" style="width: 90%; max-width: 400px;">
                    <div class="card-body d-flex flex-column justify-content-between h-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="small text-white-100 mb-1">Current Balance</p>
                                <h3 class="fw-bold text-white">${card.balance}</h3>
                            </div>
                            <div class="fw-bold fs-5">${card.type}</div>
                        </div>
                        <div class="mt-2">
                            <div class="fs-5 mb-3 font-monospace text-nowrap d-none d-sm-block">${card.bank_name}</div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="small text-white-50 mb-0">CARD HOLDER</p>
                                    <p class="fw-medium mb-0">${card.holder}</p>
                                </div>
                                <div>
                                    <p class="small text-white-50 mb-0">EXPIRES</p>
                                    <p class="fw-medium mb-0">${card.expires}</p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>`;

            carouselInner.innerHTML += cardHTML;
        });
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('accountType');
            const expiryDiv = document.getElementById('expiryDiv');

            typeSelect.addEventListener('change', function() {
                const selected = this.value;
                if (selected == 4 || selected == 5) {
                    expiryDiv.style.display = 'block';
                } else {
                    expiryDiv.style.display = 'none';
                }
            });
        });
    </script>


@endsection
