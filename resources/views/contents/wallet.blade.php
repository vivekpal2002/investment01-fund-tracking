@extends('layout.contentslayout')
@section('title', 'Wallet & Transactions')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Wallet & Transactions</li>
@endsection
@section('maincontents')
    <h1 class="font-weight">Wallet & Transactions</h1>
    <div class="row mt-7 justify-content-sm-between">
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
                        <form action="" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Account Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Account Name</label>
                                <input type="text" class="form-control" name="name" required
                                    placeholder="e.g., SBI Bank, Indian Bank...">
                            </div>
                            <div class="mb-3">
                                <label for="balance" class="form-label">Initial Balance (₹)</label>
                                <input type="number" step="0.01" class="form-control" name="balance" required>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Account Type</label>
                                <select name="type" class="form-select" id="accountType" required>
                                    <option value="Bank">Bank</option>
                                    <option value="Cash">Cash</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit Card">Debit Card</option>
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
                                <label for="created_at" class="form-label">Date Created</label>
                                <input type="date" name="created_at" class="form-control">
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary  waves-effect text-start" data-bs-dismiss="modal">
                            Create Account
                        </button>
                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start"
                            data-bs-dismiss="modal">
                            Close
                        </button>
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
                        <form action="" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Transaction Title</label>
                                <input type="text" class="form-control" name="title" required
                                    placeholder="e.g., Grocery, Uber Ride">
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Transaction Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="Bank">Bank</option>
                                    <option value="Cash">Cash</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit Card">Debit Card</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount (₹)</label>
                                <input type="number" step="0.01" class="form-control" name="amount" required>
                            </div>

                            <div class="mb-3">
                                <label for="wallet_id" class="form-label">Select Wallet</label>
                                <select name="wallet_id" class="form-select" required>
                                    {{-- @foreach ($wallets as $wallet)
                                        <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category (optional)</label>
                                <select name="category_id" class="form-select">
                                    <option value="">-- None --</option>
                                    {{-- @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>

                        </form>

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
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-3">
        {{-- <div class="col-12 col-md-4 mx-3 h-100 rounded-3"> --}}
            <div class="card  bg-primary-subtle">
                <div class="card-body">
                    <p class="mb-1 fs-3">Total Balance</p>
                    <h2 class="mb-2 fs-4">$276,543</h2>

                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0 fs-3">Personal Funds</p>
                        <span class="fw-medium fs-4">$32,500.28</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0 fs-3">Credit Limits</p>
                        <span class="fw-medium fs-4">$2,500.00</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p class="text-muted mb-0 fs-3">Investments</p>
                        <span class="fw-medium fs-4">$241,542.72</span>
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
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                        </div>
                                    </th>
                                    <th scope="col">Products</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault1">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <h6 class="mb-0 fs-4">Curology Face wash</h6>
                                                <p class="mb-0">books</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Thu, Jan 12 2024</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="text-bg-success p-1 rounded-circle"></span>
                                            <p class="mb-0 ms-2">InStock</p>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fs-4">$275</h6>
                                    </td>
                                    <td>
                                        <a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Edit">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex align-items-center justify-content-end py-1">
                            <p class="mb-0 fs-2">Rows per page:</p>
                            <select class="form-select w-auto ms-0 ms-sm-2 me-8 me-sm-4 py-1 pe-7 ps-2 border-0"
                                aria-label="Default select example">
                                <option selected="">5</option>
                                <option value="1">10</option>
                                <option value="2">25</option>
                            </select>
                            <p class="mb-0 fs-2">1–5 of 12</p>
                            <nav aria-label="...">
                                <ul class="pagination justify-content-center mb-0 ms-8 ms-sm-9">
                                    <li class="page-item p-1">
                                        <a class="page-link border-0 rounded-circle text-dark fs-6 round-32 d-flex align-items-center justify-content-center"
                                            href="javascript:void(0)">
                                            <i class="ti ti-chevron-left"></i>
                                        </a>
                                    </li>
                                    <li class="page-item p-1">
                                        <a class="page-link border-0 rounded-circle text-dark fs-6 round-32 d-flex align-items-center justify-content-center"
                                            href="javascript:void(0)">
                                            <i class="ti ti-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <script>
        const cardsData = [{
                type: "VISA",
                balance: "$32,500.28",
                masked: "•••• •••• •••• 4587",
                shortMasked: "•••• 4587",
                holder: "Saiful Islam",
                expires: "09/25"
            },
            {
                type: "MasterCard",
                balance: "$12,340.90",
                masked: "•••• •••• •••• 1234",
                shortMasked: "•••• 1234",
                holder: "Jane Doe",
                expires: "11/26"
            }
        ];

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
                            <div class="fs-5 mb-3 font-monospace text-nowrap d-none d-sm-block">${card.masked}</div>
                            <div class="fs-5 mb-4 font-monospace text-nowrap d-sm-none">${card.shortMasked}</div>
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
                if (selected === 'Credit Card' || selected === 'Debit Card') {
                    expiryDiv.style.display = 'block';
                } else {
                    expiryDiv.style.display = 'none';
                }
            });
        });
    </script>


@endsection
