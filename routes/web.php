<?php

use App\Http\Controllers\PageManagement;
use App\Http\Controllers\PermissionManagement;
use App\Http\Controllers\RolesManagement;
use App\Http\Controllers\EmployeeManagement;
use App\Http\Controllers\EmployeePermissionManagement;
use App\Http\Controllers\ProjectManagement;
use App\Http\Controllers\TaskManagement;
use App\Http\Controllers\UserManager;
use App\Models\Employee;
use App\Models\EmployeePermission;
use App\Models\Roles;
use App\Models\Permissions;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::POST('/loginCheckCredentials', [UserManager::class, 'loginCheckCredential'])->name('login-check-credential');
Route::POST('/registeruser', [UserManager::class, 'registerUser'])->name('regitser-user');

Route::prefix('admin')->group(function () {
    Route::get("/login", [PageManagement::class, 'loginPage'])->name('login-page');
    Route::get("/register", [PageManagement::class, 'registerPage'])->name('register-page');
});

Route::group(['middleware' => 'LoginAuth'], function () {

    Route::prefix('roles')->group(function () {
        Route::post('/addrole', [RolesManagement::class, 'addRole'])->name('add-role');
        Route::post('/updaterole', [RolesManagement::class, 'updateRole'])->name('update-role');
        Route::post('/deleterole', [RolesManagement::class, 'deleteRole'])->name('delete-role');
        Route::post('/getroledatafromid', [RolesManagement::class, 'getRoleDataFromId'])->name('get-Role-Data-From-Id');
    });

    Route::prefix('permission')->group(function () {
        Route::post('/addpermission', [PermissionManagement::class, 'addPermission'])->name('add-permisison');
        Route::post('/updatepermission', [PermissionManagement::class, 'updatePermission'])->name('update-permisison');
        Route::post('/deletepermission', [PermissionManagement::class, 'deletePermission'])->name('delete-permisison');
        Route::post('/getemployeepermission', [EmployeePermissionManagement::class, 'getEmployeePermission'])->name('get-employee-permission');
        Route::post('/getemployeepermissionbyid', [EmployeePermissionManagement::class, 'getEmployeePermissionById'])->name('get-employee-permission-by-id');
        Route::post('/updateemployeepermission', [EmployeePermissionManagement::class, 'updateEmployeePermission'])->name('update-employee-permission');
    });

    Route::prefix('project')->group(function () {
        Route::post('/addproject', [ProjectManagement::class, 'addProject'])->name('add-project');
        Route::post('/updateproject', [ProjectManagement::class, 'updateProject'])->name('update-project');
        Route::post('/deleteproject', [ProjectManagement::class, 'deleteProject'])->name('delete-project');
        Route::post('/getprojectdatafromid', [ProjectManagement::class, 'getProjectDataFromID'])->name('get-project-data-from-id');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [PageManagement::class, 'dashboardPage'])->name('dashboard-page');
        Route::get('/Projects', [ProjectManagement::class, 'projectDetailsPage'])->name('Project-Page');
        Route::get('/employees', [EmployeeManagement::class, 'employeePage'])->name('employee-page');
        Route::get('/roles', [RolesManagement::class, 'getRolesData'])->name('role-page');
        Route::get('/permission', [PermissionManagement::class, 'getPermissionData'])->name('permission-page');
        Route::get('/employeepermission', [PageManagement::class, 'employeePermissionPage'])->name('employee-permission-Page');
    });

    Route::prefix('employee')->group(function () {
        Route::get('/addemployeepage', [EmployeeManagement::class, 'addEmployeePage'])->name('add-employee-page');
        Route::post('/addemployee', [EmployeeManagement::class, 'addEmployee'])->name('add-employee');
        Route::post('/deleteemployee', [EmployeeManagement::class, 'deleteEmployee'])->name('delete-employee');
        Route::get('/editemployee/{id}', [EmployeeManagement::class, 'editEmployee'])->name('edit-employee');
        Route::post('/updateemployee', [EmployeeManagement::class, 'updateEmployee'])->name('update-employee');
    });

    Route::prefix('project')->group(function () {
        Route::post('/addproject', [ProjectManagement::class, 'addProject'])->name('add-project');
        Route::post('/updateproject', [ProjectManagement::class, 'updateProject'])->name('update-project');
        Route::post('/deleteproject', [ProjectManagement::class, 'deleteProject'])->name('delete-project');
        Route::post('/getprojectdatafromid', [ProjectManagement::class, 'getProjectDataFromID'])->name('get-project-data-from-id');
    });

    Route::prefix('Task')->group(function () {
        Route::get("/taskhistory", [PageManagement::class, 'taskHistoryPage'])->name('task-history-page');
        Route::post("/addtotaskhistory", [TaskManagement::class, 'addToTaskHistory'])->name('add-to-task-history');
        Route::post("/getTaskHistoryData", [TaskManagement::class, 'getTaskHistoryData'])->name('get-task-history-data');

        Route::get("/taskdetails", [TaskManagement::class, 'taskPage'])->name('task-page');
        Route::post("/getemployeesfromproject", [TaskManagement::class, 'getEmployeesFromProject'])->name('get-employees-from-project');
        Route::post("/addtask", [TaskManagement::class, 'addTask'])->name('add-task');
        Route::post("/updatetask", [TaskManagement::class, 'updateTask'])->name('update-task');
        Route::post("/deletetask", [TaskManagement::class, 'deleteTask'])->name('delete-task');
        Route::post("/gettaskdatafromid", [TaskManagement::class, 'getTaskDataFromId'])->name('get-task-data-from-id');
    });

    Route::get('/dashboard', [PageManagement::class, 'employeeDashboardPage'])->name('employee-dashboard-page');



    Route::get("/employeeLogout", [EmployeeManagement::class, 'employeeLogout'])->name('employee-logout');
});

Route::get('/login', function () {
    return view('EmployeeSide.Login & Register.Login&Register');
});

Route::post('/logincheck', [EmployeeManagement::class, 'loginCheck'])->name('login-check');

Route::post('/updateemployeepassword', [EmployeeManagement::class, 'updatePassword'])->name('update-password');

Route::get('/checking', function (Task $task) {
    $employees = '';
    foreach (Employee::all() as $key => $value) {
        if (in_array($value->id,[9,14])) {
            $employees .= $value->emp_name . ',';
        }
    }

    dd($employees);
});
