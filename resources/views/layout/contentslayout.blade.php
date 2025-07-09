 <!doctype html>
 <html lang="en">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>@yield('title', 'Investment Tracker')</title>
     <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/favicon.png') }}" />
     <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
     <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
     <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js'></script>
     <script>
        var isAuthenticated = @json(auth()->check());
      </script>

 </head>

 <body>
     @include('barmenu.menu')
     <div class="body-wrapper-inner">
         <!-- Breadcrumb section -->
         <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    @yield('breadcrumb')
                </ol>
            </nav>
             @yield('maincontents')
         </div>
     </div>
 </body>
 <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
 <script src="{{ asset('libs/bootstrap/dist/js') }}/bootstrap.bundle.min.js')}}"></script>
 <script src="{{ asset('js/sidebarmenu.js') }}"></script>
 <script src="{{ asset('js/app.min.js') }}"></script>
 <script src="{{ asset('libs/apexcharts/dist/apexcharts.min.js') }}"></script>
 <script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>
 <script src="{{ asset('js/dashboard.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


 <!-- solar icons -->
 <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

 </html>
