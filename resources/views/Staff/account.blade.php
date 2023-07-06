@extends('Staff.Layout.App')
@section('main_section')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
     <div class="container-fluid py-1 px-3">
       <nav aria-label="breadcrumb">
             <h6 class="font-weight-bolder mb-0">Help</h6>         
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
               <h6 class="text-white text-capitalize ps-3">Help</h6>
             </div>
           </div>
           <div class="card-body px-0 pb-2">
             <div class="table-responsive " style="padding: 3px 20px">
                <form action="{{url('Staff/account_issue')}}" method="post" id="form">
                    @csrf
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label" style="font-weight: bold;color: black">Issue Title</label>
                      <input type="text" class="form-control @error('issue') is-invalid @enderror" name="issue" id="issue" >
                      @error('issue')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('issue') }}</strong>
                      </span>
                      @enderror
                    </div>
                   <div class="form-group">
                     <label for="" style="font-weight: bold;color: black">Description</label>
                     <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3"  ></textarea>
                     @error('description')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{  $message }}</strong>
                     </span>
                     @enderror
                    </div>
                    <div class="form-group">
                      <label class="sr-only" for="inputName">Restaurant_Id</label>
                      <input type="hidden" class="form-control" name="restaurant_id" id="restaurant_id" placeholder="">
                    </div>
                      <button type="submit" class="btn bg-gradient-primary" id="submitForm">Send Issue</button>
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
        'Issue Sent!',
        'success'
      ) 
    @endif
    </script>
  @endsection
  @endsection
  
  