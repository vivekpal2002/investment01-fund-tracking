@extends('layout.authlayout')
@section('contents')

  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">

        @if ($errors->any())
            <div class="fs-6 text-red-600">
                <ul class="list-disc list-inside text-sm"  style="background-color: var(--bs-red); color:  var(--bs-light-info);  border-radius: 3px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
         @if (session('success'))
        <div class="fs-6" style="background-color: var(--bs-success); color:  var(--bs-light-info);  border-radius: 3px;">
                {{ session('success') }}
            </div>
        @endif
              <div class="card-body">
                <a href="/" class="text-nowrap logo-img text-center d-block py-3 w-100">
                    <img src="{{asset('images/logos/Investment.png')}}" alt="">
                </a>
                <p class="text-center fw-bolder fs-6 ">Create An Account</p>
                <p class="text-center fw-bold fs-4 ">Join Together...</p>
                <form method="POST" action="{{ route('get_register') }}">
                    @csrf
                  <div class="mb-3">
                    <label for="exampleInputtext1" class="form-label">Name</label>
                    <input type="text" class="form-control"  name="name" id="exampleInputtext1" aria-describedby="textHelp">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation"class="form-control" id="exampleInputPassword1">
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign Up</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
