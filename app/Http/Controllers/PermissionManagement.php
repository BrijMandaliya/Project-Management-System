<?php

namespace App\Http\Controllers;

use App\DataTables\PermissionDataTable;
use App\Models\Employee;
use App\Models\EmployeePermission;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Str;

class PermissionManagement extends Controller
{
    public function getPermissionData(PermissionDataTable $permissionDataTable)
    {
        return $permissionDataTable->render('Permission.Permission');
    }

    public function addPermission(Request $request)
    {
        $permission = new Permissions();
        $permission->permission_title = $request->permissionTitle;
        $permission->create_by = Session::has("admin") ?  "admin_".Session::get("admin")->id : "emp_".Session::get("Employee")->id;
        $permission->on_create_ip = $request->ip();
        $permission->user_id = Session::has("admin")?Session::get("admin")->id:Session::get("Employee")->user_id;
        $permission->save();
        return true;
    }

    public function updatePermission(Request $request)
    {
        $permission = Permissions::findOrFail($request->permissionId);
        $permission->permission_title = $request->permissionTitle;
        $permission->update_by = Session::has("admin") ?  "admin_".Session::get("admin")->id : "emp_".Session::get("Employee")->id;
        $permission->on_update_ip = $request->ip();
        $permission->save();
        return true;
    }

    public function deletePermission(Request $request)
    {
        $roles = Roles::all();
        $employeePermission = EmployeePermission::all();
        foreach ($roles as $key => $value) {
            if(Str::contains($value->permission_id,$request->permissionId))
            {
                return 'false';
            }
        }
        foreach ($employeePermission as $key => $value) {
            if(Str::contains($value->permission_id,$request->permissionId))
            {
                return 'false';
            }
        }
        $permission = Permissions::findOrFail($request->permissionId);
        $permission->delete();
        return true;
    }
}
