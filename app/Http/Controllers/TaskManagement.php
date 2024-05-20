<?php

namespace App\Http\Controllers;

use App\DataTables\TaskDataTable;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskHistory;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class TaskManagement extends Controller
{
    public function taskPage(TaskDataTable $taskDataTable)
    {
        $projects = Project::where("status", "!=", "Completed")->get();
        $data = ['projects' => $projects];
        return $taskDataTable->render("Task.TaskDetails", $data);
    }

    public function getTaskDataFromId(Request $request)
    {
        return Task::findOrFail($request->taskId);
    }

    public function getEmployeesFromProject(Request $request)
    {
        $project = Project::findOrFail($request->projectID);
        $employees = [];
        foreach (Employee::with('employee_role')->get() as $key => $value) {
            if($value->employee_role->role_title == "Developer")
            {
                if (Str::contains($project->employees, $value->id)) {
                    array_push($employees, ['id' => $value->id, 'name' => $value->emp_name]);
                }
            }
        }
        return ['employees' => $employees, 'deadLine' => $project->project_deadline];
    }

    public function addTask(Request $request)
    {

        if (strtotime($request->TaskDeadLine) >= strtotime($request->TaskMaxDeadLine)) {

            return back()->with('TaskDeadLine', 'DeadLine is incorrect');
        } elseif (strtotime($request->TaskDeadLine) <= strtotime(Carbon::now()->format('Y-m-d'))) {

            return back()->with('TaskDeadLine', 'DeadLine is incorrect');
        }

        $request->validate([
            'TaskTitle' => 'required|string',
            'SelectProject' => 'required',
            'SelectEmployee' => 'required',
            'SelectTaskType' => 'required',
            'TaskDeadLine' => 'required',
        ]);



        $TaskImagesName = null;
        if ($request->TaskImages != null) {
            $manager = new ImageManager(['driver' => 'imagick']);

            foreach ($request->TaskImages as $key => $value) {
                $TaskImageExtension = $value->getClientOriginalExtension();

                if ($TaskImageExtension == "jpg" || $TaskImageExtension == "jpeg" || $TaskImageExtension == "png") {
                    if ($value->getSize() <= 200000) {
                        $TaskImage = $manager->make($value);
                        $TaskImage->save(public_path('TaskImages' . "/" . $value->getClientOriginalName()), 70);
                        $TaskImagesName .= $value->getClientOriginalName() . ',';
                    } else {
                        return back()->with('ImageFormat', 'Image should be Less Than 200KB and Image ' . ($key + 1) . ' is greater than 200kb');
                    }
                } else {
                    return back()->with('ImageFormat', 'Image should be .png .jpg .jpeg');
                }
            }
            $TaskImagesName = substr($TaskImagesName, 0, -1);
        }

        $task = new Task();
        $task->task_id = mt_rand(10000, 99999);
        $task->user_id = Session::has("admin") ? Session::get("admin")->id : Session::get("Employee")->user_id;
        $task->task_title = $request->TaskTitle;
        $task->task_description = $request->TaskDescription;
        $task->project_id = $request->SelectProject;
        $task->task_type = $request->SelectTaskType;
        $task->task_posted_by = Session("Employee")->id;
        $task->task_assign_to = implode(",", $request->SelectEmployee);
        $task->task_DeadLine = $request->TaskDeadLine;
        $task->task_images = $TaskImagesName;
        $task->task_status = "Listed";
        $task->on_task_create_ip = $request->ip();
        $task->save();
        return back()->with('AddTaskSuccess', 'Task Added SuccessFully');
    }

    public function updateTask(Request $request)
    {

        if (strtotime($request->TaskDeadLine) >= strtotime($request->TaskMaxDeadLine)) {
            return back()->with('TaskDeadLine', 'DeadLine is incorrect');
        } elseif (strtotime($request->TaskDeadLine) <= strtotime(Carbon::now()->format('Y-m-d'))) {
            return back()->with('TaskDeadLine', 'DeadLine is incorrect');
        }
        $request->validate([
            'TaskTitle' => 'required|string',
            'SelectProject' => 'required',
            'SelectEmployee' => 'required',
            'SelectTaskType' => 'required',
            'TaskDeadLine' => 'required',
        ]);

        $TaskImagesName = '';
        if ($request->TaskImages != null) {
            $manager = new ImageManager(['driver' => 'imagick']);

            foreach ($request->TaskImages as $key => $value) {
                $TaskImageExtension = $value->getClientOriginalExtension();

                if ($TaskImageExtension == "jpg" || $TaskImageExtension == "jpeg" || $TaskImageExtension == "png") {
                    if ($value->getSize() <= 200000) {
                        $TaskImage = $manager->make($value);

                        $TaskImage->save(public_path('TaskImages' . "/" . $value->getClientOriginalName()), 70);
                        if (!(Str::contains($request->taskoldimages, $value->getClientOriginalName()))) {
                            $TaskImagesName .= $value->getClientOriginalName() . ',';
                        }
                    } else {
                        return back()->with('ImageFormat', 'Image should be Less Than 200KB and Image ' . ($key + 1) . ' is greater than 200kb');
                    }
                } else {
                    return back()->with('ImageFormat', 'Image should be .png .jpg .jpeg');
                }
            }
            $TaskImagesName = substr($TaskImagesName, 0, -1);
        }
        $TaskImagesName = $TaskImagesName . $request->taskoldimages;

        // dd($TaskImagesName != '' ? ($TaskImagesName[strlen($TaskImagesName) - 1] == "," ? substr($TaskImagesName, 0, -1) : $TaskImagesName) : null);
        $task = Task::findOrFail($request->TaskId);
        $task->task_title = $request->TaskTitle;
        $task->task_description = $request->TaskDescription;
        $task->project_id = $request->SelectProject;
        $task->task_type = $request->SelectTaskType;
        $task->task_assign_to = implode(",", $request->SelectEmployee);
        $task->task_DeadLine = $request->TaskDeadLine;
        $task->task_images =  $TaskImagesName != '' ? $TaskImagesName[strlen($TaskImagesName) - 1] == "," ? substr($TaskImagesName, 0, -1) : $TaskImagesName : null;
        $task->task_update_id = Session::has("admin") ? "admin_".Session::get("admin")->id : "Emp_".Session::get("Employee")->id;
        $task->on_task_update_ip = $request->ip();
        $task->save();

        return back()->with('UpdateTaskSuccess', 'Task Updated SuccessFully');
    }

    public function deleteTask(Request $request)
    {
        $task = Task::findOrFail($request->taskId);
        $task->delete();
        return true;
    }

    public function getTaskHistoryData()
    {
        $taskHistory = TaskHistory::with('employee', 'project', 'task')->get();

        return DataTables($taskHistory)
        ->addColumn('task_name',function($raw)
        {
            return $raw->task->task_name;
        })
        ->rawColumns(['task_name'])
        ->toJson();
    }

    public function addToTaskHistory(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->task_status = $request->task_status;
        $task->save();

        $taskHistory = new TaskHistory();
        $taskHistory->project_id = $request->project_id;
        $taskHistory->employee_id = Session("Employee")->id;
        $taskHistory->task_id = $request->task_id;
        $taskHistory->user_id = Session::has("Employee") ? Session::get("Employee")->user_id : 0;
        $taskHistory->task_status = $request->task_status;
        $taskHistory->IP = $request->ip();
        $taskHistory->save();
        return true;
    }
}
