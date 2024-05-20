@extends('Dashboard.dashboard')

<?php
use Carbon\Carbon;
?>


@section('right-sidebar')
    <div class="offcanvas offcanvas-end" style="margin-top: 75px;width:55%;" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="Task-offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Add Task</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="taskaddorupdate" id="taskaddorupdate">
                {{ Form::open(['method' => 'POST', 'id' => 'addtaskform', 'url' => route('add-task'), 'enctype' => 'multipart/form-data']) }}
                <div class="form-group row ml-3">
                    {{ Form::label('InputTaskTitle', 'Task Title', [
                        'class' => ['col-sm-3', 'col-form-label'],
                        'style' => 'font-size: 17px;',
                    ]) }}
                    <div class="col-sm-8">
                        {{ Form::Text('TaskTitle', '', [
                            'id' => 'InputTaskTitle',
                            'class' => ['form-control'],
                            'placeholder' => 'Enter Task Title',
                        ]) }}
                        <span id="errorTaskTitle" class="text-danger">
                            @error('TaskTitle')
                                TaskTitle is Required
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group row ml-3">
                    {{ Form::label('InputTaskDescription', 'Task Title', [
                        'class' => ['col-sm-3', 'col-form-label'],
                        'style' => 'font-size: 17px;',
                    ]) }}
                    <div class="col-sm-8">
                        {{ Form::TextArea('TaskDescription', '', [
                            'id' => 'InputTaskDescription',
                            'class' => ['form-control'],
                            'rows' => '6',
                            'placeholder' => 'Enter Task Description',
                        ]) }}
                        <span id="errorTaskDescription" class="text-danger">
                            @error('TaskDescription')
                                TaskDescription is Required
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group row ml-3">
                    {{ Form::label('SelectProject', 'Select Project', [
                        'class' => ['col-sm-3', 'col-form-label'],
                        'style' => 'font-size: 17px;',
                    ]) }}
                    <div class="col-sm-8">
                        {{ Form::select(
                            'SelectProject',
                            ['' => 'Select Project'] + $projects->pluck('project_name', 'id')->toArray(),
                            null,
                            [
                                'class' => ['js-example-basic-single', 'w-100'],
                                'id' => 'SelectProject',
                            ],
                        ) }}
                        <span id="errorTaskProject" class="text-danger">
                            @error('SelectProject')
                                Project Selection is Required
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group row ml-3">
                    {{ Form::label('SelectEmployee', 'Select Employee', [
                        'class' => ['col-sm-3', 'col-form-label'],
                        'style' => 'font-size: 17px;',
                    ]) }}
                    <div class="col-sm-8">
                        {{ Form::select('SelectEmployee[]', [], null, [
                            'class' => ['js-example-basic-multiple', 'w-100'],
                            'multiple' => 'multiple',
                            'id' => 'SelectEmployee',
                        ]) }}
                        <span id="errorTaskEmployee" class="text-danger">
                            @error('SelectEmployee')
                                Employee Selection is Required
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group row ml-3">
                    {{ Form::label('SelectTaskType', 'Select Task Type', [
                        'class' => ['col-sm-3', 'col-form-label'],
                        'style' => 'font-size: 17px;',
                    ]) }}
                    <div class="col-sm-8">
                        {{ Form::select(
                            'SelectTaskType',
                            [
                                '' => 'Select Task Type',
                                'Error' => 'Error',
                                'Implement' => 'Implement',
                                'Changes' => 'Changes',
                            ],
                            null,
                            [
                                'class' => ['js-example-basic-single', 'w-100'],
                                'id' => 'SelectTaskType',
                            ],
                        ) }}
                        <span id="errorTaskType" class="text-danger">
                            @error('SelectTaskType')
                                TaskType is Incorrect
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group row ml-3">
                    {{ Form::label('Select Task DeadLine', 'Select DeadLine', [
                        'class' => ['col-sm-3', 'col-form-label'],
                        'style' => 'font-size: 17px;',
                    ]) }}

                    <div class="col-sm-8">
                        {{ Form::date('TaskDeadLine', '', [
                            'class' => 'form-control',
                            'id' => 'TaskDeadLine',
                            'min' => Carbon::now()->format('Y-m-d'),
                        ]) }}
                        <span id="errorTaskDeadLine" class="text-danger">
                            @if (Session('TaskDeadLine'))
                                {{ Session('TaskDeadLine') }}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="form-group row ml-3">
                    {{ Form::label('TaskImages', 'Task Images', [
                        'class' => ['col-sm-3', 'col-form-label'],
                        'style' => 'font-size: 17px;',
                    ]) }}

                    <div class="col-sm-8">
                        {{ Form::file('TaskImages[]', [
                            'class' => 'form-control',
                            'id' => 'TaskImages',
                            'multiple' => 'true',
                            'accept' => '.jpg, .jpeg, .png',
                        ]) }}
                        <span id="errorTaskImages" class="text-danger"></span>
                    </div>
                </div>

                <div class="form-group row ml-3 task-images-for-update">

                </div>
                {{ Form::hidden('TaskMaxDeadLine', '', ['id' => 'TaskMaxDeadLine']) }}
                {{ Form::close() }}
            </div>
            <div class="taskdetails d-none" id="taskdetails">
                <div class="form-group row ml-2">
                    <div class="col-8">
                        {{ Form::label('Task Description', '', [
                            'class' => ['col-sm-8', 'col-form-label'],
                            'style' => 'font-size: 20px;',
                        ]) }}
                        {{ Form::label('DetailTaskDescrption', '', [
                            'class' => ['col-sm-12', 'col-form-label'],
                            'style' => 'font-size: 15px;height:auto;',
                            'id' => 'DetailTaskDescrption',
                        ]) }}
                    </div>
                    <div class="col-4">
                        {{ Form::label('SelectTaskStatus', 'Task Status', [
                            'class' => 'text-dark',
                            'style' => 'font-size:17px',
                            'id' => 'TaskStatusLabel',
                        ]) }}
                        {{ Form::select('SelectTaskStatus', [], null, [
                            'class' => 'form-select',
                            'id' => 'SelectTaskStatus',
                        ]) }}
                    </div>
                </div>
                <div class="form-group row ml-3">
                    {{ Form::label('Task Images', '', [
                        'class' => ['col-sm-4', 'col-form-label'],
                        'style' => 'font-size: 20px;',
                    ]) }}
                </div>
                <div class="form-group row ml-3 task-images">

                </div>
            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="float-right mr-3 mb-5">
                <button type="submit" class="btn btn-primary mr-2 add-task-btn" id="add-task-btn">Add Task</button>
                <button class="btn btn-light btncancel" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
