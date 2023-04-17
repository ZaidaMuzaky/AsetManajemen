<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Aset Manajemen</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/icon.png') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    {!! Html::script('js/plugin/webfont/webfont.min.js') !!}
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": [
                    "Flaticon",
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['../../css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    {!! Html::style('css/fonts.min.css') !!}
    <script src="https://kit.fontawesome.com/7847058db2.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/atlantis.min.css') }}"> -->
    {!! Html::style('css/bootstrap.min.css') !!}
    {!! Html::style('css/atlantis.min.css') !!}
    {!! Html::style('js/plugin/datatables/datatables.min.css') !!}
    {!! Html::style('js/plugin/datatables/FixedColumns/css/fixedColumns.bootstrap4.min.css') !!}
    {!! Html::style('js/plugin/datatables/Buttons/css/buttons.bootstrap4.min.css') !!}
    {!! Html::style('js/plugin/datatables/Responsive/css/responsive.bootstrap4.min.css') !!}
    {!! Html::style('js/plugin/select2/select2.min.css') !!}
    {!! Html::style('js/plugin/select2/select2-bootstrap4.min.css') !!}
    {!! Html::style('js/plugin/datepicker/css/bootstrap-datepicker.min.css') !!}
    @stack('plugin-style')
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            @include('layout.komponen.header')

            <!-- Navbar Header -->

            @include('layout.komponen.navbar')
        </div>

        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    @include('layout.komponen.sidebar')
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">
                @include('sweetalert::alert')
                @yield('content')
            </div>
            @include('layout.komponen.footer')
        </div>
        @include('layout.komponen.javascript')
        @stack('plugin-scripts')
</body>

</html>
