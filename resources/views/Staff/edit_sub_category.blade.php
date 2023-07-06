@extends('Staff.Layout.App')
@section('bg-gradient-primary','active')
@section('main_section')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
     <div class="container-fluid py-1 px-3">
       <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Edit Sub Category </h6>         
         </div>
       </nav>
     </div>
   </nav>
   <!-- End Navbar --> 
   <div class="container-fluid ">
      <div class="col-6">
         <div class="card my-4">
           <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
             <div class="bg-gradient-primary shadow-primary border-radius-lg pt-1 pb-1">
               <h6 class="text-white text-capitalize ps-3">Edit Sub Category</h6>
             </div>
           </div>
           <div class="card-body px-0 pb-2">
             <div class="table-responsive " style="padding: 3px 20px">
               
    <form action="{{url('Staff/edit_sub_category/update')}}/{{$sub_cat->id}}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" value="{{$sub_cat->id}}" name="sub_category_id">
      <div class="form-group">
        <label for="recipient-name" class="col-form-label">Sub Category Name (En)</label>
        <input type="text" class="form-control @error('sub_categoryEn') is-invalid @enderror" name="sub_categoryEn" id="category"  value="{{$sub_cat->sub_cat_name}}">
        @error('sub_categoryEn')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('sub_categoryEn') }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="recipient-name" class="col-form-label">Nome della sottocategoria (It)</label>
        <input type="text" class="form-control @error('sub_categoryItl') is-invalid @enderror" name="sub_categoryItl" id="category"  value="{{$sub_cat->sub_cat_name_italian}}">
        @error('sub_categoryItl')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('sub_categoryItl') }}</strong>
        </span>
        @enderror
      </div>  
       @if($sub_cat->check_varient == 0)
      <div>
        <div class="form-check mb-3" style="padding-left: 0px !important">
          <label class="form-check-label">
            <input type="checkbox" class="form-check-input" onclick="CheckStatus(this)" value="1" name="checkbox" id="sizecheckbox" >
            Have  Different Sizes Varient
          </label>
        </div >
        <div class="form-group" id="show_sizes" style="display: none">
           <label for="">Size</label>
           <select class="js-example-basic-multiple @error('sizes') is-invalid @enderror" name="sizes[]" id="select_element" multiple="multiple" style="width: 100%">
            <option value="Small/Piccolo">Small</option>
            <option value="Medium/Medio">Medium</option>
            <option value="Large/Grande">Large</option>
            <option value="Full_Plate/Piatto_Pieno">Full Plate</option>
            <option value="Half_Plate/Mezzo_Piatto">Half Plate</option>
          </select>
        </div>
        @error('sizes')
        <span class="alert"  style="color:red" role="alert">
          <p>{{ $message }}</p>
        </span>
        @enderror
      </div>
      @else     
         <div class="form-group" id="show_sizes" >
           <label for="">Size</label>
           <select class="js-example-basic-multiple" name="sizes[]" id="select_element_new" multiple="multiple" style="width: 100%">
            <option value="Small/Piccolo">Small</option>
            <option value="Medium/Medio">Medium</option>
            <option value="Large/Grande">Large</option>
            <option value="Half_Plate/Mezzo_Piatto">Half Plate</option>
            <option value="Full_Plate/Piatto_Pieno">Full Plate</option>
          </select>
        </div>
      @endif
  
        <a href="{{url('Staff/view_Category',$sub_cat->category_id)}}" class="btn btn-secondary">Close</a>
        <button type="submit" class="btn bg-gradient-primary">Edit</button>
     
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

  @endsection
  @section('main_script')
   <script type="text/javascript">
    function CheckStatus(a){
      if(a.checked){
        $('#show_sizes').show();
      }else{
        $('#show_sizes').hide();
      }
    }
    var text = "{{$sub_cat->sizes}}";
    var category_sizes = text.split(" ");
    $('.js-example-basic-multiple').select2();
    $('#select_element_new').val(category_sizes).trigger('change');
   </script>
 @endsection
