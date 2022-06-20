<?php

use App\Http\Controllers\FormController;
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
Route::get('/form/{id}', App\Http\Livewire\Form\Show::class)->name('form.show');
Route::get('login', App\Http\Livewire\Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', App\Http\Livewire\Home::class)->name('home');
    Route::get('/signed-forms', App\Http\Livewire\SignedForms::class)->name('signed-forms');
    Route::get('/approved-forms', App\Http\Livewire\ApprovedForms::class)->name('approved-forms');
    Route::get('/all-forms', App\Http\Livewire\AllForms::class)->name('all-forms');

    Route::get('/create-form', App\Http\Livewire\Form\Create::class)->name('form.create');
    Route::get('/replicate-form/{id}', App\Http\Livewire\Form\Replicate::class)->name('form.replicate');
    Route::get('/edit-form/{id}', App\Http\Livewire\Form\Edit::class)->name('form.edit');

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/report/expiring', App\Http\Livewire\Report\Expiring::class)->name('report.expiring');

        Route::post('/archive-form/{form}', [FormController::class, 'archive'])->name('form.archive');
        Route::get('/archived-forms', App\Http\Livewire\ArchivedForms::class)->name('form.archived');
    });
});
