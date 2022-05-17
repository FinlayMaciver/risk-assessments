@if(Session::has('success_message'))
    @if(Session::get('success_message'))
        <div class="alert alert-success" role="alert">
            <div class="container">
            {{ Session::get('success_message') }}
            </div>
        </div>
    @endif
@endif
@if(Session::has('error'))
    @if(Session::get('error'))
        <div class="alert alert-danger" role="alert">
            <div class="container">
            {{ Session::get('error') }}
            </div>
        </div>
    @endif
@endif
@if(Session::has('error_message'))
    <div class="alert alert-danger" role="alert">
        <div class="container">
            @foreach(Session::get('error_message') as $error)
                <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                <span class="sr-only">Error:</span>
                {{ $error }}<br>
            @endforeach
        </div>
    </div>
@endif
