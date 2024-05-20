<?php use Carbon\Carbon; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DashBoard</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('adminassets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('adminassets/vendors/css/vendor.bundle.base.css') }}">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- endinject -->

    {{-- DataTable Link --}}
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.3/datatables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('adminassets/vendors/mdi/css/materialdesignicons.min.css') }}">

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('adminassets/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('adminassets/images/favicon.png') }}" />

    {{-- Boostrap CSS --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    {{-- jQuery --}}
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>

    {{-- DATATABLE jQuery --}}
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.3/datatables.min.js"></script>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.all.min.js"></script>


    {{-- simply-notify --}}
    <!-- CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.4/dist/simple-notify.css" /> --}}
    <link rel="stylesheet" href="{{ asset('simple-notify/dist/simple-notify.css') }}">

    <!-- JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.4/dist/simple-notify.min.js"></script> --}}
    <script src="{{ asset('simple-notify/dist/simple-notify.min.js') }}"></script>



</head>

<body class="sidebar-icon-only">

    @if (Session('LoginSuccess'))
        <script>
            new Notify({
                status: "success",
                title: "Login",
                text: {!! json_encode(Session('LoginSuccess')) !!},
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

    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                    <a class="navbar-brand brand-logo" style="font-size: 15px;color:white;" href="/dashboard">Project
                        Management</a>
                    {{-- <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg"
                            alt="logo" /></a> --}}
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="typcn typcn-th-menu"></span>
                    </button>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-profile">{{Session::has("admin")?Session::get("admin")->companyname:Session::get("Employee")->users->companyname}}</li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-date dropdown">
                        <a class="nav-link d-flex justify-content-center align-items-center" href="javascript:;">
                            <h6 class="date mb-0">Today : {{ Carbon::now()->format('M-d') }}</h6>
                            <i class="mdi mdi-calendar"></i>
                        </a>
                    </li>
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                            id="messageDropdown" href="#" data-toggle="dropdown">
                            <i class="typcn typcn-cog-outline mx-0"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="messageDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                                    </h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        The meeting is cancelled
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                                    </h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        New product launch
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                                    </h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        Upcoming board meeting
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li> --}}
                    <li class="nav-item dropdown mr-0">
                        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
                            id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="typcn typcn-bell"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="typcn typcn-info mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Application Error</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Just now
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-warning">
                                        <i class="typcn typcn-cog-outline mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Settings</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Private message
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-info">
                                        <i class="typcn typcn-user mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        2 days ago
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-0">
                        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
                            id="notificationDropdown" href="#" data-toggle="dropdown" style="width: 200px;">
                            @if (Session::has('Employee'))
                                <img src="{{ asset('EmployeeProfilePhoto/' . Session::get('Employee')->emp_profile_image) }}"
                                    width="20px" height="20px" alt="" srcset="">
                                <label class="text text-dark ml-2 mt-2"> {{ Session::get('Employee')->emp_name }}
                                </label>
                            @endif
                            @if (Session::has('admin'))
                                <img src="{{ asset('EmployeeProfilePhoto/DefaultEmployeeProfilePhoto.png') }}"
                                    width="20px" height="20px" alt="" srcset="">
                                <label class="text text-dark ml-2 mt-2"> {{ Session::get('admin')->username }}
                                </label>
                            @endif

                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="notificationDropdown">

                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-warning">
                                        <i class="typcn typcn-cog-outline mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Profile Settings</h6>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item" href="{{Session("admin")?"/admin/login":""}}{{Session("Employee")?"/employeeLogout":""}}">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-info">
                                        <i class="mdi mdi-logout mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Logout</h6>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="typcn typcn-th-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        {{-- <nav class="navbar-breadcrumb col-xl-12 col-12 d-flex flex-row p-0">
            <div class="navbar-links-wrapper d-flex align-items-stretch">
                <div class="nav-link">
                    <a href="javascript:;"><i class="typcn typcn-calendar-outline"></i></a>
                </div>
                <div class="nav-link">
                    <a href="javascript:;"><i class="typcn typcn-mail"></i></a>
                </div>
                <div class="nav-link">
                    <a href="javascript:;"><i class="typcn typcn-folder"></i></a>
                </div>
                <div class="nav-link">
                    <a href="javascript:;"><i class="typcn typcn-document-text"></i></a>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item ml-0">
                        <h4 class="mb-0">Dashboard</h4>
                    </li>
                    <li class="nav-item">
                        <div class="d-flex align-items-baseline">
                            <p class="mb-0">Home</p>
                            <i class="typcn typcn-chevron-right"></i>
                            <p class="mb-0">Main Dahboard</p>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-search d-none d-md-block mr-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." aria-label="search"
                                aria-describedby="search">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="search">
                                    <i class="typcn typcn-zoom"></i>
                                </span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav> --}}
        <div class="container-fluid page-body-wrapper">

            @yield('right-sidebar')

            <nav class="sidebar sidebar-offcanvas ml-0" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ Session::has('Employee') ? '/dashboard' : '/admin/dashboard' }}"
                            id="dashboard">
                            <i class="typcn typcn-device-desktop menu-icon"></i>
                            <span class="menu-title">Dashboard</span>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/Projects" id="Project">
                            <i class="mdi mdi-parking menu-icon"></i>
                            <span class="menu-title">Project</span>
                        </a>
                    </li>
                    @if (Session("admin") || (strpos(Session('Employee')->permissions, 'View Employee') != false))
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/employees" id="Employee">
                                <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                                <span class="menu-title">Employee</span>
                            </a>
                        </li>
                    @endif
                    @if (Session('admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/roles" id="Roles">
                                <i class="typcn typcn-document-text menu-icon"></i>
                                <span class="menu-title">Roles</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/admin/permission" id="Permission">
                                <i class="mdi mdi-checkbox-marked-outline menu-icon"></i>
                                <span class="menu-title">Permission</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/employeepermission" id="Employee_Permission">
                                <i class="mdi mdi-account-check menu-icon"></i>
                                <span class="menu-title">Employee Permission</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="/Task/taskdetails" id="">
                            <i class="mdi mdi-text-shadow menu-icon"></i>
                            <span class="menu-title">Tasks</span>
                        </a>
                    </li>
                    @if (Session("admin") || (Session("Employee")->employee_role->role_title == 'QA' ||
                            Session("Employee")->employee_role->role_title == 'Project Manager'))
                        <li class="nav-item">
                            <a class="nav-link" href="/Task/taskhistory" id="">
                                <i class="mdi mdi-history menu-icon "></i>
                                <span class="menu-title">Task History</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('main-panel')
                </div>
            </div>

            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
    </div>

    <!-- Plugin js for this page-->
    <script src="{{ asset('adminassets/vendors/chart.js/Chart.min.js') }}"></script>
    <!-- End plugin js for this page-->

    <!-- base:js -->
    <script src="{{ asset('adminassets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ asset('adminassets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('adminassets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('adminassets/js/template.js') }}"></script>
    <script src="{{ asset('adminassets/js/settings.js') }}"></script>
    <script src="{{ asset('adminassets/js/todolist.js') }}"></script>
    {{-- <script src="{{ asset('adminassets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('adminassets/js/select2.js') }}"></script> --}}
    <!-- endinject -->

    <!-- Custom js for this page-->
    <script src="{{ asset('adminassets/js/dashboard.js') }}"></script>
    <!-- End custom js for this page-->


    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script src="https://cdn.datatables.net/v/dt/dt-2.0.3/datatables.min.js"></script>



    <script>
        $(document).ready(function() {
            $(".js-example-basic-multiple").select2({
                width: "100%",
            });
            $(".js-example-basic-single").select2();
        });
    </script>
    </script>
</body>

</html>
