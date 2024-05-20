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
                            <h4>New here?</h4>
                            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                            <form class="pt-3" action="{{route('regitser-user')}}" id="registerForm" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-ml text-dark"
                                        id="InputName" placeholder="Name" name="Name" required>
                                        <span id="errorName" class="text-danger d-none"></span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-ml text-dark"
                                        id="InputUserName" placeholder="Username" name="username" required>
                                        <span id="errorUserName" class="text-danger d-none"></span>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-ml text-dark" id="InputEmail"
                                        placeholder="Email" name="email" required>
                                        <span id="errorEmail" class="text-danger d-none"></span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-ml text-dark"
                                        id="InputCompanyName" name="companyname" placeholder="Company Name" required>
                                        <span id="errorCompanyName" class="text-danger d-none"></span>

                                </div>
                                <div class="form-group">
                                    <select class="form-control form-control-ml text-dark" id="SelectCountry" name="country" required>
                                        <option disabled selected>Country</option>
                                        <option>United States of America</option>
                                        <option>United Kingdom</option>
                                        <option>India</option>
                                        <option>Germany</option>
                                        <option>Argentina</option>
                                    </select>
                                    <span id="errorCountry" class="text-danger d-none"></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-ml" name="password" id="InputPassword"
                                        placeholder="Password" required>
                                        <span id="errorPassword" class="text-danger d-none"></span>
                                </div>

                                <div class="mb-4">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input" required>
                                            I agree to all Terms & Conditions
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a id="sign-up-btn" class="btn btn-block btn-primary btn-rounded btn-lg font-weight-medium auth-form-btn">SIGN UP</a>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Already have an account? <a href="{{ route('login-page') }}"
                                        class="text-primary">Login</a>
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

    {{-- Custom JS --}}
    <script src="{{ asset('customjs/validation.js')}}"></script>
    <script src="{{ asset('customjs/registerPage.js')}}"></script>

</body>

</html>
