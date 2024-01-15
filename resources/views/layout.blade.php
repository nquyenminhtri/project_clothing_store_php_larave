@php
    $adminAccount = session('adminAccount');
    $newSaleInvoiceList = session('newSaleInvoiceList');
    $newCustomerList = session('newCustomerList');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clothing Store</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="keywords"
        content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="Codedthemes" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/themify-icons/themify-icons.css') }}">
    <!-- font-awesome-n -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome-n.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <!-- scrollbar.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.mCustomScrollbar.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href=" {{ asset('sweetalert2/sweetalert2.min.css') }}">
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="preloader-wrapper">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                            <i class="ti-menu"></i>
                        </a>
                        <div class="mobile-search waves-effect waves-light">
                            <div class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-prepend search-close"><i
                                                class="ti-close input-group-text"></i></span>
                                        <input type="text" class="form-control" placeholder="Enter Keyword">
                                        <span class="input-group-append search-btn"><i
                                                class="ti-search input-group-text"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="index.html">
                            <img style="margin-left:-15px;height:50px" class="img-fluid"
                                src="{{ asset('logo.png') }}" alt="Theme-Logo" />
                        </a>
                        <a class="mobile-options waves-effect waves-light">
                            <i class="ti-more"></i>
                        </a>
                    </div>
                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()"
                                    class="waves-effect waves-light">
                                    <i class="ti-fullscreen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="header-notification">
                                <a href="#!" class="waves-effect waves-light">
                                    <i class="ti-bell"></i>
                                    <span class="badge bg-c-red"></span>
                                </a>
                                <ul class="show-notification">
                                    <li>
                                        <h6>Notifications</h6>
                                        <label class="label label-danger">New</label>
                                    </li>

                                    @foreach ($newCustomerList as $newCustomer)
                                        <li class="waves-effect waves-light">
                                            <div class="media">
                                                <img style="height:40px" class="d-flex align-self-center img-radius"
                                                    src="{{ asset('assets/images/huytuan.jpg') }}"
                                                    alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="notification-user">{{ $newCustomer->name }}</h5>
                                                    <p class="notification-msg">{{ $newCustomer->phone }}</p>
                                                    <span class="notification-time">{{ $newCustomer->address }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="user-profile header-notification">
                                <a href="#!" class="waves-effect waves-light">
                                    @isset($adminAccount)
                                        <img style="height:40px"
                                            src="{{ asset('admin-images/' . $adminAccount->image) }}" class="img-radius"
                                            alt="User-Profile-Image">

                                        <span>{{ $adminAccount->name }}</span>
                                    @endisset

                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">
                                    <li class="waves-effect waves-light">
                                        <a href="#!">
                                            <i class="ti-settings"></i> Settings
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="user-profile.html">
                                            <i class="ti-user"></i> Profile
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="email-inbox.html">
                                            <i class="ti-email"></i> My Messages
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="auth-lock-screen.html">
                                            <i class="ti-lock"></i> Lock Screen
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="{{ route('admin.logout') }}">
                                            <i class="ti-layout-sidebar-left"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="pcoded-main-container">

                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="">
                                <div class="main-menu-header">
                                    @isset($adminAccount)
                                        <img style='height:60px' class="img-80 img-radius"
                                            src="{{ asset('admin-images/' . $adminAccount->image) }}"
                                            alt="User-Profile-Image">
                                        <div class="user-details">
                                            <span id="more-details">{{ $adminAccount->name }}<i
                                                    class="fa fa-caret-down"></i></span>
                                        @endisset
                                    </div>
                                </div>
                                <div class="main-menu-content">
                                    <ul>
                                        <li class="more-details">
                                            <a href="user-profile.html"><i class="ti-user"></i>View Profile</a>
                                            <a href="#!"><i class="ti-settings"></i>Settings</a>
                                            <a href="{{ route('admin.logout') }}"><i
                                                    class="ti-layout-sidebar-left"></i>Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="p-15 p-b-0">
                                <form class="form-material">
                                    <div class="form-group form-primary">
                                        <input type="text" name="footer-email" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label"><i class="fa fa-search m-r-10"></i>Search
                                            Friend</label>
                                    </div>
                                </form>
                            </div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="fas fa-user"></i></span>
                                        <span class="pcoded-mtext">
                                            Account management</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-hasmenu">
                                            <a href="{{ route('admin.list') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-users"></i>
                                                </span>
                                                <span class="pcoded-mtext">ADMIN</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="pcoded-hasmenu">
                                            <a href="{{ route('customer.list') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-user"></i><b></b></span>
                                                <span class="pcoded-mtext">CUSTOMER</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>

                                        </li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="far fa-file-alt"></i></span>
                                        <span class="pcoded-mtext">
                                            Invoice management</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-hasmenu">
                                            <a href="{{ route('sale-invoice.list') }}"
                                                class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i
                                                        class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                                <span class="pcoded-mtext">SALE INVOICE</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="pcoded-hasmenu">
                                            <a href="{{ route('import-invoice.list') }}"
                                                class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i
                                                        class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                                <span class="pcoded-mtext">IMPORT VOICE</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>

                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="fas fa-cubes"></i></span>
                                        <span class="pcoded-mtext">
                                            Product management</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-hasmenu">
                                            <a href="{{ route('product.list') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-dice-d6"></i></span>
                                                <span class="pcoded-mtext">PRODUCT</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>

                                        </li>
                                        <li class="pcoded-hasmenu">
                                            <a href="{{ route('product-category.list') }}"
                                                class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i
                                                        class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                                <span class="pcoded-mtext">PRODUCT CATEGORY</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="pcoded-hasmenu">
                                            <a href="{{ route('size.list') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i
                                                        class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                                <span class="pcoded-mtext">SIZE</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="pcoded-hasmenu">
                                            <a href="{{ route('color.list') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i
                                                        class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                                <span class="pcoded-mtext">COLOR</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="pcoded-hasmenu">
                                            <a href="{{ route('material.list') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i
                                                        class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                                <span class="pcoded-mtext">MATERIAL</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>

                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="fas fa-percent"></i></span>
                                        <span class="pcoded-mtext">
                                            Promotion management</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i
                                                        class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                                <span class="pcoded-mtext">Promotion</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>

                                        </li>
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i
                                                        class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                                <span class="pcoded-mtext">Promotion code</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>

                                        </li>
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i
                                                        class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                                <span class="pcoded-mtext">Promotion product</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>

                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                    <a href="{{ route('supplier.list') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="fas fa-truck"></i></span>
                                        <span class="pcoded-mtext">Supplier management</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                                </li>
                            </ul>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="fas fa-sliders-h"></i></span>
                                        <span class="pcoded-mtext">Manage sliders</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                                </li>
                            </ul>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                    <a href="" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                        <span class="pcoded-mtext">Comment</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                                </li>
                            </ul>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                        <span class="pcoded-mtext">Favorite product</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                                </li>
                            </ul>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                        <span class="pcoded-mtext">Rating</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                                </li>
                            </ul>

                            <div class="pcoded-navigation-label">Pages</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu ">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-id-badge"></i><b>A</b></span>
                                        <span class="pcoded-mtext">Pages</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="auth-normal-sign-in.html" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext">Login</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="auth-sign-up.html" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext">Registration</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="sample-page.html" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i
                                                        class="ti-layout-sidebar-left"></i><b>S</b></span>
                                                <span class="pcoded-mtext">Sample Page</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Dashboard</h5>
                                            <p class="m-b-0">Welcome to Material Able</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('layout') }}"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="{{ route('layout') }}">Dashboard</a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="{{ route('layout') }}">Dashboard</a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="{{ route('layout') }}">Dashboard</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">

                                <div class="page-wrapper">

                                    <!-- Page-body start -->
                                    <div class="page-body">

                                        @php
                                            $showCardContent = !isset($hideCardContent) || !$hideCardContent;
                                        @endphp

                                        @if ($showCardContent)
                                            <div class="row">
                                                <div class="col-xl-6 col-md-12">
                                                    <div class="card table-card">
                                                        <div class="card-header">
                                                            <h5>Order awaiting confirmation</h5>
                                                            <div class="card-header-right">
                                                                <ul class="list-unstyled card-option">
                                                                    <li><i
                                                                            class="fa fa fa-wrench open-card-option"></i>
                                                                    </li>
                                                                    <li><i class="fa fa-window-maximize full-card"></i>
                                                                    </li>
                                                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                                                    <li><i class="fa fa-trash close-card"></i></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card-block">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover m-b-0 without-header">
                                                                    <tbody>
                                                                        @foreach ($newSaleInvoiceList as $newSaleInvoice)
                                                                            <tr style="width:100%">
                                                                                <td>
                                                                                    <div
                                                                                        class="d-inline-block align-middle">
                                                                                        <img src="assets/images/avatar-4.jpg"
                                                                                            alt="user image"
                                                                                            class="img-radius img-40 align-top m-r-15">
                                                                                        <div class="d-inline-block">
                                                                                            <h6>{{ $newSaleInvoice->saleInvoiceCustomer->name }}
                                                                                            </h6>

                                                                                            <p
                                                                                                class="text-muted m-b-0">
                                                                                                {{ $newSaleInvoice->export_date }}
                                                                                            </p>
                                                                                        </div>
                                                                                        <div>
                                                                                            @if ($newSaleInvoice->status === 'unconfimred')
                                                                                                <div
                                                                                                    class="label-main">
                                                                                                    <label
                                                                                                        class="label label-warning">{{ $newSaleInvoice->status }}</label>
                                                                                                </div>
                                                                                            @elseif($newSaleInvoice->status === 'delivering')
                                                                                                <div
                                                                                                    class="label-main">
                                                                                                    <label
                                                                                                        class="label label-success">{{ $newSaleInvoice->status }}</label>
                                                                                                </div>
                                                                                            @elseif($newSaleInvoice->status === 'successed')
                                                                                                <div
                                                                                                    class="label-main">
                                                                                                    <label
                                                                                                        class="label label-primary">{{ $newSaleInvoice->status }}</label>
                                                                                                </div>
                                                                                            @else
                                                                                                <div
                                                                                                    class="label-main">
                                                                                                    <label
                                                                                                        class="label label-danger">{{ $newSaleInvoice->status }}</label>
                                                                                                </div>
                                                                                            @endif
                                                                                        </div>

                                                                                    </div>

                                                                                </td>
                                                                                <td>
                                                                                    <div>
                                                                                        <p>
                                                                                            Sản phẩm 1
                                                                                        </p>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-right">
                                                                                    <h6>
                                                                                        {{ $newSaleInvoice->total_amount }}vnđ
                                                                                    </h6>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-12">
                                                    <div style="margin-bottom:4%" class="row">

                                                        <div style="width:40%;" class="col-md-6">

                                                            <label class="label label-inverse-primary">
                                                                Start date:</label>

                                                            <input type="date" id="startDate" name="startDate"
                                                                class="form-control">
                                                        </div>
                                                        <div style="width:40%;" class="col-md-6">

                                                            <label class="label label-inverse-primary">End
                                                                date:</label>

                                                            <input type="date" id="endDate" name="endDate"
                                                                class="form-control">
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <!-- sale card start -->

                                                        <div class="col-md-6">
                                                            <div class="card text-center order-visitor-card">
                                                                <div class="card-block">
                                                                    <h6 class="m-b-0">Total revenue</h6>
                                                                    <h4 id="total_revenue" class="m-t-15 m-b-15">0$<i
                                                                            class="fa fa-arrow-down m-r-15 text-c-red"></i>
                                                                    </h4>
                                                                    <p class="m-b-0">48% From Last 24 Hours</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card text-center order-visitor-card">
                                                                <div class="card-block">
                                                                    <h6 class="m-b-0">Order successed</h6>
                                                                    <h4 id="saleInvoiceSuccessed"
                                                                        class="m-t-15 m-b-15"><i
                                                                            class="fa fa-arrow-up m-r-15 text-c-green"></i>0
                                                                    </h4>
                                                                    <p class="m-b-0">36% From Last 6 Months</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card bg-c-red total-card">
                                                                <div class="card-block">
                                                                    <div class="text-left">
                                                                        <h4 id="saleInvoiceCancelled">0</h4>
                                                                        <p class="m-0">Order was cancelled</p>
                                                                    </div>
                                                                    <span
                                                                        class="label bg-c-red value-badges">15%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card bg-c-green total-card">
                                                                <div class="card-block">
                                                                    <div class="text-left">
                                                                        <h4 id="customerCreatedByDate">0</h4>
                                                                        <p class="m-0">New customer</p>
                                                                    </div>
                                                                    <span class="label bg-c-green value-badges"
                                                                        id="newCustomerPercentage">0%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card text-center order-visitor-card">
                                                                <div class="card-block">
                                                                    <h6 class="m-b-0">Net profit</h6>
                                                                    <h4 id="netProfit" class="m-t-15 m-b-15"><i
                                                                            class="fa fa-arrow-down m-r-15 text-c-red"></i>
                                                                    </h4>VNĐ
                                                                    <p class="m-b-0">48% From Last 24 Hours</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-md-6">
                                                            <div class="card text-center order-visitor-card">
                                                                <div class="card-block">
                                                                    <h6 class="m-b-0">Unique Visitors</h6>
                                                                    <h4 class="m-t-15 m-b-15"><i
                                                                            class="fa fa-arrow-down m-r-15 text-c-red"></i>652
                                                                    </h4>
                                                                    <p class="m-b-0">36% From Last 6 Months</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card text-center order-visitor-card">
                                                                <div class="card-block">
                                                                    <h6 class="m-b-0">Monthly Earnings</h6>
                                                                    <h4 id="saleInvoiceCanCelled"
                                                                        class="m-t-15 m-b-15"><i
                                                                            class="fa fa-arrow-up m-r-15 text-c-green"></i>5963
                                                                    </h4>
                                                                    <p class="m-b-0">36% From Last 6 Months</p>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <!-- sale card end -->
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                        @yield('content')
                                    </div>
                                    <!-- Page-body end -->
                                </div>
                                <div id="styleSelector"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.min.js ') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js') }} "></script>
    <script type="text/javascript" src="{{ asset('assets/js/popper.js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap/js/bootstrap.min.js') }} "></script>
    <!-- waves js -->
    <script src="{{ asset('assets/pages/waves/js/waves.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- slimscroll js -->
    <script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }} "></script>
    <!-- menu js -->
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('assets/js/vertical/vertical-layout.min.js ') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/script.js') }} "></script>
    <script src="{{ asset('sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('chart.js/dist/chart.umd.js') }}"></script>
    <!-- Liên kết CSS của Spectrum Color Picker -->
    <link rel="stylesheet" type="text/css" href={{ asset('spectrum/spectrum.css') }}>

    <!-- Liên kết JS của Spectrum Color Picker -->
    <script src={{ asset('spectrum/spectrum.js') }}></script>

