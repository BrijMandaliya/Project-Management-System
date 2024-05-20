@extends('Dashboard.dashboard')



@section('right-sidebar')
@endsection

@section('main-panel')
<link rel="stylesheet" href="{{asset('customcss/EmployeeCSS/Employee.css')}}">
@if (Session("admin") ||strpos(Session('Employee')->permissions, 'Add Employee') !== false)
    <div class="row">
        <div class="col-6">
            <a class="btn btn-info btn-rounded mb-3 float-left" style="width: 30%;" href="/employee/addemployeepage">Add
                Employee <i class="mdi mdi-plus"></i></a>
        </div>
    </div>
@endif
    <div class="row">
        <div class="col-md-12">

                <div class="table-responsive pt-3">
                    <table class="table" id="employee-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    {{ Form::text('s_emp_name', null, [
                                        'class' => 'searchBar',
                                        'id' => 's_emp_name',
                                        'data-column-id' => '1',
                                    ]) }}
                                </th>
                                <th>
                                    {{ Form::text('s_emp_email', null, [
                                        'class' => 'searchBar',
                                        'id' => 's_emp_email',
                                        'data-column-id' => '2',
                                    ]) }}
                                </th>
                                <th>
                                    {{ Form::text('s_emp_code', null, [
                                        'class' => 'searchBar',
                                        'id' => 's_emp_code',
                                        'data-column-id' => '3',
                                    ]) }}
                                </th>
                                <th>
                                    {{ Form::text('s_emp_Role', null, [
                                        'class' => 'searchBar',
                                        'id' => 's_emp_Role',
                                        'data-column-id' => '4',
                                    ]) }}
                                </th>
                                <th>
                                    {{ Form::text('s_emp_Address', null, [
                                        'class' => 'searchBar',
                                        'id' => 's_emp_Address',
                                        'data-column-id' => '5',
                                    ]) }}
                                </th>
                                <th>
                                    {{ Form::text('s_emp_Country', null, [
                                        'class' => 'searchBar',
                                        'id' => 's_emp_Country',
                                        'data-column-id' => '6',
                                    ]) }}
                                </th>
                                <th>
                                    {{ Form::text('s_emp_Gender', null, [
                                        'class' => 'searchBar',
                                        'id' => 's_emp_Gender',
                                        'data-column-id' => '7',
                                    ]) }}
                                </th>
                                <th>
                                    {{ Form::text('s_emp_DOB', null, [
                                        'class' => 'searchBar',
                                        'id' => 's_emp_DOB',
                                        'data-column-id' => '8',
                                    ]) }}
                                </th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <th>Employee name</th>
                                <th>Employee Email</th>
                                <th>Employee Code</th>
                                <th>Employee Role</th>
                                <th>Employee Address</th>
                                <th>Employee Country</th>
                                <th>Employee Gender</th>
                                <th>Employee DOB</th>
                                <th>Employee Image</th>
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
    @if (Session('Employee Add Status'))
        <script>
            new Notify({
                status: 'success',
                title: 'Added!',
                text: 'Employee Added SuccessFully',
                effect: 'fade',
                speed: 300,
                customClass: '',
                customIcon: '',
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 2000,
                notificationsGap: null,
                notificationsPadding: null,
                type: 'outline',
                position: 'right top',
                customWrapper: '',
            })
        </script>
    @endif

    @if (Session('Employee Update Status'))
        <script>
            new Notify({
                status: 'success',
                title: 'Updated!',
                text: 'Employee Update SuccessFully',
                effect: 'fade',
                speed: 300,
                customClass: '',
                customIcon: '',
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 2000,
                notificationsGap: null,
                notificationsPadding: null,
                type: 'outline',
                position: 'right top',
                customWrapper: '',
            })
        </script>
    @endif
    <script>
        var baseUrl = "{{ asset('EmployeeProfilePhoto/') }}";

    </script>
    <script src="{{ asset('customjs/EmployeeJS/employeePage.js') }}"></script>
@endsection
