<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('adminassets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('adminassets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('adminassets/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('adminassets/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3" id="loginForm" action="{{ route('login-check-credential') }}"
                                method="POST">
                                @csrf
                                @if(Session("invalid credentials"))
                                    <span class="text-danger">{{Session("invalid credentials")}}</span>
                                @endif
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" id="InputEmail"
                                        name="email" placeholder="Username">
                                    <span id="errorEmail" class="text-danger d-none"></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="InputPassword"
                                        name="password" placeholder="Password">
                                    <span id="errorPassword" class="text-danger d-none"></span>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" id="sign-in-btn"
                                        class="btn btn-block btn-primary btn-rounded btn-lg font-weight-medium auth-form-btn">SIGN
                                        IN</button>
                                </div>
                                <div class="my-4 d-flex justify-content-end align-items-center">
                                    <a href="#" class="auth-link text-black">Forgot password?</a>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Don't have an account? <a href="{{ route('register-page') }}"
                                        class="text-primary">Create</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="{{ asset('adminassets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ asset('adminassets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('adminassets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('adminassets/js/template.js') }}"></script>
    <script src="{{ asset('adminassets/js/settings.js') }}"></script>
    <script src="{{ asset('adminassets/js/todolist.js') }}"></script>
    <!-- endinject -->

    {{-- Custom Js  --}}
    <script src="{{ asset('customjs/validation.js') }}"></script>
    <script src="{{ asset('customjs/loginPage.js') }}"></script>

</body>

</html>
