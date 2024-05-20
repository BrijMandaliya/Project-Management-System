@extends('Dashboard.dashboard')


@section('main-panel')
<link rel="stylesheet" href="{{ asset('customcss/TaskHistory.css') }}">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive pt-3">
                <table class="table " id="task-history-table">
                    <thead>
                        <tr>
                            <th>
                                {{ Form::text('s_task_name', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_task_name',
                                    'data-column-id' => '0',
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
                                {{ Form::text('s_employee_name', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_employee_name',
                                    'data-column-id' => '2',
                                ]) }}
                            </th>
                            <th>
                                {{ Form::text('s_task_status', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_task_status',
                                    'data-column-id' => '3',
                                ]) }}
                            </th>
                            <th>
                                {{ Form::text('s_task_on', null, [
                                    'class' => 'searchBar',
                                    'id' => 's_task_on',
                                    'data-column-id' => '4',
                                ]) }}
                            </th>
                        </tr>
                        <tr>
                            <th>Task Name</th>
                            <th>Project Name</th>
                            <th>Employee Name</th>
                            <th>Task Status</th>
                            <th>On</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script src="{{asset("customjs/taskHistoryPage.js")}}"></script>
@endsection
