<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\DataTables\RolesDataTable;
use App\Models\EmployeePermission;
use App\Models\Permissions;
use Exception;
use Illuminate\Support\Facades\Session;

use function Termwind\render;

class RolesManagement extends Controller
{
    protected $data;
    public function getRolesData(RolesDataTable $rolesDataTable, Roles $roles)
    {
        $permissionData = Permissions::all();
        $this->data = ['permissionData' => $permissionData];
        return $rolesDataTable->render("Roles.rolesDetails", $this->data);
    }

    public function getRoleDataFromId(Request $request)
    {
        $this->data = ['Permissions' => Roles::findOrFail($request->roleID)];
        return $this->data;
    }

    public function addRole(Request $request)
    {
        $rolePermissions = implode(",", $request->rolePermissions);
        $role = new Roles();

        $role->role_title = $request->roleTitle;
        $role->permission_id = $rolePermissions;
        $role->user_id = Session::has("admin") ? Session::get("admin")->id : Session::get("Employee")->user_id;
        $role->create_by = Session::has("admin") ?  "admin_" . Session::get("admin")->id : "emp_" . Session::get("Employee")->id;
        $role->on_create_ip = $request->ip();
        $role->save();
        return true;
    }

    public function updateRole(Request $request)
    {

        $rolePermissions = implode(",", $request->rolePermissions);
        $roles = Roles::findOrFail($request->roleID);
        $roles->role_title = $request->roleTitle;
        $roles->permission_id = $rolePermissions;
        $roles->update_by = Session::has("admin") ?  "admin_" . Session::get("admin")->id : "emp_" . Session::get("Employee")->id;
        $roles->on_update_ip = $request->ip();
        $roles->save();

        $employeePermission = EmployeePermission::where("roles_id", $request->roleID)->first();
        if ($employeePermission != null) {
            $employeePermission->permission_id = $rolePermissions;
            $employeePermission->update_by = Session::has("admin") ?  "admin_" . Session::get("admin")->id : "emp_" . Session::get("Employee")->id;
            $employeePermission->save();
            if ((Session::has("Employee") ? Session("Employee")->id : 0) == $employeePermission->employee_id) {
                Session("Employee")->permissions = $request->permissions;
            }
        }
        return true;
    }

    public function deleteRole(Request $request)
    {
        try {
            $roles = Roles::findOrFail($request->roleID);
            $roles->delete();
            return response()->json(['status' => true]);
        } catch (Exception $e) {
            if (Str::contains($e->getMessage(), 'Cannot delete or update a parent row')) {
                return response()->json(['status' => false, 'statusMessage' => 'Cannot Deleted This Role as This Role is Assign to any one Developer']);
            }
            return $e->getMessage();
        }
    }
}
