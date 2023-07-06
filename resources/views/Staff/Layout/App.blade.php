<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{url('Admin/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{url('Admin/img/favicon.png')}}">
  <title>
    Staff - Panel
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{url('Admin/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{url('Admin/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{url('Admin/css/material-dashboard.css?v=3.0.0')}}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />

   <style>
    .bg-gradient-primary {
    background-image: linear-gradient(195deg, #fb9400 0%, #fb9400 100%);
    }
    table.dataTable thead th {    
        font-size: 12px !important;    
    }
    table.dataTable tr.odd {
      background-color: white; 
    }
    table.dataTable tr.odd td.sorting_1 {
      background-color: white;
    }
    table.dataTable tr.even td.sorting_1 {
      background-color: white;
    }
    table.dataTable tbody tr {
      font-size: 13px;
    }
    .dataTables_length {   
      padding: 0px 8px 2px 17px
    }
    .dataTables_filter {   
       padding: 0px 20px 16px 20px;
    }
    .dataTables_filter input[type="search"] {
      border-radius: 5px;
      margin-left: 9px;
    }
    .dataTables_length select {
      padding: 2px;
      border-radius: 7px;
    }
    div .dataTables_info {
    display: none;
  }
  .dataTables_paginate {
    float: left;
    font-size: 12px;
    padding-top: 10px;
  }
  .sidenav-header {
    height: 3.875rem;
  }
  table.dataTable {
    width: 100% !important;
  }
  .alert-warning {
     background: #ff000094;
     color: white
  }
  table.dataTable thead th {
    padding: 13px 18px 14px 10px !important;
  }
   table.dataTable thead th {
    padding: 13px 18px 14px 10px !important;
   }
   table.dataTable td {
    padding: 6px 12px !important;
    }
    .nav-link.active{
      background-image: linear-gradient(195deg, #fb9400 0%, #fb9400 100%);
    }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-200" style="overflow: hidden">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#"  style="text-align:center;">
        <img src="{{url('images/logo.png')}}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white"></span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="overflow-hidden" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white  {{ (Request::is('Staff/dashboard') ? 'bg-gradient-primary' : '') }}" href="{{url('Staff/dashboard')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @yield('bg-gradient-primary') {{ (Request::is('Staff/category') ? 'bg-gradient-primary' : '') }} " href="{{url('Staff/category')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Manage Categories </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @yield('bg-gradient') {{ (Request::is('Staff/menus') ? 'bg-gradient-primary' : '') }}" href="{{url('Staff/menus')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">local_dining</i>
            </div>
            <span class="nav-link-text ms-1">Manage Menus</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @yield('bg') {{ (Request::is('Staff/orders') ? 'bg-gradient-primary' : '') }}" href="{{url('Staff/orders')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">local_dining</i>
            </div>
            <span class="nav-link-text ms-1">Manage Orders</span>
          </a>
        </li>      
        <li class="nav-item">
            <a class="nav-link text-white {{ (Request::is('Staff/manage_wallet') ? 'bg-gradient-primary' : '') }}" href="{{url('Staff/manage_wallet')}}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">account_balance_wallet</i>
              </div>
              <span class="nav-link-text ms-1">Manage Wallet </span>
            </a>
        </li> 
         <li class="nav-item">
          <a class="nav-link text-white {{ (Request::is('Staff/device') ? 'bg-gradient-primary' : '') }}" href="{{url('Staff/device')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">crop_portrait</i>
            </div>
            <span class="nav-link-text ms-1">Manage Device</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ (Request::is('Staff/banner') ? 'bg-gradient-primary' : '') }}" href="{{url('Staff/banner')}}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">image</i>
              </div>
              <span class="nav-link-text ms-1">Manage Banner </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ (Request::is('Staff/manage_logo') ? 'bg-gradient-primary' : '') }}" href="{{url('Staff/manage_logo')}}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">broken_image</i>
              </div>
              <span class="nav-link-text ms-1">Manage Staff Logo </span>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ (Request::is('Staff/manage_advertisement') ? 'bg-gradient-primary' : '') }}" href="{{url('Staff/manage_advertisement')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">tv</i>
            </div>
            <span class="nav-link-text ms-1">Advertisement </span>
          </a>
      </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ (Request::is('Staff/account') ? 'bg-gradient-primary' : '') }}" href="{{url('Staff/account')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">account_box</i>
            </div>
            <span class="nav-link-text ms-1">Help </span>
          </a>
      </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{url('Staff/logout')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">power_settings_new</i>
            </div>
            <span class="nav-link-text ms-1">Log out</span>
          </a>
        </li>
      </ul>
    </div>
    
  </aside>
 @yield('main_section')

 
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
 
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@yield('main_script')
</body>

</html>