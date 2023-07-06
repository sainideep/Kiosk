@extends('Staff.Layout.App')
<style>
  .paginate_button{
    margin-right:8px !important;
  }
</style>
@section('main_section')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Manage Category</h6>
        </nav>
        
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-1 " style="position: fixed;width: 75%;">
                <h6 class="text-white text-capitalize ps-3">Manage Category</h6>
                <div class="col-5" style="text-align: right; margin-left: 59%;">
                <button type="button" class="btn mt-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="width: max-content;background: beige; color: black;font-size: 13px;"><b>Add Category</b></button>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive" style="padding: 3px 20px;padding-top: 97px;height: 461px;overflow-y: scroll;">
                <table class="table align-items-center mb-0" id="table_id" style="width: 991px !important">
                  <thead>
                    <tr>
                      <th class="text-secondary text-xxs font-weight-bolder ">ID</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">CATEGORY NAME(en)</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">NOME DELLA CATEGORIA(it)</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">SUB CATEGORY(en)</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">SOTTO CATEGORIA(it)</th>  
                      <th class="text-secondary text-xxs font-weight-bolder  ps-2">IMAGE</th>
                      <th class="text-center text-secondary text-xxs font-weight-bolder " >ACTION</th>  
                      <th class="text-center text-secondary text-xxs font-weight-bolder " >AVAILABLE</th>                      
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
          <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
       {{-- <ul class="nav nav-tabs">
          <li class="active" style="padding: 10px" ><a data-toggle="tab" href="#home">EN</a></li>
          <li style="padding: 10px"><a data-toggle="tab" href="#menu1">ITL</a></li>
        </ul> --}}
      
        <div class="tab-content">
          <div id="home" class="tab-pane fade in active show">
            <div class="modal-body">
              <form action="{{url('Staff/add_category')}}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label" style="text-transform: inherit;">Category Name (en)</label>
                  <input type="text" class="form-control @error('category') is-invalid @enderror" placeholder="Enter English Name" name="categoryEn" id="category" required="">
                  @error('category')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('category') }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label" style="text-transform: inherit;">NOME DELLA CATEGORIA (it)</label>
                  <input type="text" class="form-control @error('category') is-invalid @enderror" placeholder="Enter Italian Name" name="categoryItl" id="category" required="">
                  @error('category')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('category') }}</strong>
                  </span>
                  @enderror
                </div>                
                <div class="form-group">
                  <label for="">Category Image (120*120)</label>
                  <input type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" id="image" accept="image/x-png,image/jpeg" required="" />
                  @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('image') }}</strong>
                  </span>
                  @enderror
                </div>                
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn bg-gradient-primary" id="submitForm">Add Category</button>
                </div>
              </form>
            </div>
          </div>
          {{--<div id="menu1" class="tab-pane fade" >
            <div class="modal-body">
              <form action="{{url('Staff/add_category')}}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Nome della categoria</label>
                  <input type="text" class="form-control @error('category') is-invalid @enderror" name="category" id="category">
                  @error('category')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('category') }}</strong>
                  </span>
                  @enderror
                </div>
               <div class="form-group">
                 <label for="">Dimensione</label>
                 <select class="js-example-basic-multiple" name="sizes[]" multiple="multiple" style="width: 100%">
                  <option value="Small/Piccolo">Piccolo</option>
                  <option value="Medium/Medio">Medio</option>
                  <option value="Large/Grande">Grande</option>
                  <option value="Full_Plate/Piatto_Pieno">Piatto_Pieno</option>
                  <option value="Half_Plate/Mezzo_Piatto">Mezzo_Piatto</option>
                </select>
               </div>
                <div class="form-group">
                  <label for="">Immagine di categoria</label>
                  <input type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" id="image">
                  @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="sr-only" for="inputName">Restaurant_Id</label>
                  <input type="hidden" class="form-control" name="restaurant_id" id="restaurant_id" placeholder="">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn bg-gradient-primary" id="submitForm">Add Category</button>
                </div>
              </form>
            </div>
          </div>
        </div> --}}
       
      </div>
    </div>
  </div>
  @endsection
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  
<script>
$(document).ready(function () {
    $('#table_id').DataTable({
        processing: true,
        serverSide: true,
        bStateSave: true,
        ajax: "{{ url('Staff/category') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false},
            {data: 'category_name', name:'category_name'},
            {data: 'category_italian_name', name:'category_italian_name'},
            {data: 'sub_categories', searchable: false},
            {data: 'sub_categories_tl', searchable: false},
            {data: 'image', searchable: false},
            {
              data: 'action', searchable: false
            },
            {
                data: 'status', 
                name: 'status', 
                orderable: true, 
                searchable: false
            },
        ]
    });
});


function show(id) {
        $.ajax({
            type: "Get",
            url:"{{url('Staff/change_status')}}",
            data: {cat_id:id },
            success: function(data) {              
                if(data.status == 1){
                  $.each(data.message, function (key, value) {
                         $('#'+key).removeClass('d-none');
                         $('#'+key).html(value[0]);
                      });
                  }
                  if(data.status == 0){
                    // window.location.href = "{{url('Staff/category')}}";
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

<script type="text/javascript">
$(document).ready(function() {
  $('#form').on('submit', function (e) {
  
  e.preventDefault();
  var data = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '{{url('Staff/add_category')}}',
        dataType: 'json',
        data: data,  
        cache: false,
        contentType: false,
        processData: false,      
        success: function (data) {
          if(data.status == 1)
          {
          Swal.fire(
            'Good job!',
            'Category Added!',
            'success'
          )
          location.reload();
          }
          // if(data.status == 0)
          // {
          //   toastr["error"](data.message, "Error");
          // }  
        },
        error: function (data) {
            // alert(data);
        }
    });
  });
});
</script>
<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
  </script>