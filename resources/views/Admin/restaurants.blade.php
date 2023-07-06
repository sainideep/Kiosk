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
              <h6 class="font-weight-bolder mb-0">Restaurant Owners</h6>     
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
                <h6 class="text-white text-capitalize ps-3">Restaurant Owners ({{$data}})</h6>
                <div class="col-5" style="text-align: right; margin-left: 59%;">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="width: max-content;background: beige; color: black">Add Restaurant Owner</button>
                </div>
     
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive " style="padding: 3px 20px;padding-top: 97px;height: 461px;overflow-y: scroll;">
                <table class="table " id="staff_table">
                  <thead>
                    <tr>
                      <th class="text-uppercase  text-xxs  ">S.No</th>
                      <th class="text-uppercase  text-xxs  ">Restaurant Owner Name</th>
                      <th class="text-uppercase  text-xxs  ">Email</th>
                      <th class=" text-uppercase  text-xxs font-weight-bolder">Contact Number</th>
                      <th class=" text-uppercase  text-xxs font-weight-bolder">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Active</th>
                      <th class=" text-uppercase  text-xxs font-weight-bolder">Action</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Add Restaurant Owner</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('Admin/add_restaurant')}}" method="post" >
            @csrf
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Restaurant Owner Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror"  pattern="[A-Z a-z]{1,}"  name="name" id="name" required="">
              @error('name')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('name') }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Contact Number</label>
              <input type="tel" class="form-control @error('contact_number') is-invalid @enderror" pattern="[0-9]{10,15}" name="contact_number" id="contact_number" required="">
              @error('contact_number')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('contact_number') }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror"  name="email" id="email" required="">
              @error('email')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror"  name="password" id="password" required="">
              @error('password')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
              </span>
              @enderror
            </div>        
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn bg-gradient-primary" id="submitForm">Add Restaurant Owner</button>
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
        order:      [ 0, 'desc' ],
        ordering:   true,
        ajax: "{{ url('Admin/getRestaurantData') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'rest_name'}, 
            {data: 'email'},           
            {data: 'contact_number' },
            {data: 'status'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: false
            },
            {
                data: 'actionData', 
                name: 'action', 
                orderable: true, 
                searchable: false
            },

        ]
    });   
   
   

    function show(id) {
        $.ajax({
            type: "Get",
            url:"{{url('Admin/change_status_restor')}}",
            data: {restor_id:id },
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
                      'Status Changed!',
                      'success'
                    )
                      table.ajax.reload();
                  }
            }
        });
      }  
  </script>
  @endsection
  <script>
  function delete(id)
  {
    alert(id);
    return false;
  }
  </script>