<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeeDataTable;
use App\Models\Employee;
use App\Models\Roles;
use App\Models\Permissions;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class EmployeeManagement extends Controller
{
    protected $data;
    public function employeePage(EmployeeDataTable $employeeDataTable)
    {
        return $employeeDataTable->render('employee.EmployeeDetails');
    }

    public function addEmployeePage()
    {
        $this->data = ['Roles' => Roles::all()];
        return view('employee.AddEmployee', $this->data);
    }

    public function addEmployee(Request $request)
    {
        try {

            $request->validate([
                'EmployeeName' => 'required|string',
                'EmployeeEmail' => 'required|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                'employeeDOB' => 'required',
                'EmployeeRole' => 'required',
                'EmployeePhoneNumber' => 'required|min:10|max:10',
                'EmployeeAddress' => 'required',
                'EmployeeCountry' => 'required',
            ]);

            if ($request->emp_profile_photo != null) {

                $EmployeeProfilePhotoExtentsion = $request->emp_profile_photo->getClientOriginalExtension();

                if ($EmployeeProfilePhotoExtentsion == "jpg" || $EmployeeProfilePhotoExtentsion == "jpeg" || $EmployeeProfilePhotoExtentsion == "png") {
                    if ($request->emp_profile_photo->getSize() <= 200000) {
                        $manager = new ImageManager(['driver' => 'imagick']);
                        $EmployeeProfilePhoto = $manager->make($request->emp_profile_photo);
                        $EmployeeProfilePhoto = $EmployeeProfilePhoto->resize(370, 370);
                        $EmployeeProfilePhoto->save(public_path('EmployeeProfilePhoto' . "/" . $EmployeeProfilePhoto->getClientOriginalName()), 70);
                    } else {
                        return back()->with('Invalid Profile Photo', 'Profile Photo Size Should be Less Than 200KB');
                    }
                } else {
                    return back()->with('Invalid Profile Photo', 'Profile Photo Should in .png, .jpeg, .jpg');
                }
            }

            $empcheck = Employee::where('emp_phone_number', $request->EmployeePhoneNumber)->get();

            if ($empcheck->count() == 0) {
                $emp = new Employee();
                $emp->emp_name = $request->EmployeeName;
                $emp->emp_email = $request->EmployeeEmail;
                $emp->emp_phone_number = $request->EmployeePhoneNumber;
                $emp->emp_code = mt_rand(1000, 9999);
                $emp->emp_address = $request->EmployeeAddress;
                $emp->emp_country = $request->EmployeeCountry;
                $emp->user_id = 1;
                $emp->emp_gender = $request->gender;
                $emp->emp_DOB = $request->employeeDOB;
                $emp->emp_password = 12345678;
                $emp->roles_id = $request->EmployeeRole;
                $emp->create_by = Session::has("admin") ?  "admin_".Session::get("admin")->id : "emp_".Session::get("Employee")->id;
                $emp->emp_profile_image = $request->emp_profile_photo != null ? $request->emp_profile_photo->getClientOriginalName() : "DefaultEmployeeProfilePhoto.png";
                $emp->on_create_ip = $request->ip();
                $emp->save();

                $role = Roles::findOrFail($request->EmployeeRole);
                DB::table('employee_permission')
                    ->insert([
                        "roles_id" => $request->EmployeeRole,
                        "employee_id" => $emp->id,
                        "permission_id" => $role->permission_id,
                        "create_by" => Session::has("admin") ?  "admin_".Session::get("admin")->id : "emp_".Session::get("Employee")->id,
                        "user_id" => Session::has("admin")?Session::get("admin")->id:Session::get("Employee")->user_id,
                        'on_create_ip' => $request->ip(),
                    ]);
                return redirect('/admin/employees')->with('Employee Add Status', 'Employee Added SuccessFully');
            }
            else
            {
                return back()->with("DuplicatePhoneNumber","Phone Number is already Used");
            }
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function deleteEmployee(Request $request)
    {
        $emp = Employee::findOrFail($request->employeeID);
        $emp->delete();
        return true;
    }

    public function editEmployee($id)
    {
        $this->data = ['Roles' => Roles::all(), 'Employee' => Employee::findOrFail($id)];
        return view("employee.EditEmployee", $this->data);
    }

    public function updateEmployee(Request $request)
    {
        try {
            $request->validate([
                'EmployeeName' => 'required',
                'EmployeeEmail' => 'required|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                'employeeDOB' => 'required',
                'EmployeeRole' => 'required',
                'EmployeePhoneNumber' => 'required',
                'EmployeeAddress' => 'required',
                'EmployeeCountry' => 'required',
            ]);

            if ($request->emp_profile_photo != null) {

                $EmployeeProfilePhotoExtentsion = $request->emp_profile_photo->getClientOriginalExtension();
                if ($EmployeeProfilePhotoExtentsion == "jpg" || $EmployeeProfilePhotoExtentsion == "jpeg" || $EmployeeProfilePhotoExtentsion == "png") {
                    if ($request->emp_profile_photo->getSize() <= 200000) {
                        $manager = new ImageManager(['driver' => 'imagick']);
                        $EmployeeProfilePhoto = $manager->make($request->emp_profile_photo);
                        $EmployeeProfilePhoto = $EmployeeProfilePhoto->resize(370, 370);
                        $EmployeeProfilePhoto->save(public_path('EmployeeProfilePhoto' . "/" . $request->emp_profile_photo->getClientOriginalName()), 70);
                    } else {
                        return back()->with('Invalid Profile Photo', 'Profile Photo Size Should be Less Than 200KB');
                    }
                } else {
                    return back()->with('Invalid Profile Photo', 'Profile Photo Should in .png, .jpeg, .jpg');
                }
            }

            $emp = Employee::findOrFail($request->EmployeeId);
            $emp->emp_name = $request->EmployeeName;
            $emp->emp_email = $request->EmployeeEmail;
            $emp->emp_phone_number = $request->EmployeePhoneNumber;
            $emp->emp_address = $request->EmployeeAddress;
            $emp->emp_country = $request->EmployeeCountry;
            $emp->user_id = 1;
            $emp->emp_gender = $request->gender;
            $emp->emp_DOB = $request->employeeDOB;
            $emp->roles_id = $request->EmployeeRole;
            $emp->emp_profile_image = $request->emp_profile_photo != null ? $request->emp_profile_photo->getClientOriginalName() : $request->EmployeeOldImage;
            $emp->update_by = Session::has("admin") ?  "admin_".Session::get("admin")->id : "emp_".Session::get("Employee")->id;
            $emp->on_update_ip = $request->ip();
            $emp->save();

            if ($request->EmployeeRole != $request->EmployeeOldRole) {
                $role = Roles::findOrFail($request->EmployeeRole);
                DB::table('employee_permission')
                    ->where('employee_id', $request->EmployeeId)
                    ->update([
                        "roles_id" => $request->EmployeeRole,
                        "permission_id" => $role->permission_id,
                    ]);
            }
            return redirect('/admin/employees')->with('Employee Update Status', 'Employee Updated SuccessFully');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function loginCheck(Request $request)
    {
        $request->validate([
            'EmployeeEmail' => 'required|email|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
            'EmployeePassword' => 'required|min:8|max:32',
        ]);

        $employee = Employee::where([
            ['emp_email', $request->EmployeeEmail],
        ])
            ->with('employee_permission', 'employee_role','users')
            ->get()
            ->first();


        $permissions = '';



        if (isset($employee)) {
            foreach (Permissions::all() as $key => $value) {
                if (Str::contains($employee->employee_permission->first()->permission_id, $value->id)) {
                    $permissions .= $value->permission_title . ",";
                }
            }

            $employee->permissions = $permissions;
            if ($employee->emp_password == "12345678") {
                return back()->with('createNewPassword', $employee->emp_email);
            } else if ($request->EmployeePassword == Crypt::decrypt($employee->emp_password)) {
                Session::put("Employee", $employee);
                return redirect('/dashboard')->with('LoginSuccess', 'Employee Login Success');
            } else {
                return back()->with('InvalidCredentials', 'Password is incorrect');
            }
        } else {
            return back()->with('InvalidCredentials', 'Email is incorrect');
        }
    }

    public function updatePassword(Request $request)
    {

        $employee = Employee::where("emp_email", $request->EmployeeEmail)->get()->first();
        $employee->emp_password = crypt::encrypt($request->NewPassword);
        $employee->save();
        return true;
    }

    public function employeeLogout()
    {
        if (Session::has("Employee")) {
            Session::forget("Employee");
        }
        return redirect('/login');
    }
}
