@extends('Dashboard.dashboard')

@section('main-panel')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Employee</h4>
                <form class="form-sample" id="updateEmployeeForm" action="{{route('update-employee')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <p class="card-description">
                        Personal info
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="EmployeeName" class="col-sm-5 col-form-label">Employee Full Name <span class="text-danger">*</span></label>

                                <div class="col-sm-7">

                                    {{ Form::text('EmployeeName', $Employee->emp_name, [
                                        'class' => 'form-control',
                                        'id' => 'EmployeeName',
                                    ]) }}

                                    {{
                                        Form::hidden("EmployeeId",$Employee->id)
                                    }}

                                    <span id="errorEmployeeFullName" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="EmployeeEmail" class="col-sm-5 col-form-label">Email <span class="text-danger">*</span></label>

                                <div class="col-sm-7">

                                    {{ Form::Email('EmployeeEmail', $Employee->emp_email, [
                                        'class' => 'form-control',
                                        'id' => 'EmployeeEmail',
                                    ]) }}
                                    <span id="errorEmployeeEmail" class="text-danger"></span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Gender <span class="text-danger">*</span></label>
                                <div class="col-3">
                                    <div class="form-check form-check-primary">
                                        <label for="MaleGender" class="form-check-label">Male
                                            <input type="radio" name="gender" value="Male" id="MaleGender" class="form-check-input" {{$Employee->emp_gender == "Male" ? 'Checked' : ''}}>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-check-primary">
                                         <label for="FemaleGender" class="form-check-label">Female
                                            <input type="radio" name="gender" value="Female" id="FemaleGender" class="form-check-input" {{$Employee->emp_gender == "Female" ? 'Checked' : ''}}>
                                         </label>
                                    </div>
                                    <span id="errorEmployeeGender" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="employeeDOB">Date of Birth <span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    {{
                                        Form::date('employeeDOB',$Employee->emp_DOB,['class'=>'form-control','id'=>'employeeDOB'])
                                    }}
                                    <span id="errorEmployeeDOB" class="text-danger"></span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Select Role <span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    {{ Form::select('EmployeeRole',['' => 'Select Employee Role'] + $Roles->pluck('role_title', 'id')->toArray(),$Employee->roles_id, ['class' => ['form-select'], 'id' => 'EmployeeRole']) }}
                                    <span id="errorEmployeeRole" class="text-danger"></span>
                                    {{
                                        Form::hidden("EmployeeOldRole",$Employee->roles_id)
                                    }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Phone Number <span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    {{ Form::tel('EmployeePhoneNumber', $Employee->emp_phone_number, [
                                        'class' => ['form-control'],
                                        'id' => 'EmployeePhoneNumber',
                                    ]) }}
                                    <span id="errorEmployeePhoneNumber" class="text-danger"></span>

                                </div>
                            </div>
                        </div>

                    </div>
                    <p class="card-description">
                        Address
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Address <span class="text-danger">*</span></label>
                                <div class="col-sm-7">

                                    {{ Form::textarea('EmployeeAddress', $Employee->emp_address, [
                                        'class' => ['form-control'],
                                        'id' => 'EmployeeAddress',
                                        'rows' => '4',
                                    ]) }}
                                    <span id="errorEmployeeAddress" class="text-danger"></span>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Country <span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    {{ Form::select(
                                        'EmployeeCountry',
                                        [
                                            '' => 'Select Country',
                                            'America' => 'America',
                                            'Italy' => 'Italy',
                                            'India' => 'India',
                                            'Russia' => 'Russia',
                                            'Britain' => 'Britain',
                                        ],
                                        $Employee->emp_country,
                                        ['class' => ['form-select'], 'id' => 'EmployeeCountry'],
                                    ) }}
                                    <span id="errorEmployeeCountry" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="card-description">
                        Profile Photo
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Your Profile Photo</label>
                                <div class="col-sm-7">
                                    {{ Form::file('emp_profile_photo', [
                                        'class' => 'form-control file-upload-info',
                                        'id' => 'emp_profile_photo',
                                        'accept' => '.jpeg,.png,.jpg',
                                    ]) }}
                                    <span id="errorEmployeeProfilePhoto" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-sm-7">
                                    <img src="{{asset("EmployeeProfilePhoto/".$Employee->emp_profile_image)}}" name="EmpOldImage" alt="" srcset="" height="100px" width="100px">
                                    {{
                                        Form::hidden("EmployeeOldImage",$Employee->emp_profile_image)
                                    }}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="float-right mt-3">
                        <a type="Button" class="btn btn-primary mr-2" id="updateEmployeeBtn">Update</a>
                        <a type="button" href="/admin/employees" class="btn btn-light">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="{{asset("customjs/validation.js")}}"></script>
    <script src="{{asset('customjs/EmployeeJS/updateEmployee.js') }}"></script>
@endsection
