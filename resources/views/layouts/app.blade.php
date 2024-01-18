<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('style.css') }}" rel="stylesheet">
    <!-- Change the path to your actual CSS file -->

    <!-- Scripts -->
    <script src="{{ asset('script.js') }}" defer></script>
    <!-- Change the path to your actual JS file -->
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    MyStore
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if(session('user'))
                        <li class="nav-item"><a class="nav nav-link" href="{{ route('logout') }}">Logout</a></li>
                        <li class="nav-item"><a class="nav nav-link" href="{{ route('orders.showUserOrders', ['userId' => session('user')['id']]) }}">Orders</a></li>
                        <li class="nav-item"><a class="nav nav-link" href="{{ route('admins.show')}}">Admins</a></li>
                        <li class="nav-item"><a class="nav nav-link" href="{{ route('users.messages', ['userId' => session('user')['id']])}}">Messages</a></li>
                        @elseif(session('admin'))
                        <li class="nav-item"><a class="nav nav-link" href="{{ route('logout') }}">Logout</a></li>
                        <li class="nav-item"><a class="nav nav-link" href="{{ route('admin.products') }}">Products</a></li>
                        <li class="nav-item"><a class="nav nav-link" href="{{ route('admin.orders') }}">Orders</a></li>
                        <li class="nav-item"><a class="nav nav-link" href="{{ route('admin.users') }}">Users</a></li>
                        <li class="nav-item"><a class="nav nav-link" href="{{ route('admins.messages', ['adminId' => session('admin')['id']])}}">Messages</a></li>
                        @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.register.form') }}">Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.login.form') }}">Login</a></li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
