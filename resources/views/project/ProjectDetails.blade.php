@extends('Dashboard.dashboard')

<?php
use Carbon\Carbon;
?>

@if (Session::has("admin")  ||strpos(Session('Employee')->permissions, 'Create Project') !== false || strpos(Session('Employee')->permissions, 'Update Project') !== false)
    @section('right-sidebar')
        <div class="offcanvas offcanvas-end" style="margin-top: 75px;width:37%;" data-bs-scroll="true" data-bs-backdrop="false"
            tabindex="-1" id="Project-offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Add Project</h5>
                <button type="button" class="btn-close text-reset" id="btn-close" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form class="forms-sample  ml-4 mr-2 mt-2" id="addProjectForm" action="{{ route('add-project') }}"
                    method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="InputProjectName" class="col-sm-5 col-form-label">Project Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('ProjectName', '', [
                                'class' => 'form-control',
                                'id' => 'InputProjectName',
                                'placeholder' => 'Enter Project Name',
                            ]) }}
                            <span id="errorProjectName" class="text-danger">
                                @error('ProjectName')
                                    {{ $errors->first('ProjectName') }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputEmail2" class="col-sm-5 col-form-label">Select Project Start Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('startDate', '', [
                                'class' => 'form-control',
                                'id' => 'InputStartDate',
                                'min' => Carbon::now()->format('Y-m-d'),
                            ]) }}
                            <span id="errorstartDate" class="text-danger">
                                @error('projectStartDate')
                                    {{ $errors->first('projectStartDate') }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputMobile" class="col-sm-5 col-form-label">Select Project Deadline</label>
                        <div class="col-sm-6">

                            {{ Form::date('deadLine', '', [
                                'class' => 'form-control',
                                'id' => 'InputDeadLine',
                                'min' => Carbon::now()->format('Y-m-d'),
                            ]) }}
                            <span id="errordeadLine" class="text-danger">
                                @error('projectDeadLine')
                                    {{ $errors->first('projectDeadLine') }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputMobile" class="col-sm-5 col-form-label">Select Employees</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::select('SelectEmployees', $employees->pluck('emp_name', 'id'), null, [
                                    'class' => 'js-example-basic-multiple w-100',
                                    'multiple' => 'multiple',
                                    'id' => 'SelectEmployees',
                                ]) }}
                                <span id="errorSelectEmployees" class="text-danger">

                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputMobile" class="col-sm-5 col-form-label">Enter Payout</label>
                        <div class="col-sm-6">
                            {{ Form::number('ProjectPayout', null, ['class' => 'form-control', 'id' => 'InputProjectPayout', 'placeholder' => 'Enter Payout']) }}
                            <span id="errorProjectPayout" class="text-danger">
                                @error('ProjectPayout')
                                    {{ $errors->first('ProjectPayout') }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="SelectProjectStatus" class="col-sm-5 col-form-label">Select Project Status</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::select(
                                    'ProjectStatus',
                                    [
                                        '' => 'Select Project Status',
                                        'Listed' => 'Listed',
                                        'In Progress' => 'In Progress',
                                        'On Hold' => 'On Hold',
                                        'Completed' => 'Completed',
                                    ],
                                    null,
                                    ['class' => 'js-example-basic-single w-100', 'id' => 'SelectProjectStatus'],
                                ) }}
                                <span id="errorProjectStatus" class="text-danger">
                                    @error('projectStatus')
                                        {{ $errors->first('projectStatus') }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
            <div class="offcanvas-footer">
                <div class="float-right mr-3 mb-5">
                    <button type="button" class="btn btn-primary mr-2 addProjectBtn" id="addProjectBtn">Add
                        Project</button>
                    <button class="btn btn-light" id="btn-close">Cancel</button>
                </div>
            </div>
        </div>
    @endsection
@endif

@section('main-panel')
    <link rel="stylesheet" href="{{ asset('customcss/Project.css') }}" />
    @if (Session::has("admin") || strpos(Session('Employee')->permissions, 'Create Project') !== false)
        <div class="row">
            <div class="col-6">
                <button class="btn btn-info btn-rounded mb-3" id="add-project-btn" style="width: 30%;"
                    data-bs-toggle="offcanvas" data-bs-target="#Project-offcanvasScrolling"
                    aria-controls="offcanvasScrolling">Add Project <i class="mdi mdi-plus"></i></button>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive pt-3">
                <table class="table " id="project-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>
                                {{ Form::text('s_project_code', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_project_name',
                                    'data-column-id' => '1',
                                ]) }}
                            </th>
                            <th>
                                {{ Form::text('s_project_name', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_project_name',
                                    'data-column-id' => '1',
                                ]) }}
                            </th>
                            <th>
                                {{ Form::text('s_project_startdate', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_project_startdate',
                                    'data-column-id' => '2',
                                ]) }}
                            </th>
                            <th>
                                {{ Form::text('s_project_deadline', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_project_deadline',
                                    'data-column-id' => '3',
                                ]) }}
                            </th>
                            <th>

                            </th>
                            <th>
                                {{ Form::text('s_project_payout', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_project_payout',
                                    'data-column-id' => '5',
                                ]) }}
                            </th>
                            <th>
                                {{ Form::text('s_project_status', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_project_status',
                                    'data-column-id' => '6',
                                ]) }}
                            </th>
                        </tr>
                        <tr>
                            <th class="ml-5">Action</th>
                            <th>Project Code</th>
                            <th>Project name</th>
                            <th>Project Start Date</th>
                            <th>Project Deadline</th>
                            <th>Employees</th>
                            <th>Project Payouts </th>
                            <th>Project Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script src="{{ asset('customjs/projectPage.js') }}"></script>
@endsection
