<?php

use App\Livewire\Pizza\CreatePizza;
use App\Livewire\Pizza\EditPizza;
use App\Livewire\Pizza\Pizzas;
use App\Livewire\Topping\EditTopping;
use App\Livewire\Topping\Toppings;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/pizzas', Pizzas::class);

Route::get('/pizzas/create', CreatePizza::class);

Route::get('/pizzas/edit/{id}', EditPizza::class);

Route::get('/toppings', Toppings::class);

Route::get('/toppings/edit/{id}', EditTopping::class);