@endsection

@section('main-panel')
    <link rel="stylesheet" href="{{ asset('customcss/Task.css') }}">

    @if (Session::has('admin') || strpos(Session('Employee')->permissions, 'Add Task') !== false)
        <div class="row">
            <div class="col-6">
                <button class="btn btn-info btn-rounded mb-3" id="addtaskbtn" style="width: 30%;" data-bs-toggle="offcanvas"
                    data-bs-target="#Task-offcanvasScrolling" aria-controls="offcanvasScrolling">Add Task <i
                        class="mdi mdi-plus"></i></button>
            </div>
        </div>
    @endif

    @if (Session('TaskDeadLine'))
        <script>
            $("#Task-offcanvasScrolling").addClass("show");
            $("#Task-offcanvasScrolling").css("visibility", "visible");
        </script>
    @endif

    @if (Session('AddTaskSuccess'))
        <script>
            new Notify({
                status: "success",
                title: "Added!",
                text: {!! json_encode(Session('AddTaskSuccess')) !!},
                effect: "fade",
                speed: 300,
                customClass: "",
                customIcon: "",
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 2000,
                notificationsGap: null,
                notificationsPadding: null,
                type: "outline",
                position: "top right",
                customWrapper: "",
            });
        </script>
    @endif

    @if (Session('UpdateTaskSuccess'))
        <script>
            new Notify({
                status: "success",
                title: "Updated!",
                text: {!! json_encode(Session('UpdateTaskSuccess')) !!},
                effect: "fade",
                speed: 300,
                customClass: "",
                customIcon: "",
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 2000,
                notificationsGap: null,
                notificationsPadding: null,
                type: "outline",
                position: "top right",
                customWrapper: "",
            });
        </script>
    @endif



    @if (Session('ImageFormat'))
        <script>
            alert("Image Error" + {!! json_encode(Session('ImageFormat')) !!});
        </script>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive pt-3">
                <table class="table searchBarTable">
                    <thead>

                    </thead>
                </table>
                <table class="table" id="task-table">
                    <thead>
                        <tr>
                            <th class="ml-5"></th>
                            <th>
                                {{ Form::text('s_task_ID', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_task_ID',
                                    'data-column-id' => '1',
                                ]) }}
                            </th>
                            <th>
                                {{ Form::text('s_task_title', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_task_title',
                                    'data-column-id' => '2',
                                ]) }}
                            </th>
                            <th>
                                {{ Form::text('s_projet_name', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_project_name',
                                    'data-column-id' => '3',
                                ]) }}
                            </th>
                            <th>
                                {{ Form::text('s_task_type', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_task_type',
                                    'data-column-id' => '4',
                                ]) }}
                            </th>
                            <th>
                                {{ Form::text('s_task_posted_by', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_task_posted_by',
                                    'data-column-id' => '5',
                                ]) }}
                            </th>
                            <th></th>
                            <th>
                                {{ Form::date('s_task_deadline', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_task_deadline',
                                    'data-column-id' => '7',
                                ]) }}
                                <a class="btn d-none" id="cleartaskdeadline" style="margin-left: -15px;"><i class="typcn typcn-delete-outline btn-icon-append"></i></a>
                            </th>
                            <th>
                                {{ Form::text('s_task_status', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_task_status',
                                    'data-column-id' => '8',
                                ]) }}
                            </th>
                        </tr>
                        <tr>
                            <th class="ml-5">Action</th>
                            <th>Task ID</th>
                            <th>Task Title</th>
                            <th>Project Name</th>
                            <th>Task Type</th>
                            <th>Task Posted By</th>
                            <th>Task Assign To</th>
                            <th>Task DeadLine</th>
                            <th>Task Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    @push('scripts')
        {!! $dataTable->scripts() !!}
    @endpush

    <script>
        function setDeadLine(deadline) {
            console.log("")
            $("#TaskDeadLine").attr("max", deadline);
        }
        var baseUrl = "{{ asset('TaskImages/') }}";
        var Emp = {!! json_encode(Session::get('Employee')) !!};
        var admin = {!! json_encode(Session::get('admin')) !!};
    </script>

    <script src="{{ asset('customjs/taskPage.js') }}"></script>
@endsection
