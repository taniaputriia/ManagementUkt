<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Hak Akses
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // Confirm Delete Alert
        $title = 'Hapus Data!';
        $text = "Apakah yakin ingin menghapus data? Data yang dihapus tidak dapat dikembalikan";
        confirmDelete($title, $text);

        return view('users.index');
    }

    public function datatable()
    {
        $model = User::query();

        return DataTables::of($model)
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->translatedFormat('d F Y - H:i');
                return $formatedDate;
            })
            ->addColumn('action', function ($data) {
                $url_show = route('user.show', Crypt::encrypt($data->id));
                $url_edit = route('user.edit', Crypt::encrypt($data->id));
                $url_delete = route('user.destroy', Crypt::encrypt($data->id));

                $btn = "<div class='btn-group'>";
                $btn .= "<a href='$url_show' class = 'btn btn-outline-primary btn-sm text-nowrap'><i class='fas fa-info mr-2'></i> Lihat</a>";
                $btn .= "<a href='$url_edit' class = 'btn btn-outline-info btn-sm text-nowrap'><i class='fas fa-edit mr-2'></i> Edit</a>";
                $btn .= "<a href='$url_delete' class = 'btn btn-outline-danger btn-sm text-nowrap' data-confirm-delete='true'><i class='fas fa-trash mr-2'></i> Hapus</a>";

                $btn .= "</div>";
                return $btn;
            })
            ->addColumn('role', function ($data) {
                if (!empty($data->getRoleNames())) {
                    $roleList = [];
                    foreach ($data->getRoleNames() as $item) {
                        array_push($roleList, $item);
                    }
                    return $roleList;
                }
            })
            ->rawColumns(['action', 'role'])
            ->toJson();
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.add', compact('roles'));
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::find($id);

        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate Data
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'roles' => 'required',
            ]);

            // Create Data
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $user->assignRole($request->input('roles'));

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Disimpan', 'success');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Tidak Tersimpan', 'error');
            return redirect()->back()->with('error', 'Data Tidak Berhasil Disimpan' . $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $id = Crypt::decrypt($id);

            // Validate Data
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|same:confirm-password',
                'roles' => 'required',
            ]);

            // Update Data
            $input = $request->all();

            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, ['password']);
            }

            $user = User::find($id);

            $user->update($input);

            DB::table('model_has_roles')
                ->where('model_id', $id)
                ->delete();

            $user->assignRole($request->roles);

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Diperbarui', 'success');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Gagal Diperbarui', 'error');
            return redirect()->back()->with('error', 'Data Tidak Berhasil Diperbarui' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Delete Data
            $id = Crypt::decrypt($id);
            $user = User::find($id);

            if ($id == Auth::user()->id) {
                DB::rollBack();

                // Alert & Redirect
                Alert::toast('Akun Sedang Dipakai', 'error');
                return redirect()->back();
            } else {
                $user->delete();
            }

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Dihapus', 'success');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Gagal Dihapus', 'error');
            return redirect()->back()->with('error', 'Data Tidak Berhasil Dihapus' . $e->getMessage());
        }
    }
}
