<!DOCTYPE html>
<html lang="en">
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('customcss/EmployeeSideCss/Login&Register.css') }}">

    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>

    <link rel="stylesheet" href="{{asset('simple-notify/dist/simple-notify.css')}}">
    <script src="{{asset('simple-notify/dist/simple-notify.min.js')}}"></script>
</head>

<body
    style="background-image: url({{ asset('EmployeeSideImages/loginBackground.jpg') }}); background-repeat: no-repeat;background-size:cover;">

    @if(Session::has("createNewPassword"))
        <script>
            $(document).ready(function() {
                let email = {!!  json_encode(Session::get("createNewPassword")) !!};
                console.log("Check")
                $("#NewPasswordModal").modal("show");
                $("#employee_email").val(email);
            })
        </script>
    @endif
    @if(Session::has("InvalidCredentials"))
        <script>
            new Notify({
                        status: "error",
                        title: "Invalid Credentials!",
                        text: {!! json_encode(Session::get("InvalidCredentials")) !!},
                        effect: "fade",
                        speed: 300,
                        customClass: "",
                        customIcon: "",
                        showIcon: true,
                        showCloseButton: true,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: "outline",
                        position: "top right",
                        customWrapper: "",
                    });
        </script>
    @endif

    <div class="modal fade" id="NewPasswordModal" tabindex="-1" role="dialog" aria-labelledby="NewPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="NewPasswordModalLabel">Update Password</h5>
                    <button type="button" class="close NewPasswordModalCloseBtn" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ml-5 mb-5">
                        {{ Form::label('OldPassword', 'Enter Old Password', [
                            'class' => ['col-sm-4', 'col-form-label'],
                            'style' => 'font-size: 17px;',
                        ]) }}
                        <div class="col-sm-6">
                            {{ Form::text('PermissionTitle', '', [
                                'class' => ['form-control'],
                                'placeholder' => 'Enter Old Password',
                                'id' => 'OldPassword',
                            ]) }}
                            <span id="errorOldPassword" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row ml-5 mb-5">
                        {{ Form::label('NewPassword', 'Enter new Password', [
                            'class' => ['col-sm-4', 'col-form-label'],
                            'style' => 'font-size: 17px;',
                        ]) }}
                        <div class="col-sm-6">
                            {{ Form::password('NewPassword', [
                                'class' => ['form-control'],
                                'placeholder' => 'Enter New Password',
                                'id' => 'NewPassword',
                                'autocomplete' => 'new-password',
                            ]) }}
                            <span id="errorNewPassword" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row ml-5 mb-5">
                        {{ Form::label('ConfirmPassword', 'Enter Confirm Password', [
                            'class' => ['col-sm-4', 'col-form-label'],
                            'style' => 'font-size: 17px;',
                        ]) }}
                        <div class="col-sm-6">
                            {{ Form::password('ConfirmPassword', [
                                'class' => ['form-control'],
                                'placeholder' => 'Enter Confirm Password',
                                'id' => 'ConfirmPassword',
                                'autocomplete' => 'new-confirm-password',
                            ]) }}
                            <span id="errorConfirmPassword" class="text-danger"></span>
                        </div>
                    </div>
                    {{
                        Form::hidden("employee_email",'',[
                            'id' => 'employee_email',
                        ]);
                    }}
                </div>
                <div class="modal-footer">
                    {{ Form::button('Close', [
                        'class' => ['btn', 'btn-secondary', 'NewPasswordModalCloseBtn'],
                    ]) }}
                    {{ Form::button('Update Password', [
                        'class' => ['btn', 'btn-primary', 'update-password-btn'],
                        'id' => 'Update-Password-btn',
                    ]) }}

                </div>
            </div>
        </div>
    </div>

    <div class="login-reg-panel">
        <div class="login-info-box">
            <h2>Remember Password?</h2>
            <label id="label-register" for="log-reg-show">Login</label>
            <input type="radio" name="active-log-panel" id="log-reg-show" checked="checked">
        </div>

        <div class="register-info-box">
            <h2>Forget Password?</h2>
            <label id="label-login" for="log-login-show">Click Here</label>
            <input type="radio" name="active-log-panel" id="log-login-show">
        </div>

        <div class="white-panel">
            <form id="login-form" method="POST" action="{{ route('login-check') }}">
                @csrf
                <div class="login-show">
                    <h2>LOGIN</h2>
                    <div class="form-floating mb-3 mt-5">
                        <input type="email" class="form-control" id="floatingInputEmail" name="EmployeeEmail"
                            placeholder="name@example.com" autocomplete="off">
                        <label for="floatingInputEmail">Email address</label>
                    </div>
                    <span id="errorEmail" class="text-danger"></span>
                    <div class="form-floating">
                        <input type="password" class="form-control" name="EmployeePassword" id="floatingInputPassword"
                            placeholder="Password" autocomplete="new-password">
                        <label for="floatingInputPassword">Password</label>
                    </div>
                    <span id="errorPassword" class="text-danger"></span>
                    <input class="btn btn-info btn-rounded" id="login-btn" type="button" value="Login">
                </div>
            </form>
            <form id="reset-password-form" action="">
                <div class="register-show">
                    <h2>Forget Password</h2>
                    <div class="form-floating mb-3 mt-5">
                        <input type="email" class="form-control" id="floatingInputResetPaswordEmail"
                            placeholder="Enter Email" autocomplete="off">
                        <label for="floatingInputResetPaswordEmail">Email address</label>
                    </div>
                    <span id="errorResetPaswordEmail" class="text-danger"></span>

                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingResetPasswordCompanyName"
                            placeholder="Company Name" autocomplete="new-company-name">
                        <label for="floatingResetPasswordCompanyName">Company Name</label>
                    </div>
                    <span id="errorCompanyName" class="text-danger"></span>

                    <input class="btn btn-info btn-rounded" type="button" id="reset-password-btn"
                        value="Reset Password">
                </div>
            </form>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


    <script src="{{ asset('customjs/validation.js') }}"></script>
    <script src="{{ asset('customjs/EmployeeSideJS/Login&Register.js') }}"></script>
</body>

</html>
