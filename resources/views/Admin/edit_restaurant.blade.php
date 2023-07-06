@extends('Admin.Layout.App')
@section('bg-gradient-primary','active')
@section('main_section')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
     <div class="container-fluid py-1 px-3">
       <nav aria-label="breadcrumb">
         
             <h6 class="font-weight-bolder mb-0">Edit Restaurant Owner </h6>
         
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
               <h6 class="text-white text-capitalize ps-3">Edit Restaurant Owner</h6>
             </div>
           </div>
           <div class="card-body px-0 pb-2">
             <div class="table-responsive " style="padding: 3px 20px">
                <form action="{{url('Admin/update_restaurant')}}/{{$restaurant->id}}" method="post" >
                    @csrf
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Restaurant Owner Name</label>
                      <input type="text" class="form-control @error('name') is-invalid @enderror"  name="name" id="name" value="{{$restaurant->rest_name}}" required="">
                      @error('name')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('name') }}</strong>
                      </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Contact Number</label>
                      <input type="tel" class="form-control @error('contact_number') is-invalid @enderror"  name="contact_number" id="contact_number" value="{{$restaurant->contact_number}}" required="">
                      @error('contact_number')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('contact_number') }}</strong>
                      </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Email</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror"  name="email" id="email" value="{{$restaurant->email}}" required="">
                      @error('email')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                      </span>
                      @enderror
                    </div>
                    {{-- <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Password</label>
                      <input type="password" class="form-control @error('password') is-invalid @enderror"  name="password" id="password" value="{{$restaurant->password}}" required="">
                      @error('password')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                      </span>
                      @enderror
                    </div>         --}}
                    <div class="modal-footer">
                      <button type="button" onclick="window.location='{{ url('Admin/manage_restaurant') }}'" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn bg-gradient-primary" id="submitForm">Edit Restaurant Owner</button>
                    </div>
                  </form>
             </div>
           </div>
         </div>
       </div>
     <footer class="footer py-4  ">
       <div class="container-fluid">
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

  
         
       
  

  