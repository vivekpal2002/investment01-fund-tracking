@extends('layout.authlayout')

@section('contents')
<div class="max-w-xl mx-auto mt-20 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Verify Your Email</h1>
    <p class="mb-4">We’ve sent a verification link to your email address.</p>

    @if (session('message'))
        <div class="text-green-600 mb-4">{{ session('message') }}</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
            Resend Verification Email
        </button>
    </form>
</div>
@endsection
