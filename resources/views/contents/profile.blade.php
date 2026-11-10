@extends('layout.contentslayout')
@section('title', 'My Profile')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">My Profile</li>
@endsection

@section('maincontents')
<div class="container py-5">
    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm p-3 text-center">
                <div class="profile-pic mb-3">
                    @if($user->gender == 'female')
                        <img src="{{ asset('images/profile/women_logo.jpg') }}" class="rounded-circle" width="150" height="150">
                    @else
                        <img src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" class="rounded-circle" width="150" height="150">
                    @endif
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-2"><i class="bi bi-envelope"></i> {{ $user->email }}</p>
                
            </div>
        </div>

        <!-- Profile Form -->
        <div class="col-md-9">
            <div class="card border-0 shadow-sm p-4">
                <h4 class="mb-4 fw-semibold text-primary">Profile Settings</h4>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <!-- Basic Info -->
                        <div class="col-12">
                            <h6 class="text-uppercase text-secondary mb-2">Basic Information</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ $user->phone ?? '' }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" value="{{ $user->dob ?? '' }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select</option>
                                <option value="male" {{ $user->gender=='male'?'selected':'' }}>Male</option>
                                <option value="female" {{ $user->gender=='female'?'selected':'' }}>Female</option>
                                <option value="other" {{ $user->gender=='other'?'selected':'' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Enter your address">{{ $user->address ?? '' }}</textarea>
                        </div>

                        <!-- Financial Info -->
                        <div class="col-12 mt-4">
                            <h6 class="text-uppercase text-secondary mb-2">Financial Information</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Monthly Income (₹)</label>
                            <input type="number" name="income" value="{{ $user->income ?? '' }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Savings Goal (₹)</label>
                            <input type="number" name="goal" value="{{ $user->goal ?? '' }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Investment Strategy</label>
                            <select name="strategy" class="form-select">
                                <option value="Balanced" {{ $user->strategy=='Balanced'?'selected':'' }}>Balanced</option>
                                <option value="Aggressive" {{ $user->strategy=='Aggressive'?'selected':'' }}>Aggressive</option>
                                <option value="Conservative" {{ $user->strategy=='Conservative'?'selected':'' }}>Conservative</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Risk Level</label>
                            <select name="risk" class="form-select">
                                <option value="Low" {{ $user->risk=='Low'?'selected':'' }}>Low</option>
                                <option value="Medium" {{ $user->risk=='Medium'?'selected':'' }}>Medium</option>
                                <option value="High" {{ $user->risk=='High'?'selected':'' }}>High</option>
                            </select>
                        </div>

                        <!-- Account Settings -->
                        <div class="col-12 mt-4">
                            <h6 class="text-uppercase text-secondary mb-2">Account Settings</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Change Password</label>
                            <input type="password" name="password" class="form-control" placeholder="New password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3">
                                <i class="bi bi-save"></i> Save Profile
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
