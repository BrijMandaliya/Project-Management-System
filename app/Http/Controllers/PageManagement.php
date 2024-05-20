<?php

namespace App\Http\Controllers;

use App\DataTables\TaskHistoryDataTable;
use App\Models\{Permissions, Employee, Project, Task};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



class PageManagement extends Controller
{
    public function loginPage()
    {
        if (Session("admin")) {
            Session::forget("admin");
        }
        return view("login");
    }

    public function registerPage()
    {
        return view("register");
    }

    public function dashboardPage()
    {
        return view('Dashboard.DashboardDetails');
    }

    public function Project_DetailsPage()
    {
        return view('project.ProjectDetails');
    }

    public function employeePermissionPage()
    {
        $permissionData = Permissions::all();
        return view('Permission.EmployeePermission', compact('permissionData'));
    }

    public function taskPage()
    {
        return view("Task.TaskDetails");
    }


    public function employeeDashboardPage(Project $project)
    {
        $task_details = Task::where(function ($query) {
                                $query->where('task_posted_by', Session::has("Employee") ? Session::get("Employee")->id : 0)
                                    ->orWhereRaw('FIND_IN_SET(?,task_assign_to)', [Session::has("Employee") ? Session::get("Employee")->id : 0]);
                                });
        $data = ['Employee' => Employee::all(), 'Project' => $project, 'Task' => $task_details];
        return view('EmployeeSide.Dashboard', $data);
    }

    public function taskHistoryPage(TaskHistoryDataTable $taskHistoryDataTable)
    {
        return $taskHistoryDataTable->render('Task.TaskHistory');
    }
}
