@extends('layout.contentslayout')
@section('maincontents')
    @include('barmenu.menu')
    <div class="body-wrapper-inner">
        <div class="container-fluid">
        @section('breadcrumb')
            <li class="breadcrumb-item active" aria-current="page">Wallet & Transactions</li>
        @endsection
        <h1 class="font-weight">Wallet & Transactions</h1>
    </div>
</div>
@endsection
