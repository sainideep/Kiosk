@extends('Staff.Layout.App')
@section('bg-gradient-primary','active')
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
                <h6 class="text-white text-capitalize ps-3">{{$category->category_name}} / {{$category->category_italian_name}}</h6>
                <div class="col-5" style="text-align: right; margin-left: 59%;">
                <button type="button" class="btn mt-2" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="width: max-content;background: beige; color: black;font-size: 13px;"><b>Add Sub Category</b></button>
                <button onclick="window.location.href='{{url('Staff/category')}}'" type="button" class="btn mt-2" data-toggle="modal" data-target="" data-whatever="@mdo" style="width: max-content;background: beige; color: black;margin-left: 20;;font-size: 13px;"><b>Back</b></button>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive" style="padding: 3px 20px;padding-top: 97px;height: 461px;overflow-y: scroll;">
                <table class="table align-items-center mb-0" id="table_id" style="width: 991px !important;">
                  <thead>
                    <tr>
                      <th class="text-secondary text-xxs font-weight-bolder ">Id</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">SUB CATEGORY (en)</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">SOTTO CATEGORIA (it)</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">SIZES (en)</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">TAGLIE (it)</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder " >Action</th>                     
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
          <h5 class="modal-title" id="exampleModalLabel">Add Sub Category</h5>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>   
      
        <div class="tab-content">
          <div id="home" class="tab-pane fade in active show">
            <div class="modal-body">
              <form action="{{url('Staff/add_category')}}" method="post"  id="form_sub_Cat">
                @csrf
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label" style="text-transform: inherit;">Sub Category Name (en)</label>
                  <input type="text" class="form-control @error('sub_category_en') is-invalid @enderror" placeholder="Enter English Name" name="sub_category_en" id="category" required="">
                  @error('sub_category_en')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('sub_category_en') }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label" style="text-transform: inherit;">Nome della sottocategoria (it)</label>
                  <input type="text" class="form-control @error('sub_category_itl') is-invalid @enderror" placeholder="Enter Italian Name" name="sub_category_itl" id="category" required="">
                  @error('sub_category_itl')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('sub_category_itl') }}</strong>
                  </span>
                  @enderror
                </div>  
                 <div class="form-check mb-3" style="padding-left: 0px !important">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" onclick="CheckStatus(this)" value="1" name="checkbox" id="sizecheckbox" >
                    Have  Different  Sizes Varient
                  </label>
                </div >
                <div class="form-group" id="show_sizes" style="display: none">
                 <label for="">Size</label>
                 <select class="js-example-basic-multiple" name="sizes[]" multiple="multiple" style="width: 100%">
                  <option value="Small/Piccolo">Small</option>
                  <option value="Medium/Medio">Medium</option>
                  <option value="Large/Grande">Large</option>
                  <option value="Half_Plate/Mezzo_Piatto">Half Plate</option>
                  <option value="Full_Plate/Piatto_Pieno">Full Plate</option>
                </select>
               </div> 
                <input type="hidden" value="{{$category->id}}" name="category_id"/>                    
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn bg-gradient-primary" id="submitForm">Add Sub Category</button>
                </div>
              </form>
            </div>
          </div>
         
       
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
        ajax: "{{ url('Staff/view_Category',$category->id) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false},
            {data: 'sub_cat_name'},
            {data: 'sub_cat_name_italian'},
            {data: 'sizes_en'},
            {data: 'sizes_itl'},
            {
              data: 'action', searchable: false
            },
        ]
    });
});

</script>

 <script type="text/javascript">
$(document).ready(function() {
  $('#form_sub_Cat').on('submit', function (e) {
  
  e.preventDefault();
  var data = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '{{url('Staff/add_sub_category')}}',
        dataType: 'json',
        data: data,  
        cache: false,
        contentType: false,
        processData: false,      
        success: function (data) {
          Swal.fire(
            'Good job!',
            'Sub Category Added!',
            'success'
          )
          location.reload();
           
        },
        error: function (data) {
            // alert(data);
        }
    });
  });
});
function CheckStatus(a){
  if(a.checked){
    $('#show_sizes').show();
  }else{
    $('#show_sizes').hide();
  }
}
</script>
<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
  </script>