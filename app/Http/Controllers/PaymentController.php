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
        $model = Payment::where('status', '!=', Payment::STATUS_NOT_CONFIRMED)
            ->orderBy('id', 'desc')
            ->where('status', '!=', Payment::STATUS_PAID);

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

        $model = Payment::where('status', Payment::STATUS_NOT_PAID)
            ->where('student_id', $student_id)
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
                $url_create = route('payment.add_payment', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_create' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-wallet mr-2'></i> Pembayaran</a>";

                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }

    public function add_payment($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);

        return view('payments.not-paid.add', compact('data'));
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

    public function update_payment($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'va_number' => 'required',
                'file' => 'mimes:jpg,jpeg,png|max:1028',
            ]);

            // Update Data
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

            if (!empty($input['first_payment'])) {

                $totalTuitionFee =  $input['first_payment'] +  $input['second_payment'] + $input['third_payment'];
                if ($totalTuitionFee == $payment['tuition_fee']) {
                    $input['status'] == Payment::STATUS_NOT_CONFIRMED;
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
                $input['status'] == Payment::STATUS_NOT_CONFIRMED;
                $payment->update($input);
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

    public function update($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'nim' => 'required',
                'name' => 'required',
                'va_number' => 'va_number',
                'tuition_fee' => 'tuition_fee',
                'total_payment' => 'total_payment',
                'remain_payment' => 'remain_payment',
                'first_payment' => 'first_payment',
                'second_payment' => 'second_payment',
                'third_payment' => 'third_payment',
                'remain_payment' => 'remain_payment',
                'verified' => 'verified',
                'status' => 'status',
                'description' => 'description',

            ]);

            // Update Data
            $id = Crypt::decrypt($id);
            $payment = Payment::find($id);

            $input = $request->all();

            // Image
            if ($file = $request->file('photo')) {
                // Remove Old File
                if (!empty($user['photo'])) {
                    $file_exist = 'assets/images/' . $user['photo'];

                    if (file_exists($file_exist)) {
                        unlink($file_exist);
                    }
                }

                // Store New File
                $destinationPath = 'assets/mahasiswa/';
                $fileName = "Mahasiswa" . "_" . date('YmdHis') . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $input['photo'] = $fileName;
            } else {
                unset($input['photo']);
            }

            $input['tuition_fee'] = str_replace(',', '', $input['tuition_fee']);
            $payment->update($input);

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

        $user_id = Auth::user()->id;
        $student = Student::where('user_id', $user_id)->first();
        return view('payments.full-payment.index', compact('student'));
    }

    public function datatable_full_payment()
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
                $url_show = route('payment.full_payment.show', Crypt::encrypt($data->id));
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

    public function add_payment_full_payment()
    {
        return view('payments.full-payment.add');
    }

    public function edit_full_payment($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);

        return view('payments.full-payment.edit', compact('data'));
    }

    public function show_full_payment($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);

        return view('payments.full-payment.show', compact('data'));
    }

    /* Baru ditambahkan */
    public function datatable_verification_full_payment()
    {
        $model = Payment::where('status', Payment::STATUS_NOT_CONFIRMED);

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
            $url_verification = route('payment.create_verification_full_payment', Crypt::encrypt($data->id));
            $btn = "<div class='btn-group'>";
            $btn.= "<a href='$url_verification' class = 'btn btn-outline-success btn-sm text-nowrap'><i class='fas fa-check mr-2'></i> Diterima</a>";
            $btn .= "</div>";
                return $btn;
            })
        ->toJson();
    }

    public function create_verification_full_payment($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);
        $payment = Payment::all();
        return view('payments.full-payment.index', compact('data', 'payments'));
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

    public function store_full_payment(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'nim' => 'nim ',
                'name' => 'name',
                'va_number' => 'va_number',
                'tuition_fee' => 'tuition_fee',
                'total_payment' => 'total_payment',
                'verified' => 'verified',
                'status' => 'status',
                'description' => 'description',
            ]);

            $input = $request->all();

            // Create User
            $user = User::create($input);
            $user->assignRole([2]);

            // File
            if ($file = $request->file('photo')) {
                $destinationPath = 'assets/mahasiswa/';
                $extension = $file->getClientOriginalExtension();
                $fileName = "Mahasiswa" . "_"  . date('dmYHis') . '.' . $extension;
                $file->move($destinationPath, $fileName);
                $input['photo'] = $fileName;
            }

            // Create Payment
            $input['user_id'] = $user->id;
            $input['tuition_fee'] = str_replace(',', '', $input['tuition_fee']);
            Payment::create($input);


            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Disimpan', 'success');
            return redirect()->route('payment.index');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Tidak Tersimpan', 'error');
            return redirect()->back()->withInput()->with('error', 'Data Tidak Berhasil Disimpan' . $e->getMessage());
        }
    }

    public function update_full_payment($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'nim' => 'required',
                'name' => 'required',
                'va_number' => 'va_number',
                'tuition_fee' => 'tuition_fee',
                'total_payment' => 'total_payment',
                'verified' => 'verified',
                'status' => 'status',
                'description' => 'description',

            ]);

            // Update Data
            $id = Crypt::decrypt($id);
            $payment = Payment::find($id);

            $input = $request->all();

            // Image
            if ($file = $request->file('photo')) {
                // Remove Old File
                if (!empty($user['photo'])) {
                    $file_exist = 'assets/images/' . $user['photo'];

                    if (file_exists($file_exist)) {
                        unlink($file_exist);
                    }
                }

                // Store New File
                $destinationPath = 'assets/mahasiswa/';
                $fileName = "Mahasiswa" . "_" . date('YmdHis') . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $input['photo'] = $fileName;
            } else {
                unset($input['photo']);
            }

            $input['tuition_fee'] = str_replace(',', '', $input['tuition_fee']);
            $payment->update($input);

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

    public function destroy_full_payment($id)
    {
        try {
            DB::beginTransaction();

            $id = Crypt::decrypt($id);
            $payment = Payment::find($id);

            // Delete Data
            $payment->delete();

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Dihapus', 'success');
            return redirect()->route('payment.index');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Tidak Berhasil Dihapus', 'error');
            return redirect()->back()->with('error', 'Data Tidak Berhasil Dihapus' . $e->getMessage());
        }
    }

    public function verification_full_payment(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $id = Crypt::decrypt($id);
            $payment = Payment::find($id);

            $user_id = $payment->user_id;
            $user = User::find($user_id);

            $input = $request->all();

            // Save file
            if ($file = $request->file('file')) {
                $destinationPath = 'assets/bukti_bayar/';
                $fileName = "BuktiBayaran" . "_" . date('YmdHis') . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $input['file'] = $fileName;
            }

            $payment->update([
                'file' => $input['file'],
                'status' => Payment::STATUS_PAID
            ]);

            DB::table('model_has_roles')
                ->where('model_id', $user_id)
                ->delete();

            $user->assignRole([3]);

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Disimpan', 'success');
            return redirect()->route('payment.index_verification');
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

        $user_id = Auth::user()->id;
        $payment = Payment::where('user_id', $user_id)->first();


        return view('payments.credit.index', compact('payment'));
    }

    public function datatable_credit()
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
            ->addColumn('action', function ($data) {
                $url_show = route('payment.credit.show', Crypt::encrypt($data->id));
                $url_edit = route('payment.credit.edit', Crypt::encrypt($data->id));
                $url_delete = route('payment.credit.destroy', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_show' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Lihat</a>";
                $btn .= "<a href='$url_edit' class = 'btn btn-outline-info btn-sm text-nowrap'><i class='fas fa-edit mr-2'></i> Edit</a>";
                $btn .= "<a href='$url_delete' class = 'btn btn-outline-danger btn-sm text-nowrap' data-confirm-delete='true'><i class='fas fa-trash mr-2'></i> Hapus</a>";
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

        $model = Payment::where('status', Payment::STATUS_FIRST_CREDIT)
            ->where('student_id', $student_id)
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
            ->addColumn('action', function ($data) {
                $url_show = route('payment.credit.show', Crypt::encrypt($data->id));
                $url_edit = route('payment.credit.edit', Crypt::encrypt($data->id));
                $url_delete = route('payment.credit.destroy', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_show' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Lihat</a>";
                $btn .= "<a href='$url_edit' class = 'btn btn-outline-info btn-sm text-nowrap'><i class='fas fa-edit mr-2'></i> Edit</a>";
                $btn .= "<a href='$url_delete' class = 'btn btn-outline-danger btn-sm text-nowrap' data-confirm-delete='true'><i class='fas fa-trash mr-2'></i> Hapus</a>";
                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }


    public function add_payment_credit()
    {
        return view('payments.create.add');
    }

    public function edit_credit($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);

        return view('payments.credit.edit', compact('data'));
    }

    public function show_credit($id)
    {
        $id = Crypt::decrypt($id);
        $data = Payment::find($id);

        return view('payments.credit.show', compact('data'));
    }

    public function create_verification_credit($id)
    {
        return view('payments.credit.add');
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

    public function verification_credit()
    {
        // Confirm Delete Alert
        $title = 'Hapus Data!';
        $text = "Apakah yakin ingin menghapus data?";
        confirmDelete($title, $text);

        $user_id = Auth::user()->id;
        $payment = Payment::where('user_id', $user_id)->first();


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

    public function datatable_history_student()
    {
        $user_id = Auth::user()->id;
        $student = Student::where('user_id', $user_id)->first();
        $student_id = $student->id;

        $model = Payment::where('status', Payment::STATUS_NOT_PAID)
            ->where('student_id', $student_id)
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

    public function index_history_payment()
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
            ->addColumn('action', function ($data) {
                $url_show = route('payment.history.show', Crypt::encrypt($data->id));
                $url_edit = route('payment.history.edit', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_show' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Lihat</a>";
                $btn .= "<a href='$url_edit' class = 'btn btn-outline-info btn-sm text-nowrap'><i class='fas fa-edit mr-2'></i> Edit</a>";

                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }
}
