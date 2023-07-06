@extends('Staff.Layout.App')
<style>
  .paginate_button{
    margin-right:8px !important;
  }
  @media only screen and (max-width: 500px) {
    .modal {
        position: relative;
    }
}
</style>  
@section('main_section')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Manage Menus</h6>
        </nav>
       
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-1 pb-1" style="position: fixed;width: 75%;">
                <h6 class="text-white text-capitalize ps-3">Manage Menus</h6>
                <div class="col-5" style="text-align: right; margin-left: 59%;">
                <button type="button" class="btn mt-2" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="width: max-content;background: beige; color: black;font-size: 13px;"><b>Add Menus</b></button>
                {{-- <button type="button" class="btn mt-2" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="width: max-content;background: beige; color: black;font-size: 13px;"><b>Import</b></button> --}}

                <button type="button" class="btn mt-2" data-toggle="modal" data-target="#exampleModal1" data-whatever="@mdo" style="width: max-content;background: beige; color: black;font-size: 13px;"><b>Import Csv</b></button>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive" style="padding: 20px;padding-top: 97px;height: 461px;overflow-y: scroll;">
                <table class="table align-items-center mb-0" id="menu_table">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sub Category Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Item Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Articolo Nome italiano</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item Price</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item Image</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" >Action</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" >Available</th>
                     
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
          <h5 class="modal-title" id="exampleModalLabel">Add Menus</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      
       
        <div class="modal-body">
          <form action="{{url('Staff/add_menus')}}" method="post" enctype="multipart/form-data" id="form">
            @csrf
            <div class="form-group">
              <label for="">Select Category</label>
              <select class="form-control" name="category" id="category" required>
                <option value="">Select</option>
                @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->category_name}}/{{$category->category_italian_name}}</option>
               @endforeach
              </select>
            </div>
           <div  id="selectCategory">
           </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label" style="text-transform: inherit;">Item Name (en)</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter English Name" name="nameEn" id="name" required="">
              @error('name')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('name') }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label" style="text-transform: inherit;">Nome dell'oggetto (it)</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Italian Name" name="nameItl" id="name" required="">
              @error('name')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('name') }}</strong>
              </span>
              @enderror
            </div>
           
            <div class="list-group" id="size_data" style="display: none;width:100%">

          
            </div>             
            <div class="form-group">
              <label for="">Description(en)</label>
              <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" required=""></textarea>
              @error('description')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('description') }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="">Descrizione(it)</label>
              <textarea class="form-control @error('description') is-invalid @enderror" name="descriptionit" id="description" rows="3" required=""></textarea>
              @error('description')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('description') }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="">Upload Image</label>
              <input type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" id="image" required="" accept="image/png,image/jpeg,image/jpg" />
              @error('image')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('image') }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label class="sr-only" for="inputName">Restaurant_Id</label>
              <input type="hidden" class="form-control" name="restaurant_id" id="restaurant_id" placeholder="">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn bg-gradient-primary" id="submitForm">Add Menus</button>
            </div>
          </form>
        </div>
       
      </div>
    </div>
  </div>
  


<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="post" enctype="multipart/form-data" id="csv_form">
          @csrf
          <div class="form-group">
            <label for="">CSV File</label>
            <input type="file" class="form-control-file" name="csv_data" id="csv" >
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn bg-gradient-primary" id="submitForm1">Import</button>
      </div>
    </div>
  </div>
</div>
  @endsection
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  
<script>
$(document).ready(function () {
        $('#menu_table').DataTable({
        processing: true,
        serverSide: true,
        bStateSave: true,
        ajax: "{{ url('Staff/menus') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false},
            {data: 'category_name', searchable: false},
            {data: 'sub category_name', searchable: false},
            {data: 'item_name'},
            {data: 'item_italian_name'},
            {data: 'price', searchable: false},
            {data: 'image', searchable: false},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: false
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
</script>

 <script type="text/javascript">
$(document).ready(function() {
  $('#form').on('submit', function (e) {
  
  e.preventDefault();
  var data = new FormData(this);
  // alert(data);
    $.ajax({
        type: 'POST',
        url: '{{url('Staff/add_menus')}}',
        dataType: 'json',
        data: data,  
        cache: false,
        contentType: false,
        processData: false,      
        success: function (data) {
          if(data.status == 1){
           Swal.fire(
              'Good job!',
              'Menu Added!',
              'success'
            )
            location.reload();   
            }
            else{
              console.log(data)
            } 
          //   if(data.status == 0)
          //  {
          //   toastr["error"](data.message, "Error");
          //  }             
        },
        error: function (data) {
            // alert(data);
        }
    });
  });
});

function show(id) {
        $.ajax({
            type: "Get",
            url:"{{url('Staff/change_menu_status')}}",
            data: {menu_id:id },
            success: function(data) {              
                if(data.status == 1){
                  $.each(data.message, function (key, value) {
                         $('#'+key).removeClass('d-none');
                         $('#'+key).html(value[0]);
                      });
                  }
                  if(data.status == 0){
                    // window.location.href = "{{url('Staff/menus')}}";
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
 <script>
function CheckStatus(a){
  if(a.checked){
    $('.varient_sizes').show();
    $('#normal_price').hide();
    $('#price').val('');
  }else{
    $('.varient_sizes').hide();
    $('#normal_price').show();
    $('#menu_price').val('');
  }
}

  function showSizes(a){
    var cat_id = $(a).val();
    $.ajax({
      type: 'get',
      url: '{{url('Staff/add_id')}}',
      data: {'cat_id':cat_id},       
      success: function (data) {
          $('#size_data').html(data.message);             
      },          
    });
  }
  </script> 
  <script>
    $(document).ready(function(){
      $('#category').on('change',function(){
        var cat_id = $(this).val();
        if($(this).val()) $('#size_data').show();
        else $('#size_data').hide();
        $.ajax({
          type: 'get',
          url: '{{url('Staff/show_sub_category')}}',
          data: {'cat_id':cat_id},       
          success: function (data) {
            console.log(data)
            if(data.status ==1 ){
              $('#selectCategory').html(data.message); 
              $('#size_data').html('');             
            }else if(data.status ==2){
              $('#size_data').html(data.message); 
              $('#selectCategory').html('');
            }
          },          
        });
      });

     

    });

    </script>
<script>

$(document).ready(function() {
     
  $('#submitForm1').click( function (e) {
    e.preventDefault();
  
    // alert('hh');
    var form = $('#csv_form')[0];
    var data = new FormData(form);
  // alert(data);
    $.ajax({
        type: 'POST',
        url: '{{url('Staff/add_csv')}}',
        dataType: 'json',
        data: data,  
        cache: false,
        contentType: false,
        processData: false,      
        success: function (data) {
          // if(data.status == 1){
          //  Swal.fire(
          //     'Good job!',
          //     'Menu Added!',
          //     'success'
          //   )
          //   location.reload();   
          //   }
          //   else{
          //     console.log(data)
          //   } 
          //   if(data.status == 0)
          //  {
          //   toastr["error"](data.message, "Error");
          //  }  
          console.log(data);    
          location.reload();          
        },
        error: function (data) {
          // console.log(data);     
        }
    });
  });
});
</script>