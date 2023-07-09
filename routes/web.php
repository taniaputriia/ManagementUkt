<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstalmentPaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Student
Route::group(['controller' => StudentController::class, 'prefix' => 'student', 'as' => 'student.'], function () {
    /* Data Table */
    Route::get('/datatable', 'datatable')->name('datatable');

    /* Store & Update */
    Route::post('/store', 'store')->name('store');
    Route::put('/update/{id}', 'update')->name('update');
    Route::delete('/destroy/{id}', 'destroy')->name('destroy');

    /* View */
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::get('/show/{id}', 'show')->name('show');
});

// Payment
Route::group(['controller' => PaymentController::class, 'prefix' => 'payment', 'as' => 'payment.'], function () {
    /* Data Table */
    Route::get('/datatable', 'datatable')->name('datatable');
    Route::get('/datatable_full_payment', 'datatable_full_payment')->name('datatable_full_payment');
    Route::get('/datatable_credit', 'datatable_credit')->name('datatable_credit');

    /* Store & Update */
    Route::post('/store', 'store')->name('store');
    Route::put('/update/{id}', 'update')->name('update');
    Route::delete('/destroy/{id}', 'destroy')->name('destroy');

    /* View */
    Route::get('/', 'index')->name('index');
    Route::get('/full_payment', 'index_full_payment')->name('index_full_payment');
    Route::get('/credit', 'index_credit')->name('index_credit');
    Route::get('/verification_full_payment', 'index_verification_full_payment')->name('index_verification_full_payment');
    Route::get('/verification_credit', 'index_verification_credit')->name('index_verification_credit');
    Route::get('/report_full_payment', 'index_report_full_payment')->name('index_report_full_payment');
    Route::get('/report_credit', 'index_report_credit')->name('index_report_credit');

    Route::get('/create', 'create')->name('create');
    Route::get('/full_payment', 'create_full_payment')->name('create_full_payment');
    Route::get('/credit', 'create_credit')->name('create_credit');
    Route::get('/verification_full_payment', 'create_verification_full_payment')->name('create_verification_full_payment');
    Route::get('/verification_credit', 'create_verification_credit')->name('create_verification_credit');
    Route::get('/report_full_payment', 'create_report_full_payment')->name('create_report_full_payment');
    Route::get('/report_credit', 'create_report_credit')->name('create_report_credit');

    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::get('/full_payment', 'edit_full_payment')->name('edit_full_payment');
    Route::get('/credit', 'edit_credit')->name('edit_credit');
    Route::get('/verification_full_payment', 'edit_verification_full_payment')->name('edit_verification_full_payment');
    Route::get('/verification_credit', 'edit_verification_credit')->name('edit_verification_credit');
    Route::get('/report_full_payment', 'edit_report_full_payment')->name('edit_report_full_payment');
    Route::get('/report_credit', 'edit_report_credit')->name('edit_report_credit');

    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/full_payment', 'show_full_payment')->name('show_full_payment');
    Route::get('/credit', 'show_credit')->name('show_credit');
    Route::get('/verification_full_payment', 'show_verification_full_payment')->name('show_verification_full_payment');
    Route::get('/verification_credit', 'show_verification_credit')->name('show_verification_credit');
    Route::get('/report_full_payment', 'show_report_full_payment')->name('show_report_full_payment');
    Route::get('/report_credit', 'show_report_credit')->name('show_report_credit');
});

// User
Route::group(['controller' => UserController::class, 'prefix' => 'user', 'as' => 'user.'], function () {
    /* Data Table */
    Route::get('/datatable', 'datatable')->name('datatable');

    /* Store & Update */
    Route::post('/store', 'store')->name('store');
    Route::put('/update/{id}', 'update')->name('update');
    Route::delete('/destroy/{id}', 'destroy')->name('destroy');

    /* View */
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::get('/show/{id}', 'show')->name('show');
});
