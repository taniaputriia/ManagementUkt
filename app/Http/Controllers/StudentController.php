<?php

namespace App\Http\Controllers;

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

class StudentController extends Controller
{
    public function index()
    {
        // Confirm Delete Alert
        $title = 'Hapus Data!';
        $text = "Apakah yakin ingin menghapus data?";
        confirmDelete($title, $text);

        $user_id = Auth::user()->id;
        $student = Student::where('user_id', $user_id)->first();

        return view('students.index', compact('student'));
    }

    public function datatable()
    {
        $model = Student::query();
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
                $url_show = route('student.show', Crypt::encrypt($data->id));
                $url_edit = route('student.edit', Crypt::encrypt($data->id));
                $url_delete = route('student.destroy', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_show' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Lihat</a>";
                $btn .= "<a href='$url_edit' class = 'btn btn-outline-info btn-sm text-nowrap'><i class='fas fa-edit mr-2'></i> Edit</a>";
                $btn .= "<a href='$url_delete' class = 'btn btn-outline-danger btn-sm text-nowrap' data-confirm-delete='true'><i class='fas fa-trash mr-2'></i> Hapus</a>";
                $btn .= "</div>";
                return $btn;
            })
            ->toJson();
    }

    public function create()
    {
        return view('students.add');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data = Student::find($id);

        return view('students.edit', compact('data'));
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $data = Student::find($id);

        return view('students.show', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'user_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'nim' => 'required',
                'name' => 'required',
                'gender' => 'required',
                'phone_number' => 'required',
                'address' => 'required',
                'study_program' => 'required',
                'major' => 'required',
                'semester' => 'required',
                'academic_year' => 'required',
                'tuition_fee' => 'required',
                'photo' => 'mimes:jpeg,png,jpg|max:2048|required',
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

            // Create Student
            $input['user_id'] = $user->id;
            $input['tuition_fee'] = str_replace(',', '', $input['tuition_fee']);
            Student::create($input);


            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Disimpan', 'success');
            return redirect()->route('student.index');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Tidak Tersimpan', 'error');
            return redirect()->back()->withInput()->with('error', 'Data Tidak Berhasil Disimpan' . $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'nim' => 'required',
                'name' => 'required',
                'gender' => 'required',
                'phone_number' => 'required',
                'address' => 'required',
                'study_program' => 'required',
                'major' => 'required',
                'semester' => 'required',
                'academic_year' => 'required',
                'tuition_fee' => 'required',
                'photo' => 'mimes:jpeg,png,jpg|max:2048',
            ]);

            // Update Data
            $id = Crypt::decrypt($id);
            $student = Student::find($id);

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
            $student->update($input);

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Diperbarui', 'success');
            return redirect()->route('student.index');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Tidak Tersimpan', 'error');
            return redirect()->back()->withInput()->with('error', 'Data Tidak Berhasil Diperbarui' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $id = Crypt::decrypt($id);
            $student = Student::find($id);

            // Delete Data
            $student->delete();

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Dihapus', 'success');
            return redirect()->route('student.index');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Tidak Berhasil Dihapus', 'error');
            return redirect()->back()->with('error', 'Data Tidak Berhasil Dihapus' . $e->getMessage());
        }
    }
}
