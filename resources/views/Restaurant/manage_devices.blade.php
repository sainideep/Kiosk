@extends('Restaurant.layout.App')
<style>
  .paginate_button {
     margin-right: 8px !important;
 }
 #device_table_previous{
   border: 1px solid;
   padding-left: 5px;
   padding-right: 5px;
 }
 #device_table_next{
   border: 1px solid;
   padding-left: 5px;
   padding-right: 5px;
 }
 </style>
@section('main_section')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
   <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">          
              <h6 class="font-weight-bolder mb-0">Manage Device</h6>
          </div>
        </nav>
      </div>
    </nav>
    <!-- End Navbar --> 
    <div class="container-fluid ">
       <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2">
                <div class="row">
                  <div class="col-6">
                    <h6 class="text-white text-capitalize ps-3">Manage Devices</h6>
                  </div>
                  <div class="col-5" style="text-align: right;margin-left: 59px">
                     <button class="btn bg-gradient-primary mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" style="width: max-content;background: beige; color: black"> Add New Device</button>
                  </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive" style="padding: 3px 20px">
                <table class="table align-items-center mb-0" id="device_table" style="width: 100%">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">S.No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Staff Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Device Name</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder" style="text-align: center;">Kiosk App Link</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder">Status</th>
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

        <!-- modal start here  -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add New Device</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
             <form id="add_device">
              <div class="modal-body">  
              @csrf             
                  <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Device Name:</label>
                    <input type="text" class="form-control border" id="recipient-name" name="device_name" required="">
                     <p id="device_name" class="d-none text-danger">This Filed is Required</p>
                  </div>                
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Staff Name:</label>
                     <Select class="form-control border" name="staffId" required="">
                      <option value=""> Select Staff</option>   
                      @foreach($restor as $rest )
                        <option value="{{ $rest->id}}"> {{ $rest->name}}</option>

                      @endforeach                   
                    </Select>
                     <p id="staffId" class="d-none text-danger">This Filed is Required</p>
                  </div>                 
                               
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit"   class="btn bg-gradient-primary">Add Device</button>
              </div>
          </form>
          </div>
        </div>
      </div>

        <!-- end modal here -->
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
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>  
  <script> 
    var table = $('#device_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('Restaurant/manage_devices') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'staff_name'},
            {data: 'device_name'},
            {data: 'unique_link', searchable: false},
            {data: 'status', searchable: false},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: false
            },
        ]
    });     
  </script> 
   <script src="https://code.jquery.com/jquery-2.2.4.js"></script>

  <script type="text/javascript">   
    $( '#add_device' ).on( 'submit', function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: "POST",
            url:"{{'add_device'}}",
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
                      'Staff Added!',
                      'success'
                    )
                      location.reload();
                  }
            }
        });

    });
  </script>
  @endsection
