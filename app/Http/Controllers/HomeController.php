<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Payment;
use PHPUnit\Framework\MockObject\Builder\Stub;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalStudent = Student::all()->count();
        // $totalCreditPayment = Payment::where('status', Payment::STATUS_FIRST_CREDIT)
        //     ->get()
        //     ->count();
        $totalFullPayment = Payment::where('status', Payment::STATUS_PAID)
            ->get()
            ->count();
        $totalNotPaidPayment = Payment::where('status', Payment::STATUS_NOT_PAID)
            ->get()
            ->count();

        return view('home', compact('totalStudent', 'totalFullPayment', 'totalNotPaidPayment'));
    }
}
