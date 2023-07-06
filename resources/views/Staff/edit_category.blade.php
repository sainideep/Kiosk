@extends('Staff.Layout.App')
@section('bg-gradient-primary','active')
@section('main_section')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
     <div class="container-fluid py-1 px-3">
       <nav aria-label="breadcrumb">
             <h6 class="font-weight-bolder mb-0">Edit Category </h6>         
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
               <h6 class="text-white text-capitalize ps-3">Edit Category</h6>
             </div>
           </div>
           <div class="card-body px-0 pb-2">
             <div class="table-responsive " style="padding: 3px 20px">
               
    <form action="{{url('Staff/edit_category/update')}}/{{$category->id}}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" value="{{$category->id}}" name="category_id">
      <div class="form-group">
        <label for="recipient-name" class="col-form-label">Category Name</label>
        <input type="text" class="form-control @error('categoryEn') is-invalid @enderror" name="categoryEn" id="category"  value="{{$category->category_name}}">
        @error('categoryEn')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('categoryEn') }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="recipient-name" class="col-form-label">Categoria Nome italiano</label>
        <input type="text" class="form-control @error('categoryItl') is-invalid @enderror" name="categoryItl" id="category"  value="{{$category->category_italian_name}}">
        @error('categoryItl')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('categoryItl') }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="">Category Image</label>
        <input type="file" class="form-control-file @error('image') is-invalid @enderror" name="Newimage" id="image" value="{{$category->image}}">
        <input type="hidden" value ="{{$category->image}}" name="oldImage"/>
        <img src="{{ $category->image }}" style="height: 50px; width: 50px">
        @error('image')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
  
        <a href="{{url('Staff/category')}}" class="btn btn-secondary">Close</a>
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
