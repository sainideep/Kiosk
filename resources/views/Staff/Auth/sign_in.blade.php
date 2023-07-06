<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{url('Admin/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{url('Admin/img/favicon.png')}}">
  <title>
   Auto Grill - Staff
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
  <style>
    .bg-gradient-primary {
        background-image: linear-gradient(195deg, #fb9400 0%, #fb9400 100%);
    }
    .alert-warning {
     background: #ff000094;
     color: white
    }
    </style>
</head>

<body class="bg-gray-200">
    <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1552566626-52f8b828add9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Nnx8cmVzdGF1cmFudHxlbnwwfHwwfHw%3D&w=1000&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Staff Panel</h4>                 
                </div>
              </div>
              <div class="card-body">
                @if(Session::has('message'))
                  <p class="alert alert-warning --bs-red">{{ Session::get('message') }}</p>
                @endif
                <form role="form" class="text-start" action="{{url('Staff/staff_login')}}" method="post"> 
                @csrf 
                <div class="input-group input-group-outline my-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email">
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer position-absolute bottom-2 py-2 w-100">
        <div class="container">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-12 col-md-6 my-auto">
              <div class="copyright text-center text-sm text-white text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart" aria-hidden="true"></i> by
                <a href="#" class="font-weight-bold text-white" target="_blank">Protolabz eServices</a>
                for a better web.
              </div>
            </div>
           </div>
        </div>
      </footer>
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="{{url('Admin/js/core/popper.min.js')}}"></script>
  <script src="{{url('Admin/js/core/bootstrap.min.js')}}"></script>
  <script src="{{url('Admin/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{url('Admin/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{url('Admin/assets/js/material-dashboard.min.js?v=3.0.0')}}"></script>
</body>

</html>