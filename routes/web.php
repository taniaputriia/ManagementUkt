<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentController;
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

    /* View */
    Route::get('/', 'index')->name('index');
    Route::get('/input_payment', 'input_payment')->name('input_payment');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/report', 'report')->name('report');

    /* --------------------------------------------- */
    /* Full Payment */
    /* --------------------------------------------- */

    /* Data Table */
    Route::get('/datatable_full_payment', 'datatable_full_payment')->name('datatable_full_payment');
    Route::get('/datatable_full_payment_student', 'datatable_full_payment_student')->name('datatable_full_payment_student');
    Route::get('/datatable_verification_full_payment', 'datatable_verification_full_payment')->name('datatable_verification_full_payment');
    Route::get('/datatable_report_full_payment', 'datatable_report_full_payment')->name('datatable_report_full_payment');

    /* Store & Update */
    Route::put('/verification_full_payment/{id}', 'verification_full_payment')->name('verification_full_payment');

    /* View */
    Route::get('/full_payment', 'index_full_payment')->name('index_full_payment');
    Route::get('/verification_full_payment', 'index_verification_full_payment')->name('index_verification_full_payment');
    Route::get('/create/verification_full_payment/{id}', 'create_verification_full_payment')->name('create_verification_full_payment');
    Route::get('/show/full_payment/{id}', 'show_full_payment')->name('show_full_payment');
    Route::get('/report_full_payment', 'report_full_payment')->name('report_full_payment');

    /* --------------------------------------------- */
    /* Credit Payment */
    /* --------------------------------------------- */

    /* Data Table */
    Route::get('/datatable_credit', 'datatable_credit')->name('datatable_credit');
    Route::get('/datatable_credit_student', 'datatable_credit_student')->name('datatable_credit_student');
    Route::get('/datatable_verification_credit', 'datatable_verification_credit')->name('datatable_verification_credit');


    /* Store & Update */
    Route::put('/verification_credit/{id}', 'verification_credit')->name('verification_credit');
    Route::put('/update_credit/{id}', 'update_credit')->name('update_credit');

    /* View */
    Route::get('/credit', 'index_credit')->name('index_credit');
    Route::get('/verification_credit', 'index_verification_credit')->name('index_verification_credit');
    Route::get('/create/{id}', 'create')->name('create');
    Route::get('/create/verification_credit/{id}', 'create_verification_credit')->name('create_verification_credit');
    Route::get('/show/credit/{id}', 'show_credit')->name('show_credit');
    // Route::get('/report_credit', 'report_credit')->name('report_credit');

    /* --------------------------------------------- */
    /* Report Payment */
    /* --------------------------------------------- */

    /* Data Table */
    Route::get('/datatable_report', 'datatable_report')->name('datatable_report');
    Route::get('/datatable_report_full_payment', 'datatable_report_full_payment')->name('datatable_report_full_payment');
    Route::get('/datatable_report_credit', 'datatable_report_credit')->name('datatable_report_credit');

    /* View */
    Route::get('/report', 'report')->name('report');
    Route::get('/report_full_payment', 'report_full_payment')->name('report_full_payment');
    Route::get('/report_credit', 'report_credit')->name('report_credit');


    /* --------------------------------------------- */
    /* History Payment */
    /* --------------------------------------------- */

    /* Data Table */
    Route::get('/datatable_history', 'datatable_history')->name('datatable_history');

    /* View */
    Route::get('/history', 'history')->name('history');
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
