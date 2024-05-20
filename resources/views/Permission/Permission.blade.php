@extends('Dashboard.dashboard')

@section('right-sidebar')
    <div class="modal fade" id="PermissionModal" tabindex="-1" role="dialog" aria-labelledby="PermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="PermissionModalLabel">Add Permision</h5>
                    <button type="button" class="close PermissionModalCloseBtn" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ml-3">
                        {{ Form::label('InputRoleTitle', 'Permission Title', [
                            'class' => ['col-sm-4', 'col-form-label'],
                            'style' => 'font-size: 17px;',
                        ]) }}
                        <div class="col-sm-6">
                            {{ Form::text('PermissionTitle', '', [
                                'class' => ['form-control'],
                                'placeholder' => 'Enter Permission Title',
                                'id' => 'InputPermissionTitle',
                            ]) }}
                            <span id="errorPermissionTitle" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::button('Close', [
                        'class' => ['btn', 'btn-secondary', 'PermissionModalCloseBtn'],
                    ]) }}
                    {{ Form::button('Add Permission', [
                        'class' => ['btn', 'btn-primary', 'add-permission-btn'],
                        'id' => 'add-permission-btn',
                    ]) }}

                </div>
            </div>
        </div>
    </div>
@endsection

@section('main-panel')
    <div class="row">
        <div class="col-6"><button class="btn btn-info btn-rounded mb-3" id="addPermissionBtn" style="width: 30%;">Add Permission <i
            class="mdi mdi-plus"></i></button></div>

    </div>

    <div class="row">
        <div class="col-md-12">
                <div class="table-responsive pt-3">
                    <table class="table" id="permission-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Permission name</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

        </div>
    </div>
    <script src="{{ asset('customjs/PermissionJS/permissionPage.js') }}"></script>
@endsection
