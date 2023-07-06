@extends('Admin.Layout.App')
@section('bg','active')
@section('main_section')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
     <div class="container-fluid py-1 px-3">
       <nav aria-label="breadcrumb">
         
             <h6 class="font-weight-bolder mb-0">Edit Device </h6>
         
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
               <h6 class="text-white text-capitalize ps-3">Edit Device</h6>
             </div>
           </div>
           <div class="card-body px-0 pb-2">
             <div class="table-responsive " style="padding: 3px 20px">
                <form  action="{{url('Admin/update_device')}}/{{$device->id}}" method="post"  id="form">
                    <div class="modal-body">	
                    @csrf   
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Restaurant Name:</label>
                      <input type="text" class="form-control border" id="recipient-name" name="restaurant" value="{{$device->restor_name}}" required="" readonly>
                      <input type="hidden" class="form-control border" id="recipient-name" name="restaurantid" value="{{$device->restor_id}}" required="" readonly>
                       <p id="restaurant" class="d-none text-danger">This Filed is Required</p>
                    </div>
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Staff Name:</label>
                      <input type="text" class="form-control border" id="recipient-name" name="staff" value="{{$device->staff_name}}" required="" readonly>
                      <input type="hidden" class="form-control border" id="recipient-name" name="staffid" value="{{$device->staff_id}}" required="" readonly>
                       <p id="staff" class="d-none text-danger">This Filed is Required</p>
                    </div>
                        <div class="mb-3">
                          <label for="recipient-name" class="col-form-label">Device Name:</label>
                          <input type="text" class="form-control border" id="recipient-name" name="device_name" value="{{$device->device_name}}" required="">
                           <p id="device" class="d-none text-danger">This Filed is Required</p>
                        </div>  
                        
                        <div class="mb-3">
                    <label for="ip-name" class="col-form-label">Raspberry IP Address:</label>
                    <input type="text" class="form-control border"  placeholder="xxx.xxx.xxx.xx" id="ipv4" value="{{$device->ip_address}}" name="ip_address" required="">
                     <p id="ip_address" class="d-none text-danger">This Filed is Required</p>
                     @error('ip_address') <div class="d-none text-danger ">Please Enter Valid IP Address</div>@enderror

                  </div>           

                    <div class="modal-footer">
                      <button type="button" onclick="window.location.href='{{url('Admin/manage_devices')}}'" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit"   class="btn bg-gradient-primary">Edit Device</button>
                    </div>
                </form>
             </div>
           </div>
         </div>
       </div>
     <footer class="footer py-4  ">
       <div class="container-fluid">
         <div class="row align-items-center justify-content-lg-between">
           <div class="col-lg-12 mb-lg-0 mb-4">
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

  
         
       
  

  