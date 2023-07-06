@extends('Admin.Layout.App')
@section('main_section')



</style>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
   <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <h6 class="font-weight-bolder mb-0">Account Settings </h6>          
          </div>
        </nav>
      </div>
    </nav>
    <!-- End Navbar --> 
    <div class="container-fluid ">
       <div class="col-6">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Account Settings</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive " style="padding: 3px 20px">
                @if(Session::has('status'))
                  <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('status') }}</p>
                @endif
               <form action="{{url('Admin/update_password')}}" method="post">
                @csrf
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Change Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="exampleInputEmail1" aria-describedby="emailHelp">
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" id="exampleInputPassword1">
                    @error('confirm_password')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('confirm_password') }}</strong>
                      </span>
                    @enderror
                  </div>                  
                  <button type="submit" class="btn bg-gradient-primary">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <footer class="footer py-4  ">
        <div class="container-fluid" style="position:fixed;bottom:0;">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://protolabzit.com" class="font-weight-bold" target="_blank">Protolabz eServices</a>
                for a better web.
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
 
  @endsection
