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
    Route::get('/signed-forms', App\Http\Livewire\SignedForms::class)->name('signed-forms');
    Route::get('/approved-forms', App\Http\Livewire\ApprovedForms::class)->name('approved-forms');
    Route::get('/all-forms', App\Http\Livewire\AllForms::class)->name('all-forms');

    Route::get('/form/create', App\Http\Livewire\Form\Create::class)->name('form.create');
    Route::get('/form/replicate/{id}', App\Http\Livewire\Form\Replicate::class)->name('form.replicate');
    Route::get('/form/{id}', App\Http\Livewire\Form\Show::class)->name('form.show');
    Route::get('/form/{id}/edit', App\Http\Livewire\Form\Edit::class)->name('form.edit');

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/report/expiring', App\Http\Livewire\Report\Expiring::class)->name('report.expiring');
    });
});
