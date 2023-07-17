<?php

namespace App\Http\Controllers;

use App\Models\HistoryPayment;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Laraindo\RupiahFormat;
use Laravel\Ui\Presets\React;

class PaymentController extends Controller
{
    /* Payment Not Paid */
    public function index()
    {
        // Confirm Delete Alert
        $title = 'Hapus Data!';
        $text = "Apakah yakin ingin menghapus data?";
        confirmDelete($title, $text);

        return view('payments.not-paid.index');
    }

    public function datatable()
    {
        $model = Payment::where('status', Payment::STATUS_NOT_PAID)
            ->orWhere('status', Payment::STATUS_NOT_CONFIRMED)
            ->orWhere('status', Payment::STATUS_NOT_CONFIRMED_CREDIT)
            ->orderBy('id', 'desc');
        return DataTables::of($model)
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->translatedFormat('d F Y - H:i');
                return $formatedDate;
            })
            ->editColumn('tuition_fee', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['tuition_fee']);
                return $formatCurrency;
            })
            ->addColumn('nim', function ($data) {
                if (!empty($data->student->nim)) {
                    return $data->student->nim;
                }
            })
            ->addColumn('name', function ($data) {
                if (!empty($data->student->name)) {
                    return $data->student->name;
                }
            })
            ->addColumn('action', function ($data) {
                $url_show = route('payment.show', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_show' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Detail</a>";

                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }

    public function datatable_student()
    {
        $user_id = Auth::user()->id;
        $student = Student::where('user_id', $user_id)->first();
        $student_id = $student->id;

        $payment = Payment::where('student_id', $student_id)->latest()->first();

        if (!empty($payment)) {
            $model = Payment::where('student_id', $student_id)
                ->where('status', $payment->status)
                ->where('status', '!=', Payment::STATUS_PAID)
                ->where('status', '!=', Payment::STATUS_CREDIT)
                ->where('status', '!=', Payment::STATUS_FIRST_CREDIT)
                ->where('status', '!=', Payment::STATUS_SECOND_CREDIT)
                ->where('status', '!=', Payment::STATUS_THIRD_CREDIT)
                ->where('status', '!=', Payment::STATUS_NOT_CONFIRMED_CREDIT)
                ->where('status', '!=', Payment::STATUS_NOT_CONFIRMED_FIRST_CREDIT)
                ->where('status', '!=', Payment::STATUS_NOT_CONFIRMED_SECOND_CREDIT)
                ->where('status', '!=', Payment::STATUS_NOT_CONFIRMED_THIRD_CREDIT)
                ->orderBy('id', 'desc');
        } else {
            $model = Payment::where('status', Payment::STATUS_NOT_PAID)
                ->where('student_id', $student_id)
                ->orderBy('id', 'desc');
        }

        return DataTables::of($model)
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->translatedFormat('d F Y - H:i');
                return $formatedDate;
            })
            ->editColumn('tuition_fee', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['tuition_fee']);
                return $formatCurrency;
            })
            ->addColumn('nim', function ($data) {
                if (!empty($data->student->nim)) {
                    return $data->student->nim;
                }
            })
            ->addColumn('name', function ($data) {
                if (!empty($data->student->name)) {
                    return $data->student->name;
                }
            })
            ->toJson();
    }

    public function input_payment()
    {
        $user_id = Auth::user()->id;
        $data = Student::where('user_id', $user_id)->first();
        return view('payments.not-paid.input_payment', compact('data'));
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);

        return view('payments.not-paid.edit', compact('data'));
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);

        return view('payments.not-paid.show', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'va_number' => 'required',
                'file' => 'mimes:jpg,jpeg,png|max:1028',
            ]);

            // Create Data
            $user_id = Crypt::decrypt($request->user_id);
            $student = Student::where('user_id', $user_id)->first();
            $student_id = $student->id;

            $payment = Payment::where('student_id', $student_id)->latest()->first();

            $input = $request->all();
            $input['student_id'] = $student_id;
            $input['tuition_fee'] = $student->tuition_fee;


            // Image
            if ($file = $request->file('file')) {
                // Store New File
                $destinationPath = 'assets/bukti_bayar/';
                $fileName = "Bukti_Bayar" . "_" . date('YmdHis') . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $input['file'] = $fileName;
            }

            if (!empty($payment)) {
                if ($payment->semester == $input['semester']) {
                    DB::rollBack();

                    // Alert & Redirect
                    Alert::toast('Data pada semester ini sudah ada!', 'error');
                    return redirect()->back()->withInput();
                } else {
                    if (!empty($input['first_payment'])) {
                        $first_payment = str_replace(',', '', $input['first_payment']);
                        $second_payment = str_replace(',', '', $input['second_payment']);
                        $third_payment = str_replace(',', '', $input['third_payment']);
                        $totalTuitionFee = $first_payment   + $second_payment  + $third_payment;
                        if ($totalTuitionFee == $payment['tuition_fee']) {
                            $input['first_payment'] = $first_payment;
                            $input['second_payment'] = $second_payment;
                            $input['third_payment'] = $third_payment;
                            $input['status'] = Payment::STATUS_NOT_CONFIRMED_CREDIT;
                            $payment = Payment::create($input);

                            // Create History
                            HistoryPayment::create([
                                'payment_id' => $payment->id,
                                'tuition_fee' => $payment->tuition_fee,
                                'total_payment' => $payment->total_payment,
                                'remain_payment' => $payment->remain_payment,
                                'first_payment' => $payment->first_payment,
                                'second_payment' => $payment->second_payment,
                                'third_payment' => $payment->third_payment,
                                'description' => $payment->description,
                                'file' => $payment->file,
                            ]);
                        } else {
                            DB::rollBack();

                            // Alert & Redirect
                            Alert::toast('Total Cicilan harus sama dengan jumlah UKT!', 'error');
                            return redirect()->back()->withInput();
                        }
                    } else {
                        $input['status'] = Payment::STATUS_NOT_CONFIRMED;
                        $payment = Payment::create($input);

                        // Create History
                        HistoryPayment::create([
                            'payment_id' => $payment->id,
                            'tuition_fee' => $payment->tuition_fee,
                            'total_payment' => $payment->total_payment,
                            'remain_payment' => $payment->remain_payment,
                            'first_payment' => $payment->first_payment,
                            'second_payment' => $payment->second_payment,
                            'third_payment' => $payment->third_payment,
                            'description' => $payment->description,
                            'file' => $payment->file,
                        ]);
                    }
                }
            } else {
                if (!empty($input['first_payment'])) {
                    $first_payment = str_replace(',', '', $input['first_payment']);
                    $second_payment = str_replace(',', '', $input['second_payment']);
                    $third_payment = str_replace(',', '', $input['third_payment']);
                    $totalTuitionFee = $first_payment   + $second_payment  + $third_payment;
                    if ($totalTuitionFee == $student['tuition_fee']) {
                        $input['first_payment'] = $first_payment;
                        $input['second_payment'] = $second_payment;
                        $input['third_payment'] = $third_payment;
                        $input['status'] = Payment::STATUS_NOT_CONFIRMED_CREDIT;
                        $payment = Payment::create($input);

                        // Create History
                        HistoryPayment::create([
                            'payment_id' => $payment->id,
                            'tuition_fee' => $payment->tuition_fee,
                            'total_payment' => $payment->total_payment,
                            'remain_payment' => $payment->remain_payment,
                            'first_payment' => $payment->first_payment,
                            'second_payment' => $payment->second_payment,
                            'third_payment' => $payment->third_payment,
                            'description' => $payment->description,
                            'file' => $payment->file,
                        ]);
                    } else {
                        DB::rollBack();

                        // Alert & Redirect
                        Alert::toast('Total Cicilan harus sama dengan jumlah UKT!', 'error');
                        return redirect()->back()->withInput();
                    }
                } else {
                    $input['status'] = Payment::STATUS_NOT_CONFIRMED;
                    $payment = Payment::create($input);

                    // Create History
                    HistoryPayment::create([
                        'payment_id' => $payment->id,
                        'tuition_fee' => $payment->tuition_fee,
                        'total_payment' => $payment->total_payment,
                        'remain_payment' => $payment->remain_payment,
                        'first_payment' => $payment->first_payment,
                        'second_payment' => $payment->second_payment,
                        'third_payment' => $payment->third_payment,
                        'description' => $payment->description,
                        'file' => $payment->file,
                    ]);
                }
            }

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Diperbarui', 'success');
            return redirect()->route('payment.index');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Tidak Tersimpan', 'error');
            return redirect()->back()->withInput()->with('error', 'Data Tidak Berhasil Diperbarui' . $e->getMessage());
        }
    }

    /* --------------------------------------------------------------------------------------------- */

    /* Full Payment */
    public function index_full_payment()
    {
        // Confirm Delete Alert
        $title = 'Hapus Data!';
        $text = "Apakah yakin ingin menghapus data?";
        confirmDelete($title, $text);

        return view('payments.full-payment.index');
    }

    public function index_verification_full_payment()
    {
        return view('payments.full-payment.verification');
    }

    public function datatable_full_payment()
    {
        $model = Payment::where('status', Payment::STATUS_PAID)
            ->orderBy('id', 'desc');;
        return DataTables::of($model)
            ->editColumn('tuition_fee', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['tuition_fee']);
                return $formatCurrency;
            })
            ->addColumn('nim', function ($data) {
                if (!empty($data->student->nim)) {
                    return $data->student->nim;
                }
            })
            ->addColumn('name', function ($data) {
                if (!empty($data->student->name)) {
                    return $data->student->name;
                }
            })
            ->addColumn('action', function ($data) {
                $url_show = route('payment.show_full_payment', Crypt::encrypt($data->id));
                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_show' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Lihat</a>";

                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }

    public function datatable_full_payment_student()
    {
        $user_id = Auth::user()->id;
        $student = Student::where('user_id', $user_id)->first();
        $student_id = $student->id;

        $model = Payment::where('status', Payment::STATUS_PAID)
            ->where('student_id', $student_id)
            ->orderBy('id', 'desc');

        return DataTables::of($model)
            ->editColumn('tuition_fee', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['tuition_fee']);
                return $formatCurrency;
            })
            ->addColumn('nim', function ($data) {
                if (!empty($data->student->nim)) {
                    return $data->student->nim;
                }
            })
            ->addColumn('name', function ($data) {
                if (!empty($data->student->name)) {
                    return $data->student->name;
                }
            })
            ->addColumn('action', function ($data) {
                $url_show = route('payment.show_full_payment', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_show' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Detail</a>";

                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }

    public function datatable_verification_full_payment()
    {
        $model = Payment::where('status', Payment::STATUS_NOT_CONFIRMED)
            ->orderBy('id', 'desc');

        return DataTables::of($model)
            ->editColumn('tuition_fee', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['tuition_fee']);
                return $formatCurrency;
            })
            ->addColumn('nim', function ($data) {
                if (!empty($data->student->nim)) {
                    return $data->student->nim;
                }
            })
            ->addColumn('name', function ($data) {
                if (!empty($data->student->name)) {
                    return $data->student->name;
                }
            })
            ->addColumn('action', function ($data) {
                $url_verification = route('payment.create_verification_full_payment', Crypt::encrypt($data->id));
                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_verification' class = 'btn btn-outline-success btn-sm text-nowrap'><i class='fas fa-check mr-2'></i> Konfirmasi</a>";
                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }

    public function datatable_report_full_payment()
    {
        $model = Payment::where('status', Payment::STATUS_PAID);
        return DataTables::of($model)
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->translatedFormat('d F Y - H:i');
                return $formatedDate;
            })
            ->editColumn('tuition_fee', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['tuition_fee']);
                return $formatCurrency;
            })
            ->addColumn('action', function ($data) {
                $url_show = route('payment.full-payment.show', Crypt::encrypt($data->id));
                $url_edit = route('payment.full-payment.edit', Crypt::encrypt($data->id));
                $url_delete = route('payment.full-payment.destroy', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_show' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Lihat</a>";
                $btn .= "<a href='$url_edit' class = 'btn btn-outline-info btn-sm text-nowrap'><i class='fas fa-edit mr-2'></i> Edit</a>";
                $btn .= "<a href='$url_delete' class = 'btn btn-outline-danger btn-sm text-nowrap' data-confirm-delete='true'><i class='fas fa-trash mr-2'></i> Hapus</a>";
                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }

    public function show_full_payment($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);

        return view('payments.full-payment.show', compact('data'));
    }

    public function create_verification_full_payment($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);
        return view('payments.full-payment.create_verification', compact('data'));
    }

    public function report_full_payment()
    {
        // Confirm Delete Alert
        $title = 'Hapus Data!';
        $text = "Apakah yakin ingin menghapus data?";
        confirmDelete($title, $text);

        $user_id = Auth::user()->id;
        $payment = Payment::where('user_id', $user_id)->first();

        return view('payments.full-payment.index', compact('payment'));
    }

    public function verification_full_payment($id)
    {
        try {
            DB::beginTransaction();

            $id = Crypt::decrypt($id);
            $payment = Payment::find($id);

            $payment->update([
                'remain_payment' => $payment->tuition_fee - $payment->total_payment,
                'status' => Payment::STATUS_PAID
            ]);

            // Create History
            HistoryPayment::create([
                'payment_id' => $payment->id,
                'tuition_fee' => $payment->tuition_fee,
                'total_payment' => $payment->total_payment,
                'remain_payment' => $payment->remain_payment,
                'first_payment' => $payment->first_payment,
                'second_payment' => $payment->second_payment,
                'third_payment' => $payment->third_payment,
                'description' => "Pembayaran Lunas. Dikonfirmasi oleh " . Auth::user()->name,
                'file' => $payment->file,
            ]);

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Disimpan', 'success');
            return redirect()->route('payment.index_verification_full_payment');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Gagal Disimpan', 'error');
            return redirect()->back()->withInput()->with('error', 'Data Tidak Berhasil Diperbarui' . $e->getMessage());
        }
    }

    /* --------------------------------------------------------------------------------------------- */

    /* Credit Payment */

    public function index_credit()
    {
        // Confirm Delete Alert
        $title = 'Hapus Data!';
        $text = "Apakah yakin ingin menghapus data?";
        confirmDelete($title, $text);

        return view('payments.credit.index');
    }

    public function index_verification_credit()
    {
        return view('payments.credit.verification');
    }

    public function datatable_credit()
    {
        $model = Payment::where('status', Payment::STATUS_CREDIT)
            ->orWhere('status', Payment::STATUS_NOT_CONFIRMED_FIRST_CREDIT)
            ->orWhere('status', Payment::STATUS_FIRST_CREDIT)
            ->orWhere('status', Payment::STATUS_NOT_CONFIRMED_SECOND_CREDIT)
            ->orWhere('status', Payment::STATUS_SECOND_CREDIT)
            ->orWhere('status', Payment::STATUS_NOT_CONFIRMED_THIRD_CREDIT)
            ->orderBy('id', 'desc');
        return DataTables::of($model)
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->translatedFormat('d F Y - H:i');
                return $formatedDate;
            })
            ->editColumn('tuition_fee', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['tuition_fee']);
                return $formatCurrency;
            })
            ->editColumn('remain_payment', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['remain_payment']);
                return $formatCurrency;
            })
            ->addColumn('nim', function ($data) {
                if (!empty($data->student->nim)) {
                    return $data->student->nim;
                }
            })
            ->addColumn('name', function ($data) {
                if (!empty($data->student->name)) {
                    return $data->student->name;
                }
            })
            ->addColumn('action', function ($data) {
                $url_show = route('payment.show_credit', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_show' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Lihat</a>";

                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }

    public function datatable_credit_student()
    {
        $user_id = Auth::user()->id;
        $student = Student::where('user_id', $user_id)->first();
        $student_id = $student->id;

        $payment = Payment::where('student_id', $student_id)->latest()->first();

        if (!empty($payment)) {
            $model = Payment::where('status', $payment->status)
                ->where('status', '!=', Payment::STATUS_PAID)
                ->where('status', '!=', Payment::STATUS_NOT_CONFIRMED)
                ->where('status', '!=', Payment::STATUS_NOT_PAID)
                ->where('student_id', $student_id)
                ->orderBy('id', 'desc');
        } else {
            $model = Payment::where('status', Payment::STATUS_CREDIT)
                ->where('student_id', $student_id)
                ->orderBy('id', 'desc');
        }

        return DataTables::of($model)
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->translatedFormat('d F Y - H:i');
                return $formatedDate;
            })
            ->editColumn('tuition_fee', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['tuition_fee']);
                return $formatCurrency;
            })
            ->editColumn('remain_payment', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['remain_payment']);
                return $formatCurrency;
            })
            ->addColumn('nim', function ($data) {
                if (!empty($data->student->nim)) {
                    return $data->student->nim;
                }
            })
            ->addColumn('name', function ($data) {
                if (!empty($data->student->name)) {
                    return $data->student->name;
                }
            })
            ->addColumn('action', function ($data) {
                $url_create = route('payment.create', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                if ($data->status == Payment::STATUS_CREDIT) {
                    $btn .= "<a href='$url_create' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Pembayaran</a>";
                } elseif ($data->status == Payment::STATUS_FIRST_CREDIT) {
                    $btn .= "<a href='$url_create' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Pembayaran</a>";
                } elseif ($data->status == Payment::STATUS_SECOND_CREDIT) {
                    $btn .= "<a href='$url_create' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Pembayaran</a>";
                }

                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }

    public function datatable_verification_credit()
    {
        $model = Payment::where('status', Payment::STATUS_NOT_CONFIRMED_CREDIT)
            ->orWhere('status', Payment::STATUS_NOT_CONFIRMED_FIRST_CREDIT)
            ->orWhere('status', Payment::STATUS_NOT_CONFIRMED_SECOND_CREDIT)
            ->orWhere('status', Payment::STATUS_NOT_CONFIRMED_THIRD_CREDIT)
            ->orderBy('id', 'desc');

        return DataTables::of($model)
            ->editColumn('tuition_fee', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['tuition_fee']);
                return $formatCurrency;
            })
            ->addColumn('nim', function ($data) {
                if (!empty($data->student->nim)) {
                    return $data->student->nim;
                }
            })
            ->addColumn('name', function ($data) {
                if (!empty($data->student->name)) {
                    return $data->student->name;
                }
            })
            ->addColumn('action', function ($data) {
                $url_verification = route('payment.create_verification_credit', Crypt::encrypt($data->id));
                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_verification' class = 'btn btn-outline-success btn-sm text-nowrap'><i class='fas fa-check mr-2'></i> Konfirmasi</a>";
                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }

    public function datatable_report_credit()
    {
        $model = Payment::where('status', Payment::STATUS_FIRST_CREDIT);
        return DataTables::of($model)
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->translatedFormat('d F Y - H:i');
                return $formatedDate;
            })
            ->editColumn('tuition_fee', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['tuition_fee']);
                return $formatCurrency;
            })
            ->toJson();
    }

    public function show_credit($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);

        return view('payments.credit.show', compact('data'));
    }

    public function create_verification_credit($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);
        return view('payments.credit.create_verification', compact('data'));
    }

    public function verification_credit(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $id = Crypt::decrypt($id);
            $payment = Payment::find($id);

            if ($request->type == 1) {

                $payment->update([
                    'status' => Payment::STATUS_CREDIT
                ]);

                // Create History
                HistoryPayment::create([
                    'payment_id' => $payment->id,
                    'tuition_fee' => $payment->tuition_fee,
                    'total_payment' => $payment->total_payment,
                    'remain_payment' => $payment->remain_payment,
                    'first_payment' => $payment->first_payment,
                    'second_payment' => $payment->second_payment,
                    'third_payment' => $payment->third_payment,
                    'description' => "Pembayaran Cicilan. Dikonfirmasi oleh " . Auth::user()->name,
                    'file' => $payment->file,
                ]);
            } elseif ($request->type == 2) {
                $first_payment = $payment->first_payment;
                $total_payment = $first_payment;
                $tuition_fee = $payment->tuition_fee;
                $payment->update([
                    'total_payment' => $total_payment,
                    'remain_payment' => $tuition_fee - $total_payment,
                    'status' => Payment::STATUS_FIRST_CREDIT
                ]);

                // Create History
                HistoryPayment::create([
                    'payment_id' => $payment->id,
                    'tuition_fee' => $payment->tuition_fee,
                    'total_payment' => $payment->total_payment,
                    'remain_payment' => $payment->remain_payment,
                    'third_payment' => $payment->third_payment,
                    'description' => "Pembayaran Cicilan Pertama. Dikonfirmasi oleh " . Auth::user()->name,
                    'file' => $payment->file,
                ]);
            } elseif ($request->type == 3) {
                $first_payment = $payment->first_payment;
                $second_payment = $payment->second_payment;
                $total_payment = $first_payment + $second_payment;
                $tuition_fee = $payment->tuition_fee;
                $payment->update([
                    'total_payment' => $total_payment,
                    'remain_payment' => $tuition_fee - $total_payment,
                    'status' => Payment::STATUS_SECOND_CREDIT
                ]);

                // Create History
                HistoryPayment::create([
                    'payment_id' => $payment->id,
                    'tuition_fee' => $payment->tuition_fee,
                    'total_payment' => $payment->total_payment,
                    'remain_payment' => $payment->remain_payment,
                    'first_payment' => $payment->first_payment,
                    'second_payment' => $payment->second_payment,
                    'description' => "Pembayaran Cicilan Kedua. Dikonfirmasi oleh " . Auth::user()->name,
                    'file' => $payment->file,
                ]);
            } elseif ($request->type == 4) {
                $first_payment = $payment->first_payment;
                $second_payment = $payment->second_payment;
                $third_payment = $payment->third_payment;
                $total_payment = $first_payment + $second_payment + $third_payment;
                $tuition_fee = $payment->tuition_fee;

                $payment->update([
                    'total_payment' => $total_payment,
                    'remain_payment' => $tuition_fee - $total_payment,
                    'status' => Payment::STATUS_THIRD_CREDIT
                ]);

                // Create History
                HistoryPayment::create([
                    'payment_id' => $payment->id,
                    'tuition_fee' => $payment->tuition_fee,
                    'total_payment' => $payment->total_payment,
                    'remain_payment' => $payment->remain_payment,
                    'first_payment' => $payment->first_payment,
                    'second_payment' => $payment->second_payment,
                    'third_payment' => $payment->third_payment,
                    'description' => "Pembayaran Cicilan Ketiga. Dikonfirmasi oleh " . Auth::user()->name,
                    'file' => $payment->file,
                ]);
            }


            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Disimpan', 'success');
            return redirect()->route('payment.index_verification_credit');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Gagal Disimpan', 'error');
            return redirect()->back()->withInput()->with('error', 'Data Tidak Berhasil Diperbarui' . $e->getMessage());
        }
    }

    public function create($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);

        return view('payments.credit.create', compact('data'));
    }

    public function update_credit(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $id = Crypt::decrypt($id);
            $payment = Payment::find($id);

            $input = $request->all();

            // Image
            if ($file = $request->file('file')) {
                // Remove Old File
                if (!empty($payment['file'])) {
                    $file_exist = 'assets/bukti_bayar/' . $payment['file'];

                    if (file_exists($file_exist)) {
                        unlink($file_exist);
                    }
                }

                // Store New File
                $destinationPath = 'assets/bukti_bayar/';
                $fileName = "Bukti_Bayar" . "_" . date('YmdHis') . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $input['file'] = $fileName;
            } else {
                unset($input['file']);
            }

            if ($request->type == 1) {
                $total_payment = $payment->first_payment;
                $tuition_fee = $payment->tuition_fee;
                $remain_payment = $tuition_fee - $total_payment;
                $input['remain_payment'] = $remain_payment;
                $input['status'] = Payment::STATUS_NOT_CONFIRMED_FIRST_CREDIT;
            } elseif ($request->type == 2) {
                $total_payment = $payment->first_payment + $payment->second_payment;
                $tuition_fee = $payment->tuition_fee;
                $remain_payment = $tuition_fee - $total_payment;
                $input['remain_payment'] = $remain_payment;
                $input['status'] = Payment::STATUS_NOT_CONFIRMED_SECOND_CREDIT;
            } elseif ($request->type == 3) {
                $total_payment = $payment->first_payment + $payment->second_payment + $payment->third_payment;
                $tuition_fee = $payment->tuition_fee;
                $remain_payment = $tuition_fee - $total_payment;
                $input['remain_payment'] = $remain_payment;
                $input['status'] = Payment::STATUS_NOT_CONFIRMED_THIRD_CREDIT;
            }

            $payment->update($input);

            // Create History
            HistoryPayment::create([
                'payment_id' => $payment->id,
                'tuition_fee' => $payment->tuition_fee,
                'total_payment' => $payment->total_payment,
                'remain_payment' => $payment->remain_payment,
                'first_payment' => $payment->first_payment,
                'second_payment' => $payment->second_payment,
                'third_payment' => $payment->third_payment,
                'description' => $payment->status,
                'file' => $payment->file,
            ]);

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Disimpan', 'success');
            return redirect()->route('payment.index_credit');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Gagal Disimpan', 'error');
            return redirect()->back()->withInput()->with('error', 'Data Tidak Berhasil Diperbarui' . $e->getMessage());
        }
    }

    public function report_credit()
    {
        // Confirm Delete Alert
        $title = 'Hapus Data!';
        $text = "Apakah yakin ingin menghapus data?";
        confirmDelete($title, $text);

        $user_id = Auth::user()->id;
        $payment = payment::where('user_id', $user_id)->first();


        return view('payments.credit.index', compact('payment'));
    }

    /* --------------------------------------------------------------------------------------------- */

    /* History */
    public function datatable_history()
    {
        $model = Payment::where('status', Payment::STATUS_NOT_PAID);
        return DataTables::of($model)
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->translatedFormat('d F Y - H:i');
                return $formatedDate;
            })
            ->editColumn('tuition_fee', function ($data) {
                $formatCurrency = RupiahFormat::currency($data['tuition_fee']);
                return $formatCurrency;
            })
            ->addColumn('action', function ($data) {
                $url_show = route('payment.history.show', Crypt::encrypt($data->id));
                // $url_edit = route('payment.history.edit', Crypt::encrypt($data->id));
                // $url_delete = route('payment.history.destroy', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_show' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Lihat</a>";
                // $btn .= "<a href='$url_edit' class = 'btn btn-outline-info btn-sm text-nowrap'><i class='fas fa-edit mr-2'></i> Edit</a>";
                // $btn .= "<a href='$url_delete' class = 'btn btn-outline-danger btn-sm text-nowrap' data-confirm-delete='true'><i class='fas fa-trash mr-2'></i> Hapus</a>";
                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }

    public function history()
    {
        $data = HistoryPayment::query()
            ->orderBy('id', 'desc')
            ->simplePaginate(5);

        return view('payments.history', compact('data'));
    }
}
