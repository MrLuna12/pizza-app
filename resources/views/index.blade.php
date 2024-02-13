<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>StrongMind's Pizzeria</title>



        {{--Bootstrap CSS--}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        {{-- CSS --}}
        <link rel="stylesheet" href="css/index.css">

    </head>
    <body>
        <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
            <div class="container">
                <a href="/">
                    <img src="/img/company%20Logo.svg" alt="StrongMind Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/pizzas">Chef</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/toppings">Owner</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main id="home" class="min-vh-100 d-flex align-items-center text-center">
            <div class="container landing-text">
                <div class="row">
                    <div class="col-12">
                        <h1 class="">Order Now</h1>
                        <h3>Unlimited Toppings</h3>
                        <a class="btn btn-primary" href="/pizzas" role="button">Get Started</a>
                    </div>
                </div>
            </div>
        </main>

        {{--Bootstrap JS--}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>

</html>
