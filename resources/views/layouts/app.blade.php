<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="University of Glasgow School of Engineering Risk Assessments">
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
            <div class="d-print-none d-none d-md-flex flex-column flex-shrink-0 p-3 text-white bg-primary vh-100 sticky-top" style="width: 280px;">
                <a href="/" class="align-items-center mb-3 mb-md-0 me-md-auto text-center text-white text-decoration-none">
                    <img src="{{asset('images/uogbanner.jpeg')}}" class="w-100 mb-3" alt="..."><br>
                    <span>
                        <h5>
                            School of Engineering<br>
                            Risk Assessments
                        </h5>
                    </span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{ route('form.create') }}" class="nav-link @if(Route::currentRouteName() == 'form.create') active @endif"
                            aria-current="page">
                            + Create Form
                        </a>
                        <hr>
                        <a href="{{ route('home') }}/?authUserOnly=1" class="nav-link
                            @if(Route::currentRouteName() == 'home') active @endif"
                            aria-current="page">
                            My Forms
                        </a>
                        <a href="{{ route('approved-forms') }}/?statusFilter=approved&inReviewers=1" class="nav-link
                            @if(Route::currentRouteName() == 'approved-forms') active @endif"
                            aria-current="page">
                            Approved Forms
                        </a>
                        <a href="{{ route('signed-forms') }}/?signedUserOnly=1" class="nav-link
                            @if(Route::currentRouteName() == 'signed-forms') active @endif"
                            aria-current="page">
                            Signed Forms
                        </a>
                        <a href="{{ route('all-forms') }}" class="nav-link @if(Route::currentRouteName() == 'all-forms') active @endif"
                            aria-current="page">
                            All Forms
                        </a>
                        @admin
                            <hr />
                            <a href="{{ route('report.expiring') }}/?expiresInDays=30" class="nav-link" aria-current="page">
                                Expiring Forms
                            </a>
                            <a href="{{ route('form.archived') }}" class="nav-link" aria-current="page">
                                Archived Forms
                            </a>
                        @endadmin
                    </li>
                </ul>
                <hr>
                @livewire('logout')
            </div>
        @endauth
        <div class="container-fluid">
            @include('partials.notifications')
            {{ $slot }}
            @guest
                @if (Route::currentRouteName() != 'login')
                    @include('partials.login_toast')
                @endif
            @endguest
        </div>
    </div>

    <!-- Scripts -->
    @livewireScripts
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
