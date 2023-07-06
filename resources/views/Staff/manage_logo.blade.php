@extends('Staff.Layout.App')
@section('main_section')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
     <div class="container-fluid py-1 px-3">
       <nav aria-label="breadcrumb">
             <h6 class="font-weight-bolder mb-0">Change Staff Logo</h6>         
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
               <h6 class="text-white text-capitalize ps-3">Change Staff Logo</h6>
             </div>
           </div>
           @if($data)
            <img src="{{ $data->logo }}" style="height: 100px; width: 100px;transform: translateX(187%);object-fit:contain">
         @else         
           <img src="{{url('images/logo1.png')}}" alt="logo" style=" width: 107px; transform: translateX(172%); margin-top: 13px;">
         @endif
           <div class="card-body px-0 pb-2">
             <div class="table-responsive " style="padding: 3px 20px">
                <form action="{{url('Staff/changeLogo')}}" method="post" id="form" enctype="multipart/form-data">
                    @csrf
                   <div class="form-group">
                     <label for="" style="font-weight: bold;color: black">Choose Logo (500 x 134)</label>
                     <input  class="form-control @error('description') is-invalid @enderror" type="file" name="change_logo"  id="description" accept="image/x-png,image/jpeg"  />
                     @error('description')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{  $message }}</strong>
                     </span>
                     @enderror
                    </div>
                    @if($data)
                      <div class="form-group">
                        <label for="" style="font-weight: bold;color: black">Status(English)</label>
                        <input  class="form-control @error('description') is-invalid @enderror" type="text" value="{{$data->status}}" name="status" id="status" required="" />
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{  $message }}</strong>
                        </span>
                        @enderror
                       </div>
                    @else
                      <div class="form-group">
                        <label for="" style="font-weight: bold;color: black">Status(English)</label>
                        <input  class="form-control @error('description') is-invalid @enderror" type="text" value="" name="status" id="status" required="" />
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{  $message }}</strong>
                        </span>
                        @enderror
                       </div>
                    
                    @endif
                    @if($data)
                      <div class="form-group">
                        <label for="" style="font-weight: bold;color: black">Status(Italian)</label>
                        <input  class="form-control @error('description') is-invalid @enderror" type="text" value="{{$data->status_it}}" name="itstatus" id="itstatus" required="" />
                        @error('itstatus')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{  $message }}</strong>
                        </span>
                        @enderror
                       </div>
                    @else
                      <div class="form-group">
                        <label for="" style="font-weight: bold;color: black">Status(Italian)</label>
                        <input  class="form-control @error('description') is-invalid @enderror" type="text" value="" name="itstatus" id="itstatus" required="" />
                        @error('itstatus')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{  $message }}</strong>
                        </span>
                        @enderror
                       </div>
                    @endif
                      <button type="submit" class="btn bg-gradient-primary" id="submitForm">Update</button>
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
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 @section('main_script')
  <script type="text/javascript">
    @if(Session::has('status'))
      Swal.fire(
        'Good job!',
        'Logo Updated!',
        'success'
      ) 
    @endif
    </script>
  @endsection
  @endsection
  
  