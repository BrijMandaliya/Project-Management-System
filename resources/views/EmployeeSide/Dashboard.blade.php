@extends('Dashboard.dashboard')


@section('main-panel')
    <div class="row">
        <div class="col-xl-12 grid-margin stretch-card flex-column">
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="mb-0 ">Project</p>
                                <p class="mb-0 text-muted">Total Project :
                                    {{ $Project->count() }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
                                <script>
                                    var _ProjectDataForPieChart = [{{ $Project->where('status', 'Listed')->count() }},
                                        {{ $Project->where('status', 'In Progress')->count() }},
                                        {{ $Project->where('status', 'On Hold')->count() }},
                                        {{ $Project->where('status', 'Completed')->count() }},
                                    ]
                                    var _ProjectLabelsForPieChart = ['Listed', 'In Progress', 'On Hold', 'Complete']
                                </script>
                                <canvas id="ProjectDataPieChart" class="mt-2"></canvas>

                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
                                <div>
                                    <div class="row">
                                        <p class="mb-2 text-muted col">Listed</p>
                                        <div class="col" style="background-color: #f39915;width:2%;height:20px;"></div>
                                    </div>
                                    <h6 class="mb-0">{{ $Project->where('status', 'Listed')->count() }}</h6>
                                </div>
                                <div>
                                    <div class="row">
                                        <p class="mb-2 text-muted col">In Progress</p>
                                        <div class="col" style="background-color: #21bf06;width:2%;height:20px;"></div>
                                    </div>
                                    <h6 class="mb-0">
                                        {{ $Project->where('status', 'In Progress')->count() }}
                                    </h6>
                                </div>
                                <div>
                                    <div class="row">
                                        <p class="mb-2 text-muted col">On Hold</p>
                                        <div class="col" style="background-color: #cada3c ;width:2%;height:20px;"></div>
                                    </div>

                                    <h6 class="mb-0">
                                        {{ $Project->where('status', 'On Hold')->count() }}
                                    </h6>
                                </div>
                                <div>
                                    <div class="row">
                                        <p class="mb-2 text-muted col">Completed</p>
                                        <div class="col" style="background-color: #3cb5da;width:2%;height:20px;"></div>
                                    </div>

                                    <h6 class="mb-0">{{ $Project->where('status', 'Completed')->count() }}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="mb-0">Task</p>
                                <p class="mb-0 text-muted">Total Task {{ $Task->count() }}</p>
                            </div>
                            @php
                                $Task = $Task
                                    ->select(
                                        DB::raw(
                                            "sum(case when task_status = 'Listed' then 1 else 0 end) as task_status_listed",
                                        ),
                                        DB::raw(
                                            "sum(case when task_status = 'In Working' OR task_status = 'On Hold' then 1 else 0 end) as task_status_progress",
                                        ),
                                        DB::raw(
                                            "sum(case when task_status = 'Complete' then 1 else 0 end) as task_status_complete",
                                        ),
                                    )
                                    ->first();
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
                                <canvas id="TaskDataPieChart" class="mt-2"></canvas>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
                                <div>
                                    <div class="row">
                                        <p class="mb-2 text-muted col">Listed</p>
                                        <div class="col" style="background-color: #f39915;width:2%;height:20px;"></div>
                                    </div>
                                    <h6 class="mb-0 text-align-center">{{ $Task->task_status_listed }}
                                    </h6>
                                </div>
                                <div>
                                    <div class="row">
                                        <p class="mb-2 text-muted col">In Proccess</p>
                                        <div class="col" style="background-color: #21bf06;width:2%;height:20px;"></div>
                                    </div>
                                    <h6 class="mb-0">
                                        {{ $Task->task_status_progress }}
                                    </h6>
                                </div>
                                <div>
                                    <div class="row">
                                        <p class="mb-2 text-muted col">Completed</p>
                                        <div class="col" style="background-color: #3cb5da;width:2%;height:20px;"></div>
                                    </div>
                                    <h6 class="mb-0">{{ $Task->task_status_complete }}</h6>
                                </div>
                                <script>
                                    var _TaskDataForPieChart = [{{ $Task->task_status_listed }},
                                        {{ $Task->task_status_progress }},
                                        {{ $Task->task_status_complete }}
                                    ]
                                    var _TaskLabelForPieChart = ['Listed', 'On Hold OR In Working', 'Complete']
                                    console.log(_TaskDataForPieChart);
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h5 class="mb-2 text-titlecase mb-4">Recent Projects</h5>

            <div class="table-responsive pt-3">
                <table class="table table-hover project-table">
                    <thead>
                        <tr>
                            <th class="ml-5">Project Code</th>
                            <th>Project name</th>
                            <th>Project Start Date</th>
                            <th>Project Deadline</th>
                            <th>Project Payouts </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Project->orderBy('created_at', 'desc')->take(3)->get() as $key => $project)
                            <tr>
                                <td>{{ $project->project_code }}</td>
                                <td>{{ $project->project_name }}</td>
                                <td>{{ $project->project_startDate }}</td>
                                <td>{{ $project->project_deadline }}</td>
                                <td>{{ $project->project_payout }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

    </div>
    <script src="{{ asset('customjs/EmployeeSideJS/DashBoard.js') }}"></script>
@endsection

