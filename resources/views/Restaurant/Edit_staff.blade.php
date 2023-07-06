@extends('Restaurant.layout.App')
@section('bg-gradient-primary','active')
@section('main_section')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
   <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">         
              <h6 class="font-weight-bolder mb-0">Staff</h6>           
          </div>
        </nav>
      </div>
    </nav>
    <!-- End Navbar --> 
    <div class="container-fluid ">
       <div class="col-8">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Staff Table</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
               <form id="update_staff">
              <div class="modal-body">  
              @csrf  
              <input type="hidden" value="{{$staff->id}}" name="staff_id"> 
                  <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Name:</label>
                    <input type="text" value="{{$staff->name}}" class="form-control border" id="recipient-name" name="name" required="">
                     <p id="email" class="d-none text-danger">This Filed is Required</p>
                  </div>           
                  <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Email:</label>
                    <input type="email" value="{{$staff->email}}" class="form-control border" id="recipient-name" name="email" required="">
                     <p id="email" class="d-none text-danger">This Filed is Required</p>
                  </div>                
                  {{--<div class="mb-3">
                    <label for="message-text" class="col-form-label">Password:</label>
                     <input type="text"  class="form-control border" name="Password" required="">
                     <p id="Password" class="d-none text-danger">This Filed is Required</p>
                  </div>--}}
                 
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Location:</label>
                     <input type="text" value="{{$staff->location}}" class="form-control border" id="recipient-name" name="location" required="">
                      <p id="location" class="d-none text-danger">This Filed is Required</p>
                  </div>               
              </div>
              <div class="modal-footer">
                <a href="{{url('Restaurant/manage_staff')}}"   class="btn bg-gradient-primary" style="color: white !important">Close</a>
                <button type="submit"   class="btn bg-gradient-primary">Update Staff</button>
              </div>
          </form>
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
                <a href="#" class="font-weight-bold" target="_blank">Protolabz eServices</a>
                for a better web.
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>  
 
   <script src="https://code.jquery.com/jquery-2.2.4.js"></script>

  <script type="text/javascript">  	
  	$( '#update_staff' ).on( 'submit', function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: "POST",
            url:"{{url('Restaurant/update_staff')}}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {              
                if(data.status == 0){
                  $.each(data.message, function (key, value) {
                         $('#'+key).removeClass('d-none');
                         $('#'+key).html(value[0]);
                      });
                  }
                  if(data.status == 1){
                      Swal.fire(
                      'Good job!',
                      'Updated!',
                      'success'
                    )
                      setInterval(function () { window.location.href = "{{url('Restaurant/manage_staff')}}" },2000);
                  }
            }
        });

    });
  </script>
  @endsection
