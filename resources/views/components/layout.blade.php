<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pizza</title>

        {{--Bootstrap CSS--}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        {{--Bootstrap Icons--}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

        {{--Livewire Styles--}}
        @livewireStyles

        {{-- CSS --}}
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
            <div class="container">
                <a href="/pizzas">
                    <img src="/img/company%20Logo.svg" alt="StrongMind Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('pizzas*') ? 'underline-link' : '' }}" href="/pizzas">Chef</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('toppings*') ? 'underline-link' : '' }}" href="/toppings">Owner</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main style="background-color: rgb(248, 249, 250)">
            <div class="container pt-2">
                {{$slot}}
            </div>
        </main>







        {{--Bootstrap JS--}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        {{--Livewire Scripts--}}
        @livewireScripts

        {{--Sweet Alert Script--}}
        @include('sweetalert::alert')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        {{--Script Stack--}}
        {{--The scripts used in other components will be pushed here--}}
        @stack('scripts')
    </body>
</html>
