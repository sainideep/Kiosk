@extends('Staff.Layout.App')
@section('main_section')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Manage Advertisement</h6>
        </nav>
       
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-1  " style="position: fixed;width: 75%;">
                <h6 class="text-white text-capitalize ps-3">Manage Advertisement</h6>               
                  <div class="col-5" style="text-align: right; margin-left: 59%;">
                  {{-- @if(!$banner) --}}
                    <button type="button" class="btn mt-2" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="width: max-content;background: beige; color: black;font-size: 13px;"><b>Add Advertisement</b></button>
                  {{-- @endif --}}
                  </div>                
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive " style="padding: 20px;padding-top: 97px;height: 461px;overflow-y: scroll;">
                <table class="table align-items-center mb-0" id="advertisement_table">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">Id</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">Image</th>
                      <th class="  text-uppercase text-secondary text-xxs font-weight-bolder " >Action</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
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
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add (Advertisement)</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  method="post" enctype="multipart/form-data" id="add_advertisement">
            @csrf
            <div class="form-group">
              <label for="">Select Type</label>
              <select class="form-control @error('type') is-invalid @enderror" onchange="ShowData(this)" name="type" required="">
                <option value="">Select</option>
                <option value="1">Image</option>
                <option value="2">Video</option>
              </select>
              @error('type')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('type') }}</strong>
              </span>
              @enderror
            </div> 
            <div class="form-group" id="image_section" style="display: none">
              <label for="">Upload Image (1880 x 427)</label>
              <input type="file" class="form-control-file @error('image') is-invalid @enderror" accept="image/png, image/jpeg" name="image" id="image" >
              @error('image')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('image') }}</strong>
              </span>
              @enderror
            </div> 
            <div class="form-group" id="Video_section" style="display: none">
              <label for="">Upload Video </label>
              <input type="file" class="form-control-file @error('video') is-invalid @enderror" accept="video/*" name="video" id="image" >
              @error('video')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('video') }}</strong>
              </span>
              @enderror
            </div>           
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn bg-gradient-primary" id="submitForm">Add Advertisement</button>
            </div>
          </form>
        </div>
       
      </div>
    </div>
  </div>
  
  @endsection
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  
<script>

  function ShowData(data){
    if(data.value == 1){
      $('#image_section').show();
      $('#Video_section').hide();
    }else{
      $('#Video_section').show();
      $('#image_section').hide();

    }
  }

$(document).ready(function () {
    $('#advertisement_table').dataTable({
        processing: true,
        serverSide: true,
        searching: false,
        paging:   false,
        ordering: false,
        ajax: "{{ url('Staff/manage_advertisement') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false},
            {data: 'image', searchable: false},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: false
            },
        ]
    });


});
</script>

 <script type="text/javascript">
$(document).ready(function() {
  $('#add_advertisement').on('submit', function (e) {  
    e.preventDefault();
    var data = new FormData(this);
      $.ajax({
          type: 'POST',
          url: '{{url('Staff/add_advertisement')}}',
          dataType: 'json',
          data: data,  
          cache: false,
          contentType: false,
          processData: false,      
          success: function (data) {
            if(data.status ==1 ){
              Swal.fire(
                'Good job!',
                'Advertisement Added!',
                'success'
              )
              location.reload();
            }

            if(data.status == 0){
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Image Or Video file is required',                
              })
            }
            console.log(data);
             
          },
          error: function (data) {
              // alert(data);
          }
    });
  });
});
</script>

