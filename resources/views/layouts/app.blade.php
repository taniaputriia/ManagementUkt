</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Keuangan Admin Dashboard</title>
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="{{ asset('easy-number-separator.js') }}"></script>

    {{-- Data Table --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('portal/assets/plugins/fontawesome/js/all.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('mazer-admin/assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer-admin/assets/css/main/app-dark.css') }}">
    <link rel="shortcut icon" href="{{ asset('mazer-admin/assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('mazer-admin/assets/images/logo/favicon.png') }}" type="image/png">

    <link rel="stylesheet" href="{{ asset('mazer-admin/assets/css/shared/iconly.css') }}">

    <!-- FontAwesome JS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    @yield('css_after')
</head>

<body>
    <div id="app">
        {{-- Sidebar --}}
        @include('layouts.sidebar')
        {{-- End Sidebar --}}

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                @yield('content-header')

            </div>

            <div class="page-content">
                {{-- Content --}}
                @yield('content')
                {{-- End Content --}}
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; Politeknik Negeri Sriwijaya</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"></span> by <a href="https://saugi.me">IT polsri</a>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('mazer-admin/assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('mazer-admin/assets/js/app.js') }}"></script>

    <!-- Need: Apexcharts -->
    <script src="{{ asset('mazer-admin/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('mazer-admin/assets/js/pages/dashboard.js') }}"></script>

    @yield('js_after')

    @include('sweetalert::alert')
</body>

</html>
