@extends('Staff.Layout.App')
@section('main_section')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Device Info</h6>
        </nav>
      
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
       <div class="col-12">
         <div class="card my-4">
           <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
             <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
               <h6 class="text-white text-capitalize ps-3">Device Info</h6>
             </div>
           </div>
           <div class="card-body px-0 pb-2">
             <div class="table-responsive " style="padding: 3px 20px">
                <table class="table">                 
                  <tbody>
                    <tr>
                      <th scope="row">Kiosk Name</th>
                      <td>{{Auth::guard('staff')->user()->getDeviceInfo->device_name ?? ''}}</td>
                     
                    </tr>
                    <tr>
                      <th scope="row">Kiosk Link</th>
                      <td>{{Auth::guard('staff')->user()->getDeviceInfo->unique_link ?? ''}}</td>
                     
                    </tr>
                    <tr>
                      <th scope="row">Status</th>
                      <td colspan="2">@if(Auth::guard('staff')->user()->getDeviceInfo)
                        {{Auth::guard('staff')->user()->getDeviceInfo->status== '1' ? "Active" : "Not Active"}}
                        @endif
                        </td>
                     
                    </tr>
                  </tbody>
                </table>  
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
                <a href="https://protolabzit.com" class="font-weight-bold" >Protolabz eServices</a>
                for a better web.
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  @endsection
  