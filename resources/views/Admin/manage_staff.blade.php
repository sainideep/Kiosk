@extends('Admin.Layout.App')
<style>
  .paginate_button{
    margin-right:8px !important;
  }
  body{
    overflow: hidden !important;
  }
</style> 
@section('main_section')


<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
   <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">          
              <h6 class="font-weight-bolder mb-0">Manage Staff</h6>     
          </div>
         
        </nav>
      </div>
      
    </nav>  
    <!-- End Navbar --> 
    <div class="container-fluid ">
       <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-1 pb-1" style="position: fixed;width: 75%;">
                <h6 class="text-white text-capitalize ps-3">Manage Staff ({{$data}})</h6>
                <div class="col-5" style="text-align: right; margin-left: 59%;">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="width: max-content;background: beige; color: black">Add Staff</button>
                </div>
     
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive " style="padding: 3px 20px;padding-top: 97px;height: 461px;overflow-y: scroll;">
                <table class="table " id="staff_table">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">S.No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Restaurant Owner Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Staff Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Email</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Location</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Activity</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                 
                  </tbody>
                </table>
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
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Staff</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  action="{{url('Staff/add_staff')}}" method="post"  id="form">
            <div class="modal-body">	
            @csrf   
            <div class="form-group">
              <label for="">Select Restaurant</label>
              <select class="form-control" name="restaurant" id="restaurant" required="">
                <option value="">Select</option>
                @foreach ($restaurants as $restaurant)              
                <option value="{{$restaurant->id}}" >{{$restaurant->rest_name}}</option>                      
                @endforeach
              </select>
              <p id="restaurant" class="d-none text-danger">This Filed is Required</p>
            </div>
                <div class="mb-3">
                  <label for="recipient-name" class="col-form-label">Name:</label>
                  <input type="text" class="form-control border" id="recipient-name" name="name" required="">
                   <p id="name" class="d-none text-danger">This Filed is Required</p>
                </div>          
                <div class="mb-3">
                  <label for="recipient-name" class="col-form-label">Email:</label>
                  <input type="email" class="form-control border" id="recipient-name" name="email" required="">
                   <p id="email" class="d-none text-danger">This Filed is Required</p>
                </div>                
                <div class="mb-3">
                  <label for="message-text" class="col-form-label">Password:</label>
                   <input type="password" class="form-control border" name="password" required="">
                   <p id="password" class="d-none text-danger">This Filed is Required</p>
                </div>
                <div class="mb-3">
                  <label for="message-text" class="col-form-label">Confirm-Password:</label>
                   <input type="password" class="form-control border" id="recipient-name" name="confirm_password" required="">
                   <p id="confirm_password" class="d-none text-danger">This Filed is Required</p>
                </div>
                <div class="mb-3">
                  <label for="message-text" class="col-form-label">Location:</label>
                   <input type="text" class="form-control border" id="recipient-name" name="location"  required="">
                    <p id="location" class="d-none text-danger">This Filed is Required</p>
                </div>	             
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit"   class="btn bg-gradient-primary">Add Staff</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>

  

  @endsection
  @section('main_script_admin')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>  
  <script> 
    var table = $('#staff_table').DataTable({
        processing: true,
        serverSide: true,
        bStateSave: true,
        ajax: "{{ url('Admin/getStaffData') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false},
            {data: 'restor_name', searchable: false},
            {data: 'name'},
            {data: 'email'},
            {data: 'location'},
            {data: 'status'},
            {
                data: 'activity', 
                name: 'activity', 
                orderable: true, 
                searchable: false
            },
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: false
            },
        ]
    });   
    function showing(id) {
        $.ajax({
            type: "Get",
            url:"{{url('Admin/change_Staff_status')}}",
            data: {staff_id:id },
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
                      table.ajax.reload();
                  }
            }
        });
      } 
  </script>
  <script src="https://code.jquery.com/jquery-2.2.4.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#form').on('submit', function (e) {
      
      e.preventDefault();
      var data = $('#form').serialize();
        $.ajax({
            type: 'POST',
            url: '{{url('Admin/add_staff')}}',
            data: data,       
            success: function (data) {
              if(data.status == 1){
               Swal.fire(
                  'Good job!',
                  'Staff Added!',
                  'success'
                )
                location.reload();   
                }
                
                if(data.status == 0){
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: data.message.confirm_password[0],                      
                    })  
                }     
            },
            error: function (data) {
                // alert(data);
            }
        });
      });
    });
    </script>
  @endsection