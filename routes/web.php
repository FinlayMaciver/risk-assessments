<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', App\Http\Livewire\Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', App\Http\Livewire\Home::class)->name('home');

    Route::get('/form/create', App\Http\Livewire\Form\Create::class)->name('form.create');
    Route::get('/form/{id}', App\Http\Livewire\Form\Show::class)->name('form.show');
    Route::get('/form/{formId}/edit', App\Http\Livewire\Form\Edit::class)->name('form.edit');
});
