<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;

class RoleController extends Controller
{
    // Hak Akses
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // Confirm Delete Alert
        $title = 'Hapus Data!';
        $text = "Apakah yakin ingin menghapus data? Data yang dihapus tidak dapat dikembalikan";
        confirmDelete($title, $text);

        return view('roles.index');
    }

    public function datatable()
    {
        $model = Role::query();

        return DataTables::of($model)
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->translatedFormat('d F Y - H:i');
                return $formatedDate;
            })
            ->addColumn('action', function ($data) {
                $url_show = route('role.show', Crypt::encrypt($data->id));
                $url_edit = route('role.edit', Crypt::encrypt($data->id));
                $url_delete = route('role.destroy', Crypt::encrypt($data->id));

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
        $permissions = Permission::all();
        return view('roles.add', compact('permissions'));
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $role = Role::find($id);
        $permissions = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate Data
            $request->validate([
                'name' => 'required|unique:roles,name',
                'permission' => 'required'
            ]);

            // Create Data
            $role = Role::create(['name' => $request->name]);
            $role->syncPermissions($request->permission);

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Disimpan', 'success');
            return redirect()->route('role.index');
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
                'permission' => 'required'
            ]);

            // Update Data
            $role = Role::find($id);
            $role->update([
                'name' => $request->name
            ]);
            $role->syncPermissions($request->permission);

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Diperbarui', 'success');
            return redirect()->route('role.index');
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
            $role = Role::find($id);

            $roleHasPermission = DB::table("role_has_permissions")
                ->where('role_id', $id)
                ->pluck('role_id')
                ->first();

            if ($id == $roleHasPermission) {
                DB::rollBack();

                // Alert & Redirect
                Alert::toast('Role Sedang Dipakai', 'error');
                return redirect()->back();
            } else {
                $role->delete();
            }

            // Save Data
            DB::commit();

            // Alert & Redirect
            Alert::toast('Data Berhasil Dihapus', 'success');
            return redirect()->route('role.index');
        } catch (\Exception $e) {
            // If Data Error
            DB::rollBack();

            // Alert & Redirect
            Alert::toast('Data Gagal Dihapus', 'error');
            return redirect()->back()->with('error', 'Data Tidak Berhasil Dihapus' . $e->getMessage());
        }
    }
}
