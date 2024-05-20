<?php

namespace App\Http\Controllers;

use App\DataTables\ProjectDataTable;
use App\Models\Employee;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProjectManagement extends Controller
{
    public function projectDetailsPage(ProjectDataTable $projectDataTable)
    {

        $data = ["employees" => Employee::with('employee_role')->get()];
        return $projectDataTable->render('project.ProjectDetails',$data);
    }

    public function getProjectDataFromID(Request $request)
    {
        return Project::findOrFail($request->projectID);
    }

    public function addProject(Request $request)
    {
        $validate = Validator::make($request->addprojectformdata,[
            'projectName' => 'required|string',
            'projectStartDate' => 'required',
            'projectDeadLine' => 'required',
            'projectPayout' => 'required',
            'projectStatus' => 'required',
        ]);

        if($validate->fails())
        {
            return $validate->errors();
        }



        $project = new Project();
        $project->user_id = Session::has("admin") ? Session::get("admin")->id : Session::get("Employee")->user_id;
        $project->create_by = Session::has("admin") ?  "admin_".Session::get("admin")->id : "emp_".Session::get("Employee")->id;
        $project->project_code = mt_rand(100, 999);
        $project->project_name = $request->addprojectformdata['projectName'];
        $project->project_deadline = $request->addprojectformdata['projectDeadLine'];
        $project->project_startDate = $request->addprojectformdata['projectStartDate'];
        $project->employees = implode(",",$request->addprojectformdata['projectEmployees']);
        $project->project_payout = $request->addprojectformdata['projectPayout'];
        $project->status = $request->addprojectformdata['projectStatus'];
        $project->employee_id = 4;
        $project->on_create_ip = $request->ip();
        $project->save();
        return true;
    }

    public function updateProject(Request $request)
    {
        $validate = Validator::make($request->addprojectformdata,[
            'projectName' => 'required|string',
            'projectStartDate' => 'required',
            'projectDeadLine' => 'required',
            'projectPayout' => 'required',
            'projectStatus' => 'required',
        ]);

        $project = Project::findOrFail($request->addprojectformdata['projectID']);
        $project->update_by = Session::has("admin") ?  "admin_".Session::get("admin")->id : "emp_".Session::get("Employee")->id;
        $project->project_name = $request->addprojectformdata['projectName'];
        $project->project_deadline = $request->addprojectformdata['projectDeadLine'];
        $project->project_startDate = $request->addprojectformdata['projectStartDate'];
        $project->employees = implode(",",$request->addprojectformdata['projectEmployees']);
        $project->project_payout = $request->addprojectformdata['projectPayout'];
        $project->status = $request->addprojectformdata['projectStatus'];
        $project->on_update_ip = $request->ip();
        $project->save();
        return true;
    }

    public function deleteProject(Request $request)
    {

        $project = Project::findOrFail($request->projectId);
        if($project->status == "Listed")
        {
            $project->delete();
            return response()->json(['status'=>'true','projectstatus'=>$project->status]);
        }
        else
        {
            return response()->json(['status'=>'false','projectstatus'=>$project->status]);
        }

    }


}
