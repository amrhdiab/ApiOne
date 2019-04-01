<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'The Application') }}</title>

    <!-- Toastr -->
    <link href="{{asset('css/toastr.min.css')}}" rel="stylesheet"/>

    <!-- Styles -->
    <link href="{{ asset('app/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('app/fonts/font-awesome/css/all.css')}}">

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    @yield('styles')
</head>
<body>
<div id="app">
    @include('admin.inc.navbar')
    <div class="container">
        <div class="row">
            <div class="col-lg-2">

                @include('admin.inc.sidebar')

            </div>
            <div class="col-lg-10">
                @include('admin.inc.flash')
                @yield('content')
            </div>
        </div>
    </div>

</div>

<!-- jQuery Library -->
<script src="{{asset('app/jquery/dist/jquery.min.js')}}"></script>

<!-- Scripts -->
<script src="{{ asset('app/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
@yield('vendors')
@yield('scripts')
<script>
    @if(session('success'))
    toastr.success('{{session('success')}}', 'Success', {timeOut: 3000});
    @endif

    @if(session('error'))
    toastr.error('{{session('error')}}', 'Error', {timeOut: 3000});
    @endif

    @if(session('info'))
    toastr.info('{{session('info')}}', 'Info', {timeOut: 3000});
    @endif
</script>
</body>
</html>
