@extends('Admin.Layout.App')
@section('bg-gradient','active')
@section('main_section')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
     <div class="container-fluid py-1 px-3">
       <nav aria-label="breadcrumb">
         
             <h6 class="font-weight-bolder mb-0">Edit Staff </h6>
         
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
               <h6 class="text-white text-capitalize ps-3">Edit Staff</h6>
             </div>
           </div>
           <div class="card-body px-0 pb-2">
             <div class="table-responsive " style="padding: 3px 20px">
                <form action="{{url('Admin/update_staff')}}/{{$staff->id}}" method="post" >
                    @csrf
                    <div class="form-group">
                      <label for="">Select Restaurant</label>
                      <select class="form-control" name="restaurant" id="restaurant" required="">
                        <option value="">Select</option>
                        @foreach ($restaurants as $restaurant)              
                        <option value="{{$restaurant->id}}" {{ $restaurant->id == $staff->restor_id ? 'selected' : '' }}>{{$restaurant->rest_name}}</option>                      
                        @endforeach
                      </select>
                      <p id="restaurant" class="d-none text-danger">This Filed is Required</p>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Name</label>
                      <input type="text" class="form-control @error('name') is-invalid @enderror"  name="name" id="name" value="{{$staff->name}}" required="">
                      @error('name')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('name') }}</strong>
                      </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Email</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror"  name="email" id="email" value="{{$staff->email}}" required="">
                      @error('email')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                      </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Location</label>
                      <input type="text" class="form-control @error('location') is-invalid @enderror"  name="location" id="location" value="{{$staff->location}}" required="">
                      @error('location')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('location') }}</strong>
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
                      <button type="button" onclick="window.location='{{ url('Admin/manage_staff') }}'" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn bg-gradient-primary" id="submitForm">Edit Staff</button>
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

  
         
       
  

  