</body>
@yield('page-js')
@if (session('status'))
    <script>
        Swal.fire("{{ session('status') }}");
    </script>
@endif

</html>
<script>
    // get value when reload page
    $(window).on('load', function() {
        // get today
        var today = new Date();
        // formatt date to yyyy-MM-dd 
        var formattedDate = today.toISOString().slice(0, 10);

        // Kiểm tra xem phần tử có tồn tại không trước khi gán giá trị
        var startDateElement = document.getElementById('startDate');
        var endDateElement = document.getElementById('endDate');

        if (startDateElement) {
            startDateElement.value = '2020-01-01';
        }

        if (endDateElement) {
            endDateElement.value = formattedDate;
        }

        // Lấy giá trị của ngày được chọn sau khi trang đã được load lại
        var startDateValue = $("#startDate").val();
        var endDateValue = $("#endDate").val();

        applyFilter(startDateValue, endDateValue);
    });
    $(document).ready(function() {
        $('#startDate,#endDate').on('input', function() {
            // get value selected
            var startDateValue = $("#startDate").val();
            var endDateValue = $("#endDate").val();
            console.log('check date', startDateValue, endDateValue);
            applyFilter(startDateValue, endDateValue);
        });
    });

    function applyFilter(startDateValue, endDateValue) {
        $.ajax({
            type: 'GET',
            url: '{{ route('sale-invoice.filter') }}',
            data: {
                startDate: startDateValue,
                endDate: endDateValue
            },

            success: function(response) {
                var total_revenue = response.data.total_revenue;
                var customerCreatedByDate = response.data.customerCreatedByDate;
                var saleInvoiceSuccessed = response.data.saleInvoiceSuccessed;
                var saleInvoiceCancelled = response.data.saleInvoiceCancelled;
                let netProfit = response.data.netProfit;
                netProfit = netProfit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                console.log('check net profit:', netProfit);
                // view new value in html
                $('#total_revenue').text(total_revenue);
                $('#customerCreatedByDate').text(customerCreatedByDate);
                $('#saleInvoiceSuccessed').text(saleInvoiceSuccessed);
                $('#saleInvoiceCancelled').text(saleInvoiceCancelled);
                $('#netProfit').text(netProfit);
            },

            error: function(error) {
                console.log(error);
            }
        });

    }
</script>
