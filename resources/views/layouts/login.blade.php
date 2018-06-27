<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chat') }}</title>
{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous"> --}}


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   <style type="text/css">
li div.notify{
            max-height: 250px;
        min-height: 150px;
        min-width: 250px;
        overflow-y: auto;
}



    
     .row .card-body 
    {
        max-height: 500px;
        min-height: 500px;
        overflow-y: auto;
        padding: unset;
    }
    div.overly
    {
    position: absolute;
    top: 46px;
    right: 0px;
    left: 0px;
    bottom: 0px;
    background: rgb(255, 255, 255);
    }
    li.list-group-item {
    border: unset;

    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.list-user .card-body{
    padding: unset;
}

.list-user .item-user {
    background: linear-gradient(#0eccea59, #10101017);
}

.list-user .item-user:hover {
    background: #e4ebec7a;
}
.list-user .non-message{

}
</style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                     
                                <a id="navbarDropdownNotify" class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" >
                                  <span v-if="notify">@{{notify.length}} </span>
                                </a>

                                <div class="dropdown-menu notify" aria-labelledby="navbarDropdownNotify">
            <span v-for="notif in notify" :key ="notif.index">
            @{{notif}} </span>
                                </div>
                            </li>
                             <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>                           
                           
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
            <script src="{{url('/js/socket.io.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
