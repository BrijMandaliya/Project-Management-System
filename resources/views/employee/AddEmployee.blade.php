@extends('Dashboard.dashboard')

@section('main-panel')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Employee</h4>
                <form class="form-sample" id="addEmployeeForm" action="{{route('add-employee')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <p class="card-description">
                        Personal info
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="EmployeeName" class="col-sm-4 col-form-label">Employee Full Name <span class="text-danger">*</span></label>

                                <div class="col-sm-8">

                                    {{ Form::text('EmployeeName', '', [
                                        'class' => 'form-control',
                                        'id' => 'EmployeeName',
                                    ]) }}

                                    <span id="errorEmployeeFullName" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="EmployeeEmail" class="col-sm-4 col-form-label">Email <span class="text-danger">*</span></label>

                                <div class="col-sm-8">

                                    {{ Form::Email('EmployeeEmail', '', [
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
                                <label class="col-sm-4 col-form-label">Gender <span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <div class="form-check form-check-primary">
                                        <label for="MaleGender" class="form-check-label">Male
                                            <input type="radio" name="gender" value="Male" id="MaleGender" class="form-check-input">
                                        </label>
                                    </div>
                                    <div class="form-check form-check-primary">
                                         <label for="FemaleGender" class="form-check-label">Female
                                            <input type="radio" name="gender" value="Female" id="FemaleGender" class="form-check-input">
                                         </label>
                                    </div>
                                    <span id="errorEmployeeGender" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="employeeDOB">Date of Birth <span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    {{
                                        Form::date('employeeDOB',null,['class'=>'form-control','id'=>'employeeDOB'])
                                    }}
                                    <span id="errorEmployeeDOB" class="text-danger"></span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Select Role <span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    {{ Form::select('EmployeeRole',['' => 'Select Employee Role'] + $Roles->pluck('role_title', 'id')->toArray()    , null, ['class' => ['form-select'], 'id' => 'EmployeeRole']) }}
                                    <span id="errorEmployeeRole" class="text-danger"></span>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Phone Number <span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    {{ Form::tel('EmployeePhoneNumber', '', [
                                        'class' => ['form-control'],
                                        'id' => 'EmployeePhoneNumber',
                                    ]) }}
                                    <span id="errorEmployeePhoneNumber" class="text-danger">
                                        @if (Session("DuplicatePhoneNumber"))
                                            {{Session("DuplicatePhoneNumber")}}
                                        @endif
                                        @error('EmployeePhoneNumber')
                                            {{$message}}
                                        @enderror
                                    </span>

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
                                <label class="col-sm-4 col-form-label">Address <span class="text-danger">*</span></label>
                                <div class="col-sm-8">

                                    {{ Form::textarea('EmployeeAddress', '', [
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
                                <label class="col-sm-4 col-form-label">Country <span class="text-danger">*</span></label>
                                <div class="col-sm-8">
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
                                        null,
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
                                <label class="col-sm-4 col-form-label">Your Profile Photo</label>
                                <div class="col-sm-8">
                                    {{ Form::file('emp_profile_photo', [
                                        'class' => 'form-control file-upload-info',
                                        'id' => 'emp_profile_photo',
                                        'accept' => '.jpeg,.png,.jpg',
                                    ]) }}
                                    <span id="errorEmployeeProfilePhoto" class="text-danger"></span>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="float-right mt-3">
                        <button type="Button" class="btn btn-primary mr-2" id="addEmployeeBtn">Add</button>
                        <a type="Button" href="javascript:history.go(-1)" class="btn btn-light">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="{{asset("customjs/validation.js")}}"></script>
    <script src="{{ asset('customjs/EmployeeJS/addEmployee.js') }}"></script>
@endsection
