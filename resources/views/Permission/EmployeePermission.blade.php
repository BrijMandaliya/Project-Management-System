@extends('Dashboard.dashboard')

@section('right-sidebar')

    <div class="offcanvas offcanvas-end" style="margin-top: 75px;width:37%;" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="EmployeePermission-offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Edit Employee Permission</h5>
            <button type="button" class="btn-close text-reset btncancel" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body ">
            <div class="form-group row ml-3">
                {{ Form::label('InputRoleTitle', 'Role Title', [
                    'class' => ['col-sm-5', 'col-form-label'],
                    'style' => 'font-size: 17px;',
                ]) }}
                <div class="col-sm-6">
                     {{ Form::label('InputRoleTitle', 'Role Title', [
                        'class' => 'col-form-label',
                        'style' => 'font-size: 17px;',
                        'id' => 'EmployeeRole'
                    ]) }}

                    <span id="errorRoleTitle" class="text-danger"></span>
                </div>
            </div>
            <div class="form-group row ml-3">
                {{ Form::label('', 'Employee Name', [
                    'class' => ['col-sm-5', 'col-form-label'],
                    'style' => 'font-size: 17px;',
                ]) }}
                <div class="col-sm-6">
                     {{ Form::label('', 'Employee Name', [
                        'class' => 'col-form-label',
                        'style' => 'font-size: 17px;',
                        'id' => 'EmployeeName'
                    ]) }}

                    <span id="errorRoleTitle" class="text-danger"></span>
                </div>
            </div>
            <div class="form-group row ml-3">
                {{ Form::label('SelectEmployeePermissions', 'Select Permissions', [
                    'class' => ['col-sm-5', 'col-form-label'],
                    'style' => 'font-size: 17px;',
                ]) }}
                <div class="col-sm-6">
                    <div class="form-group">
                        {{
                        Form::select('permissions',$permissionData->pluck('permission_title', 'id','permission_title'),null,[
                            'class' => ['js-example-basic-multiple','w-100'],
                            'multiple' => 'multiple',
                            'id' => 'SelectEmployeePermissions',
                        ]) }}
                         <span id="errorRolePermissions" class="text-danger"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="float-right mr-3 mb-5">
                <button type="submit" class="btn btn-primary mr-2 update-employee-permission-btn" id="update-employee-permission-btn">Update Employee Permission</button>
                <button class="btn btn-light btncancel" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
@endsection

@section('main-panel')

    <div class="row">
        <div class="col-md-12">
                <div class="table-responsive pt-3">
                    <table class="table" id="employee-permission-table">
                        <thead>
                            <tr>
                                <th class="ml-5">ID</th>
                                <th>Employee</th>
                                <th>Role</th>
                                <th>Permission</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

        </div>
    </div>
    <script src="{{asset("customjs/PermissionJS/employeePermissionPage.js")}}"></script>
@endsection
