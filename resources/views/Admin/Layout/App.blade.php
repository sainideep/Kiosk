<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{url('Admin/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{url('Admin/img/favicon.png')}}">
  <title>
    Admin - Panel
  </title>
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{url('Admin/css/material-dashboard.css?v=3.0.0')}}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" >
  <link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css" />
  
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
      padding: 0px 16px 11px 0px;
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
    table.dataTable thead th {
    padding: 13px 18px 14px 10px !important;
   }
   table.dataTable td {
    padding: 6px 12px !important;
    }
    .navbar-vertical.navbar-expand-xs .navbar-nav .nav-link{
      margin: 0px 0.2rem !important;
    }
    .nav-link.active{
      background-image: linear-gradient(195deg, #fb9400 0%, #fb9400 100%);
    }
  </style>
  @yield('main_css')

</head>

<body class="g-sidenav-show  bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" {{url('Admin/dashboard')}} " >
        <img src="{{url('images/logo.png')}}" class="navbar-brand-img h-100 w-100" style="object-fit: contain;" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white"></span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="overflow-hidden" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white  {{ (Request::is('Admin/dashboard') ? 'bg-gradient-primary' : '') }}" href="{{url('Admin/dashboard')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @yield('bg-gradient-primary') {{ (Request::is('Admin/manage_restaurant') ? 'bg-gradient-primary' : '') }} " href="{{url('Admin/manage_restaurant')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Manage Restaurant Owners </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @yield('bg-gradient') {{ (Request::is('Admin/manage_staff') ? 'bg-gradient-primary' : '') }} " href="{{url('Admin/manage_staff')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Manage Staff</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white  @yield('bg') {{ (Request::is('Admin/manage_devices') ? 'bg-gradient-primary' : '') }}" href="{{url('Admin/manage_devices')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">crop_portrait</i>
            </div>
            <span class="nav-link-text ms-1">Manage Devices  </span>
          </a>
        </li> 
        {{--<li class="nav-item">
          <a class="nav-link text-white " href="#">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">local_dining</i>
            </div>
            <span class="nav-link-text ms-1">Manage payments/transactions </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white  {{ (Request::is('Admin/getOrders') ? 'bg-gradient-primary' : '') }}" href="{{url('Admin/getOrders')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">reorder</i>
            </div>
            <span class="nav-link-text ms-1">Manage Orders</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ (Request::is('Admin/getCommision') ? 'bg-gradient-primary' : '') }}" href="{{url('Admin/getCommision')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">crop_portrait</i>
            </div>
            <span class="nav-link-text ms-1">Manage commissions </span>
          </a>
        </li>--}}
        <li class="nav-item">
            <a class="nav-link text-white {{ (Request::is('Admin/Settings') ? 'bg-gradient-primary' : '') }}" href="{{url('Admin/Settings')}}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">account_balance_wallet</i>
              </div>
              <span class="nav-link-text ms-1">Account Settings  </span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link text-white {{ (Request::is('Admin/Settings') ? 'bg-gradient-primary' : '') }}" href="{{url('Admin/Settings')}}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">image</i>
              </div>
              <span class="nav-link-text ms-1">Advertisement</span>
            </a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link text-white " href="{{url('Admin/logout')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">power_settings_new</i>
            </div>
            <span class="nav-link-text ms-1">Log Out</span>
          </a>
        </li>
      </ul>
    </div>
    
  </aside>
 @yield('main_section') 

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@yield('main_script_admin')

</body>

</html>