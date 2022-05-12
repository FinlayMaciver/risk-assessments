<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="University of Glasgow School of Engineering COSHH">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{!! asset('images/favicon.ico') !!}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @livewireStyles
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app" class="d-flex">
        @auth
            <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-primary vh-100 sticky-top" style="width: 280px;">
                <a href="/" class="align-items-center mb-3 mb-md-0 me-md-auto text-center text-white text-decoration-none">
                    <img src="{{asset('images/uogbanner.jpeg')}}" class="w-100 mb-3" alt="..."><br>
                    <span>
                        <h5>
                            School of Engineering<br>
                            COSHH Risk Assessment
                        </h5>
                    </span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link active" aria-current="page">
                            My Forms
                        </a>
                        <a href="{{ route('approved-forms') }}" class="nav-link" aria-current="page">
                            Approved Forms
                        </a>
                        <a href="{{ route('signed-forms') }}" class="nav-link" aria-current="page">
                            Signed Forms
                        </a>
                        <a href="{{ route('all-forms') }}" class="nav-link" aria-current="page">
                            All Forms
                        </a>
                        @coshhadmin
                            <hr />
                            <a href="{{ route('report.expiring') }}" class="nav-link" aria-current="page">
                                Expiring Forms
                            </a>
                        @endcoshhadmin
                    </li>
                </ul>
                <hr>
                @livewire('logout')
            </div>
        @endauth
        <div class="container-fluid">
            @include('partials.notifications')
            {{ $slot }}
        </div>
    </div>

    <!-- Scripts -->
    @livewireScripts
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
