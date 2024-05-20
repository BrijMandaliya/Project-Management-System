<?php

namespace App\Http\Controllers;

use App\Models\EmployeePermission;
use App\Models\Permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Contracts\DataTables;
use Illuminate\Support\Str;

class EmployeePermissionManagement extends Controller
{
    public function getEmployeePermission()
    {
        $EmployeePermission = EmployeePermission::with('employee_role','employee')->get();
        return DataTables($EmployeePermission)
        ->addIndexColumn()
        ->addColumn('action',function($raw){
            return '<div class="dropdown">
                <a type="button" style="font-size:15px;margin:10px;" id="threeDotMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    &#8942;
                </a>
                <div class="dropdown-menu h-auto action-option" aria-labelledby="threeDotMenu" style="min-width:5%;">
                    <a class="dropdown-item editbtn btn btn-icon-text" id="editbtn" data-id="' . $raw->id . '">Edit <i class="typcn typcn-edit btn-icon-append"></i></a>
                </div>
            </div>';
        })
        ->addColumn('employee',function($EmployeePermission)
        {
            return $EmployeePermission->employee->emp_name;
        })
        ->addColumn('Role',function($EmployeePermission)
        {
            return $EmployeePermission->employee_role->role_title;
        })
        ->addColumn('Permissions',function($EmployeePermission,Permissions $permissions)
        {
            $permissionsData = "";
            foreach ($permissions::all() as $key => $value) {
                if(Str::contains($EmployeePermission->permission_id,$value->id))
                {
                    $permissionsData .= $value->permission_title . ",";
                }
               }
               return substr($permissionsData,0,-1);
        })
        ->setRowId('id')
        ->toJson();
    }

    public function getEmployeePermissionById(Request $request)
    {
        return EmployeePermission::with('employee_role','employee')->findOrFail($request->employeePermissionID);
    }


    public function updateEmployeePermission(Request $request)
    {

        $employeePermission = EmployeePermission::findOrFail($request->employeePermissionId);
        $employeePermission->permission_id = implode(",",$request->employeePermissions);
        $employeePermission->update_by = Session::has("admin") ?  "admin_".Session::get("admin")->id : "emp_".Session::get("Employee")->id;
        $employeePermission->on_update_ip = $request->ip();
        $employeePermission->save();
        if(Session("Employee")->id == $employeePermission->employee_id)
        {
            Session("Employee")->permissions = $request->empPermissions;
        }
        return true;
    }
}
