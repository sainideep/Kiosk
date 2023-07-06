@extends('Staff.Layout.App')
@section('bg-gradient','active')
@section('main_section')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
     <div class="container-fluid py-1 px-3">
       <nav aria-label="breadcrumb">
         
             <h6 class="font-weight-bolder mb-0">Edit Menu </h6>
         
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
               <h6 class="text-white text-capitalize ps-3">Edit Menu</h6>
             </div>
           </div>
           <div class="card-body px-0 pb-2">
             <div class="table-responsive " style="padding: 3px 20px">
              <form action="{{url('Staff/edit_menus/update')}}/{{$menus->id}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Category Name</label>
                  <input type="text" class="form-control" readonly="" name="category" id="category"  value="{{$menus->getDetail->category_name}}">              
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Item Name</label>
                  <input type="text" class="form-control @error('item_name') is-invalid @enderror" name="item_name" id="item_name"  value="{{$menus->item_name}}">
                  @error('item_name')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('item_name') }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Articolo Nome italiano</label>
                  <input type="text" class="form-control @error('item_italian_name') is-invalid @enderror" name="item_italian_name" id="item_name"  value="{{$menus->item_italian_name}}">
                  @error('item_italian_name')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('item_italian_name') }}</strong>
                  </span>
                  @enderror
                </div>
                @if($menus->size_varient == 1)
                  <div class="form-group">                 
                    @foreach ($menus->data as $item)
                      <label for="">{{$item->menu_size}} / {{$item->menu_size_italian}} </label>                    
                      <input type="text" name="price[]" id="" class="form-control  @error('price') is-invalid @enderror" value="{{$item->price}}" />
                      <input type="hidden" name="price_id[]" id="" class="form-control  @error('price') is-invalid @enderror" value="{{$item->id}}" />
                      @error('price')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    @endforeach
                  </div>
                @else
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Item Price(*)</label>
                  <input type="text" class="form-control @error('item_price') is-invalid @enderror" name="item_price" id="item_price"  value="{{$menus->item_price}}">
                  @error('item_price')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> 
                @endif  
                @if($menus->size_varient == 1)
                <div class="form-check" style="padding-left: 0px">
                  <input type="checkbox" class="form-check-input" name="" id="checkedValue" value="{{$menus->id}}" data-subCat_id="{{$menus->sub_cat_id}}">
                  <label class="form-check-label"> Update Sizes</label>            
                </div>
                @endif    
                <div class="list-group" id="show_category_size">

          
                </div>  
                <div class="form-group">
                  <label for="">Description(en)</label>
                  <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" required="" value="">{{$menus->description}}</textarea>
                  @error('description')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('description') }}</strong>
                  </span>
                  @enderror
                </div>   
                <div class="form-group">
                  <label for="">Descrizione(it)</label>
                  <textarea class="form-control @error('description') is-invalid @enderror" name="descriptionit" id="description" rows="3" required="" value="">{{$menus->description_it}}</textarea>
                  @error('description')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('description') }}</strong>
                  </span>
                  @enderror
                </div>         
                <div class="form-group">
                  <label for="">Item Image</label>
                  <input type="file" class="form-control-file @error('image') is-invalid @enderror" name="Newimage" id="Newimage"  value="">
                  <input type="hidden" value ="{{$menus->item_image}}" name="oldImage"/>
                  <img src="{{$menus->item_image}}" style="height: 60px; width: 50px;padding-top: 10px;">
                </div>                 
                <a href="{{url('Staff/menus')}}" class="btn btn-secondary">Close</a>            
                  <button type="submit" class="btn bg-gradient-primary">Edit</button>               
              </form>
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
  @endsection
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>  
  $(document).ready(function(){
  $('body').removeAttr('style');
$('#checkedValue').change(function(){
  if($(this).prop('checked')){
    var menu_id = $(this).val();
    $('#show_category_size').show();
  }
  else{
    $('#show_category_size').hide();
  }
  if ($(this).prop('checked')) {
    // var menu_id = $(this).val();
    $.ajax({
          url: '{{ url('Staff/get_category_sizes') }}',
          type: "get",
          data: {'menu_id':menu_id, 'sub_cat_id': $(this).attr('data-subcat_id')},
          async: true,
          success: function(data){
           $('#show_category_size').html(data.message);            
        console.log(data);
         
       }
 
});
}
});
  });
  </script>
  
         
       
  

  