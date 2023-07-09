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

//InstalmentPaymentDetail
Route::group(['controller' => InstalmentPaymentDetailController::class, 'prefix' => 'instalment_payment_detail', 'as' => 'instalment_payment_detail.'], function () {
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

//InstalmentPaymentRemain
Route::group(['controller' => InstalmentPaymentRemainController::class, 'prefix' => 'instalment_payment_remain', 'as' => 'instalment_payment_remain.'], function () {
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

//FullPayment
Route::group(['controller' => FullPaymentController::class, 'prefix' => 'full_payment', 'as' => 'full_payment.'], function () {
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
