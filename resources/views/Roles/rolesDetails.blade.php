@extends('Dashboard.dashboard')

@section('right-sidebar')
    <div class="offcanvas offcanvas-end" style="margin-top: 75px;width:37%;" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="Role-offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Add Role</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body ">
            <div class="form-group row ml-3">
                {{ Form::label('InputRoleTitle', 'Role Title', [
                    'class' => ['col-sm-5', 'col-form-label'],
                    'style' => 'font-size: 17px;',
                ]) }}
                <div class="col-sm-6">
                    {{ Form::Text('RoleTitle', '', [
                        'id' => 'InputRoleTitle',
                        'class' => ['form-control'],
                        'placeholder' => 'Enter Role Title',
                    ]) }}

                    <span id="errorRoleTitle" class="text-danger"></span>
                </div>
            </div>
            <div class="form-group row ml-3">
                {{ Form::label('SelectPermissions', 'Select Permissions', [
                    'class' => ['col-sm-5', 'col-form-label'],
                    'style' => 'font-size: 17px;',
                ]) }}
                <div class="col-sm-6">
                    <div class="form-group">
                        {{ Form::select('permissions', $permissionData->pluck('permission_title', 'id'), null, [
                            'class' => ['js-example-basic-multiple', 'w-100'],
                            'multiple' => 'multiple',
                            'id' => 'SelectPermissions',
                        ]) }}
                        <span id="errorRolePermissions" class="text-danger"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="float-right mr-3 mb-5">
                <button type="submit" class="btn btn-primary mr-2 add-roles-btn" id="add-roles-btn">Add Role</button>
                <button class="btn btn-light btncancel" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                {{-- <button type="button" class="btn btn-secondary RoleModalCloseBtn">Close</button>
                <button type="button" id="add-roles-btn" class="btn btn-primary add-roles-btn">Add Role</button> --}}
            </div>
        </div>
    </div>
@endsection

@section('main-panel')
    <div class="row">
        <div class="col-6">
            <button class="btn btn-info btn-rounded mb-3 addRoleBtn" style="width: 30%;" data-bs-toggle="offcanvas"
                data-bs-target="#Role-offcanvasScrolling" aria-controls="Role-offcanvasScrolling">Add
                Roles <i class="mdi mdi-plus"></i></button>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">


            <div class="table-responsive pt-3">
                <table class="table" id="roles-table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Role Title</th>
                            <th>Permissions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

                {{-- {!! $dataTable->table() !!} --}}
            </div>

        </div>
    </div>

    @push('scripts')
        {!! $dataTable->scripts() !!}
    @endpush

    <script src="{{ asset('customjs/roles.js') }}"></script>
@endsection
