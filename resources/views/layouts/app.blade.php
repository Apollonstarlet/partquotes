<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            Part Quoter
        </title>

        <meta name="robots" content="noindex">

        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />

        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

        <!-- CSS Files -->
        {{--                    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css" rel="stylesheet"/>--}}
        {{--        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />--}}
        <link href="{{ mix('/css/theme.css') }}" rel="stylesheet" />
        <script
            src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
            crossorigin="anonymous"></script>
        {{--                    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>--}}
        <script src="/assets/js/plugins/datatables.js"></script>
        <script src="{{ mix('/js/app.js') }}"></script>

    </head>

    <body class="g-sidenav-show bg-gray-200">

        @auth
            @yield('auth')
        @endauth
        @guest
            @yield('guest')
        @endguest


        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/fullcalendar.min.js"></script>
        <script src="/assets/js/plugins/chartjs.min.js"></script>
        <script src="/assets/js/plugins/choices.min.js"></script>
        @stack('dashboard')
        <script>
            var win = navigator.platform.indexOf("Win") > -1;
            if (win && document.querySelector("#sidenav-scrollbar")) {
                var options = {
                    damping: "0.5"
                };
                Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
            }
        </script>

        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
    </body>

</html>
