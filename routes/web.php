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
    /* --------------------------------------------- */
    /* Payment Not Paid */
    /* --------------------------------------------- */

    /* Data Table */
    Route::get('/datatable', 'datatable')->name('datatable');
    Route::get('/datatable_student', 'datatable_student')->name('datatable_student');

    /* Store & Update */
    Route::post('/store', 'store')->name('store');
    Route::put('/update/{id}', 'update')->name('update');
    Route::delete('/destroy/{id}', 'destroy')->name('destroy');

    /* View */
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::get('/show/{id}', 'show')->name('show');


    /* --------------------------------------------- */
    /* Full Payment */
    /* --------------------------------------------- */

    /* Data Table */
    Route::get('/datatable_full_payment', 'datatable_full_payment')->name('datatable_full_payment');
    Route::get('/datatable_full_payment_student', 'datatable_full_payment_student')->name('datatable_full_payment_student');
    Route::get('/datatable_report_full_payment', 'datatable_report_full_payment')->name('datatable_report_full_payment');

    /* Store & Update */
    Route::post('/store/full_payment', 'store_full_payment')->name('store_full_payment');
    Route::put('/update/full_payment{id}', 'update_full_payment')->name('update_full_payment');
    Route::delete('/destroy/full_payment{id}', 'destroy_full_payment')->name('destroy_full_payment');
    Route::put('/verification_full_payment', 'verification_full_payment')->name('verification_full_payment');

    /* View */
    Route::get('/full_payment', 'index_full_payment')->name('index_full_payment');
    Route::get('/create/full_payment', 'create_full_payment')->name('create_full_payment');
    Route::get('/edit/full_payment/{id}', 'edit_full_payment')->name('edit_full_payment');
    Route::get('/show/full_payment/{id}', 'show_full_payment')->name('show_full_payment');
    Route::get('/create/verification_full_payment/{id}', 'create_verification_full_payment')->name('create_verification_full_payment');
    Route::get('/report_full_payment', 'report_full_payment')->name('report_full_payment');

    /* --------------------------------------------- */
    /* Credit Payment */
    /* --------------------------------------------- */

    /* Data Table */
    Route::get('/datatable_credit', 'datatable_credit')->name('datatable_credit');
    Route::get('/datatable_credit_student', 'datatable_credit_student')->name('datatable_credit_student');
    Route::get('/datatable_report_credit', 'datatable_report_credit')->name('datatable_report_credit');

    /* Store & Update */
    Route::post('/store/credit', 'store/credit')->name('store/credit');
    Route::put('/update/credit{id}', 'update/credit')->name('update/credit');
    Route::delete('/destroy/credit{id}', 'destroy/credit')->name('destroy/credit');
    Route::put('/verification_credit', 'verification_credit')->name('verification_credit');

    /* View */
    Route::get('/credit', 'index_credit')->name('index_credit');
    Route::get('/create/credit', 'create_credit')->name('create_credit');
    Route::get('/edit/credit/{id}', 'edit_credit')->name('edit_credit');
    Route::get('/show/credit/{id}', 'show_credit')->name('show_credit');
    Route::get('/create/verification_credit{id}', 'create_verification_credit')->name('create_verification_credit');
    Route::get('/report_credit', 'report_credit')->name('report_credit');

    /* --------------------------------------------- */
    /* History Payment */
    /* --------------------------------------------- */

    /* Data Table */
    Route::get('/datatable_history', 'datatable_history')->name('datatable_history');
    Route::get('/datatable_history_student', 'datatable_history_student')->name('datatable_history_student');

    /* View */
    Route::get('/history_payment', 'index_history_payment')->name('index_history_payment');
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
