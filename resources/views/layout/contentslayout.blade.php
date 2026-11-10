 <!doctype html>
 <html lang="en">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>@yield('title', 'Investment Tracker')</title>
     <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/favicon.png') }}" />
     <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
     <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
     <style>
         #global-loader {
             position: fixed;
             top: 0;
             left: 0;
             width: 100%;
             height: 100%;
             background-color: rgba(255, 255, 255, 0.8);
             display: flex;
             justify-content: center;
             align-items: center;
             z-index: 9999;
             opacity: 0;
             visibility: hidden;
             transition: opacity 0.3s ease, visibility 0.3s ease;
         }
         #global-loader.show {
             opacity: 1;
             visibility: visible;
         }
         [data-bs-theme="dark"] #global-loader {
             background-color: rgba(0, 0, 0, 0.8);
         }
         [data-bs-theme="dark"] {
             --bs-body-bg: #1a1a1a;
             --bs-body-color: #ffffff;
             background-color: #1a1a1a !important;
             color: #ffffff !important;
         }
         [data-bs-theme="dark"] .card {
             background-color: #2d2d2d;
             color: #ffffff;
         }
         [data-bs-theme="dark"] .navbar {
             background-color: #343a40;
             color: #ffffff;
         }
         [data-bs-theme="dark"] .sidebar-nav {
             background-color: #2d2d2d;
             color: #ffffff;
         }
         [data-bs-theme="dark"] .app-topstrip {
             background-color: #1a1a1a !important;
             color: #ffffff;
         }
         [data-bs-theme="dark"] .left-sidebar {
             background-color: #2d2d2d;
             color: #ffffff;
         }
         [data-bs-theme="dark"] i,
         [data-bs-theme="dark"] .ti {
             color: #ffffff !important;
         }
         [data-bs-theme="dark"] .breadcrumb {
             background-color: #2d2d2d;
             color: #ffffff;
         }
         [data-bs-theme="dark"] .table {
             color: #ffffff;
         }
         [data-bs-theme="dark"] .btn-primary {
             background-color: #007bff;
             border-color: #007bff;
         }
         [data-bs-theme="dark"] h1,
         [data-bs-theme="dark"] h2,
         [data-bs-theme="dark"] h3,
         [data-bs-theme="dark"] h4,
         [data-bs-theme="dark"] h5,
         [data-bs-theme="dark"] h6,
         [data-bs-theme="dark"] p,
         [data-bs-theme="dark"] span {
             color: #ffffff !important;
         }
     </style>
     <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js'></script>
     <script>
        var isAuthenticated = @json(auth()->id());
      </script>

 </head>

 <body data-bs-theme="{{ auth()->check() ? (auth()->user()->preference->theme ?? 'light') : 'light' }}">
    @include('barmenu.menu')
    <div class="body-wrapper-inner">
        <!-- Breadcrumb -->
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

    <!-- Global Loader (keep outside body-wrapper-inner so it overlays everything) -->
    <div id="global-loader">
        <div id="load_container">
            <div class="circle"></div>
            <div class="loader1"></div>
            <div class="loader2"></div>
            <div class="loader3"></div>
            <div class="loader4"></div>
        </div>
    </div>
</body>
<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>

<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<script src="{{ asset('js/app.min.js') }}"></script>

<script src="{{ asset('libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>

<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="{{ asset('js/content.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

<script>
    // Global Loader Management
    const loader = document.getElementById("global-loader");

    function showLoader() {
        loader.classList.add("show");
    }

    function hideLoader() {
        loader.classList.remove("show");
    }

    // Show loader on DOM content loaded
    document.addEventListener("DOMContentLoaded", function() {
        showLoader();
    });

    // Hide loader once page fully loaded with minimum delay
    window.addEventListener("load", function() {
        setTimeout(() => {
            hideLoader();
        }, 1000); // minimum 1 second for smooth experience
    });

    // Show loader again when leaving page
    window.addEventListener("beforeunload", function () {
        showLoader();
    });

    @auth
    document.getElementById('theme-toggle').addEventListener('click', function() {
        const body = document.body;
        const currentTheme = body.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        fetch('/preferences/toggle-theme', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            body.setAttribute('data-bs-theme', data.theme);
            const icon = this.querySelector('i');
            icon.className = data.theme === 'dark' ? 'ti ti-sun' : 'ti ti-moon';
        })
        .catch(error => console.error('Error:', error));
    });
    @endauth
</script>



  </html>
