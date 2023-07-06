<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Staff;
use App\Models\Category;
use App\Models\Menus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Subcat;
use Validator;
use DB;
use File;
use DataTables;
use Carbon\Carbon;
use SoftDeletes;

class StaffController extends Controller
{
    function login() {
            
    	return view('Staff.Auth.sign_in');
   }

   function staff_login(Request $Request) {
   		$Request->validate([
            'email'       => 'required',
            'password'      => 'required',
        ]);        
        $credentials = [
            'email' => $Request['email'],
            'password' => $Request['password'],
        ];         
            
        if(Auth::guard('staff')->attempt($credentials)){
            
            return redirect('Staff/dashboard');
        }
        else{
            return back()->with('message','Credentials do not match');
        }
    }

    function dashboard(){
        $categories = Category::where('staff_id',Auth::guard('staff')->id())->count();
        $menus = Menus::where('staff_id',Auth::guard('staff')->id())->count();
        $orders = Order::where('staff_id',Auth::guard('staff')->id())->count();
        return view('Staff.dashboard',compact('categories','menus','orders'));
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('Staff/login');
    }
    public function category(Request $request)
    {
        if ($request->ajax()) {
            $data = category::where('staff_id',Auth::guard('staff')->id())->latest('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()   
                ->addColumn('image', function($row){                 
                       
                    return '<img src="'.$row->image.'" height="61px" width="62px">
                       ';;
                })                  
                ->addColumn('sub_categories', function($row){   
                    $sizes = DB::table('manage_sub_category')->where('category_id',$row->id)->get();
                    if(count($sizes) > 0 ){
                        $varient = "<ul type='none' style='margin-left:-20px'>";
                        foreach ($sizes as  $value) {
                           $varient .= "<li>".$value->sub_cat_name."</li>";
                        }
                        $varient .= "</ul>";
                    }else{
                        $varient = "No Sub Categories";
                    }           
                    return $varient;
                })
                 ->addColumn('sub_categories_tl', function($row){   
                    $sizes = DB::table('manage_sub_category')->where('category_id',$row->id)->get();
                    if(count($sizes) > 0 ){
                        $varient = "<ul type='none' style='margin-left:-20px'>";
                        foreach ($sizes as  $value) {
                           $varient .= "<li>".$value->sub_cat_name_italian."</li>";
                        }
                        $varient .= "</ul>";
                    }else{
                        $varient = "Nessuna sottocategoria";
                    }           
                    return $varient;
                })                       
                ->addColumn('action', function($row){                  
                    $confirm = "return confirm('Are you sure?')";   
                    return '<div><a href="'.url('Staff/edit_category',$row->id).'"><i class="material-icons">edit</i></a>
                    <a href="'.url('Staff/delete_category',$row->id).'" ><i class="material-icons"  onclick="'.$confirm.'">delete</i></a><a href="'.url('Staff/view_Category',$row->id).'"><i class="material-icons">remove_red_eye</i></a></div>';
                })
                ->addColumn('status', function($row){
                    $sign = $row->status == 0 ? 'checked' : '';
                    $signenable = $row->status == 1 ? 'checked' : '';

                    $status = '<div style="margin-left:50px; padding:3px"><div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox"  "'.$signenable .'" onclick="show('.$row->id.')" id="flexSwitchCheckChecked"  '.$signenable.'  style="margin-right:32px;">
                        </div></div>';
                       
                    return $status;
                })
                ->rawColumns(['action','image','sub_categories','sub_categories_tl','status'])
                ->make(true);
        }
       
        return view('Staff.category');
    }
    public function change_status(Request $request){
        $validator = Validator::make($request->all(), [ 
          'cat_id'  => 'required',
        ]);
        if ($validator->fails()) { 
          return response()->json([
            'status'=>'1',
            'message'=>$validator->errors(),
          ]);          
        }
        try{
            DB::beginTransaction();          
            $result = Category::where('id',$request->cat_id)->first();
            // dd($result);
            
            if($result->status == 0){
                $cat['status'] = 1;
            }else{
                $cat['status'] = 0;
            }
            Category::where('id',$request->cat_id)->update($cat);
            DB::commit();
            return response()->json([
                'status'=>'0',
                'message'=>'done',
            ]);

        }
        catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status'=>'1',
                'message'=>$e->getMessage(),
            ]);
        }
    }

    public function Sub_category(Request $request, $id){

        if ($request->ajax()) {
            $data = DB::table('manage_sub_category')->where('staff_id',Auth::guard('staff')->id())->where('category_id',$id)->latest('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()   
                ->addColumn('category_id', function($row){               
                    return Category::where('id',$row->category_id)->value('category_name');
                })  
                ->addColumn('sizes_en', function($row){   
                    $sizes = DB::table('sub_category_size')->where('sub_cat_id',$row->id)->get();
                    if(count($sizes) > 0 ){
                        $varient = "<ul type='none' style='margin-left:-20px'>";
                        foreach ($sizes as  $value) {
                           $varient .= "<li>".$value->size_en."</li>";
                        }
                        $varient .= "</ul>";
                    }else{
                        $varient = "No Size Varient";
                    }           
                    return $varient;
                })  
                ->addColumn('sizes_itl', function($row){   
                    $sizes = DB::table('sub_category_size')->where('sub_cat_id',$row->id)->get();
                    if(count($sizes) > 0 ){
                        $varient = "<ul type='none' style='margin-left:-20px'>";
                        foreach ($sizes as  $value) {
                           $varient .= "<li>".$value->size_itl."</li>";
                        }
                        $varient .= "</ul>";
                    }else{
                        $varient = "Nessuna variante di taglia";
                    }           
                    return $varient;
                })                
                ->addColumn('action', function($row){                  
                       
                    return '<div><a href="'.url('Staff/edit_sub_category',$row->id).'"><i class="material-icons">edit</i></a>
                    <a href="'.url('Staff/delete_sub_category',$row->id).'"><i class="material-icons">delete</i></a></div>';
                })
                ->rawColumns(['action','sizes_en','sizes_itl'])
                ->make(true);
        }
        $category = Category::find($id);
        return view('Staff.sub_category',compact('category'));
    }

    public function add_sub_category(Request $request)
    {
       
        $validator = Validator::make($request->all(), [ 
          'sub_category_en'                    => 'required',
          'sub_category_itl'                   => 'required',
          'category_id'                        => 'required',
          'sizes'                              => 'required_if:checkbox,==,1',
        ]);
        if ($validator->fails()) { 
          return response()->json([
            'status'=>'0',
            'message'=>$validator->errors(),
          ]);          
        }
        try
        {
            DB::beginTransaction();
            $sub_category['staff_id']               = Auth::guard('staff')->user()->id;
            $sub_category['category_id']            = $request->category_id;
            $sub_category['sub_cat_name']           = $request->sub_category_en;
            $sub_category['sub_cat_name_italian']   = $request->sub_category_itl;
            $subId = DB::table('manage_sub_category')->insertGetId($sub_category);  
            if($request->sizes) {       
                foreach($request->sizes as $size)
                {
                    $data = explode('/',$size);
                    DB::table('sub_category_size')->insert([
                        'size_en'       => $data[0],
                        'sub_cat_id'    => $subId,
                        'size_itl'      => $data[1]
                    ]);  
                         
                } 
            }
            DB::commit();
            return response(['status' => 1, 'message' => 'saved']);
        }
        catch(Exception $e)
        {
            DB::rollback();
            return response()->json([
                'status'=>'0',
                'message'=> $e->getMessage(),
            ]);
        }
    }
    public function add_category(Request $request)
    {   
        $validator = Validator::make($request->all(), [ 
            'categoryEn'       => 'required',
            'categoryItl'      => 'required',
            'image'            => 'required',
          ]);
          if ( $validator->fails()) { 
            return response()->json([
                'status'=>'0',
                'message'=>$validator->errors()->first(),
            ]);          
        }           
        try
        {
            DB::beginTransaction();           
            $categories                         = New Category;
            $categories->staff_id               = Auth::guard('staff')->id();
            $categories->category_name          = $request->input('categoryEn');  
            $categories->category_italian_name  = $request->input('categoryItl');         
            if($request->hasfile('image'))
            {
                $file = $request->image;
                $path = storage_path().'/staff/'.Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id;
                File::makeDirectory($path, $mode = 0777, true, true);
                $imagePath = storage_path().'/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id;         
                $post_image        = time().$file->getClientOriginalName();
                $image_url          = 'https://phpstack-102119-2434585.cloudwaysapps.com//storage/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/'. $post_image;   
                $file->move($imagePath, $post_image);
            }
            $categories->image                  = $image_url;
            $categories->status                 = '1';
            $categories->save();           
            DB::commit();
            return response()->json([
                'status'=>'1',
                'message'=>'Category Added',
                
            ]);        
        }
        catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status'=>'0',
                'message'=>'Event not added',
            ]);
        }     
    }
    
    public function edit_sub_category($id){
        if($id){
            $sub_cat = DB::table('manage_sub_category')->where('id',$id)->first();
            $size = DB::table('sub_category_size')->where('sub_cat_id',$id)->pluck('size_itl','size_en');
            $data = '';
            if($size){
                foreach ($size as $key => $value) {                    
                    $data .= $key.'/'.$value .' ' ;
                }   
            }
            $sub_cat->sizes = $data;
            $sub_cat->check_varient = DB::table('sub_category_size')->where('sub_cat_id',$id)->exists() ? 1 : 0; 
            return view('Staff.edit_sub_category',compact('sub_cat'));
        }
    }

    public function update_sub_category(Request $request){
        $request->validate([
            'sub_category_id'         => 'required',
            'sub_categoryEn'          => 'required',
            'sub_categoryItl'         => 'required', 
            'sizes'                   => 'required_if:checkbox,==,1',          
        ]);  
        if(!$request->sizes){
            DB::table('sub_category_size')->where('sub_cat_id',$request->sub_category_id)->delete();
        } 
        if(!$request->checkbox && $request->sizes)
        {
            DB::table('sub_category_size')->where('sub_cat_id',$request->sub_category_id)->delete();
            foreach ($request->sizes as $size) {
                $data = explode('/',$size);
                DB::table('sub_category_size')->insert([
                    'size_en'       => $data[0],
                    'sub_cat_id'    => $request->sub_category_id,
                    'size_itl'      => $data[1]
                ]); 
            }
        }     
        $sub_category['sub_cat_name']                  = $request->sub_categoryEn;
        $sub_category['sub_cat_name_italian']          = $request->sub_categoryItl;
        DB::table('manage_sub_category')->where('id',$request->sub_category_id)->update($sub_category);
        if($request->checkbox == 1){
            foreach($request->sizes as $size)
                {
                    $data = explode('/',$size);
                    DB::table('sub_category_size')->insert([
                        'size_en'       => $data[0],
                        'sub_cat_id'    => $request->sub_category_id,
                        'size_itl'      => $data[1]
                    ]);                         
                } 
        }
        $catid = DB::table('manage_sub_category')->where('id',$request->sub_category_id)->first();
        return redirect('Staff/view_Category/'.$catid->category_id);     
    }

    public function edit_category(Category $category){
        if($category){
               
            return view('Staff.edit_category',compact('category'));
        }
    }

    public function update_category($id,Request $request)
    {       
        $request->validate([
            'category_id'         => 'required',
            'categoryEn'          => 'required',
            'categoryItl'         => 'required',
        ]); 
          
        $image_url = $request->oldImage;
        if($request->Newimage){
           $img =  explode('/', $request->oldImage);
           $pathExits = storage_path().'/staff/'.$img[6].'/'.$img[7];           
            if (File::exists($pathExits)) {
              unlink($pathExits);
            } 
            $file = $request->Newimage;
            $path = storage_path().'/staff/'.Auth::guard('staff')->user()->name;
            File::makeDirectory($path, $mode = 0777, true, true);
            $imagePath = storage_path().'/staff/'. Auth::guard('staff')->user()->name;         
            $post_image        = time().$file->getClientOriginalName();
            $image_url          = 'https://phpstack-102119-2434585.cloudwaysapps.com//storage/staff/'. Auth::guard('staff')->user()->name .'/'. $post_image;   
            $file->move($imagePath, $post_image);
        }

        $categories = Category::find($id);
        $categories->category_name              = $request->categoryEn;
        $categories->category_italian_name      = $request->categoryItl;
        $categories->image                      = $image_url;
        if($categories->save()){
            return redirect('Staff/category');
        }else{
            return back()->with('error',"Please try again");
        }

    }

    public function delete_category(Category $Category)
    {
        $img =  explode('/', $Category->image);
        $pathExits = storage_path().'/staff/'.$img[6].'/'.$img[7];           
        if (File::exists($pathExits)) {
          unlink($pathExits);
        } 
        $Category->delete();
        DB::table('manage_sub_category')->where('category_id',$Category->id)->delete();
        DB::table('menu_items')->where('category_id',$Category->id)->delete();
        return redirect()->back();
    }
    public  function hide_category($id)
    {
        // $users = $users->makeHidden(['address', 'phone_number']);
        $data = DB::table('category')->where('id','!=',$id)->softDeletes();
        // dd($data);
    }

    public function delete_sub_category($id)
    {
        DB::table('sub_category_size')->where('sub_cat_id',$id)->delete();
        DB::table('manage_sub_category')->where('id',$id)->delete();
        DB::table('menu_items')->where('sub_cat_id',$id)->delete();
        
        return redirect()->back();
    }

    public function menus(Request $request)
    {
         $categories = Category::select('id','category_name','category_italian_name')->where('staff_id',Auth::guard('staff')->user()->id)->get();
        
        if ($request->ajax()) {
            $data = Menus::where('staff_id',Auth::guard('staff')->id())->orderBy('category_id','Asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()   
                ->addColumn('category_name', function($row){               
                       
                    return Category::where('id',$row->category_id)->value('category_name');
                }) 
                ->addColumn('sub category_name', function($row){               
                       
                    $subcat = DB::table('manage_sub_category')->where('id',$row->sub_cat_id)->value('sub_cat_name');
                    if($subcat){
                        return $subcat;
                    }else{
                        return 'No Sub Categories';
                    }
                    return $subcat;
                }) 
                ->addColumn('image', function($row){   
                                  
                    return '<img src="'.$row->item_image.'" height="50px" width="50px" style="margin-left:10px;">
                       ';;
                }) 
                ->addColumn('price', function($row){  
                    if($row->item_price){
                        $price = '<b style="margin-left:48px">€ '. number_format($row->item_price,2) .'</b>';
                    } 
                    else{
                        $list = DB::table('menu_size_price')->where('menu_id',$row->id)->get();
                        $data = '<ul>';
                        foreach ($list as  $value) {
                            $data .= '<li>'.$value->menu_size.':€ '.number_format($value->price,2) .'</li>';
                        }
                        $data .= '</ul>';
                        $price = $data;
                    }              
                       
                    return  $price;
                }) 
                       
                ->addColumn('action', function($row){                  
                    $confirm = "return confirm('Are you sure?')";  
                    return '<div><a href="'.url('Staff/edit_menus',$row->id).'"><i class="material-icons">edit</i></a>
                    <a href="'.url('Staff/delete_menus',$row->id).'"><i class="material-icons" onclick="'.$confirm.'">delete</i></a></div>';
                })
                ->addColumn('status', function($row){
                    $sign = $row->status == 0 ? 'checked' : '';
                    $signenable = $row->status == 1 ? 'checked' : '';

                    $status = '<div style="margin-left:50px; padding:3px"><div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" "'.$signenable .'" onclick="show('.$row->id.')" id="flexSwitchCheckChecked"  '.$signenable.'  style="margin-right:36px;">
                        </div></div>';
                       
                    return $status;
                })
                ->rawColumns(['action','image','price','status','subcat'])
                ->make(true);
            
        }
       
        return view('Staff.menus',compact('categories'));
    }
    public function change_menu_status(Request $request){
        $validator = Validator::make($request->all(), [ 
          'menu_id'  => 'required',
        ]);
        if ($validator->fails()) { 
          return response()->json([
            'status'=>'1',
            'message'=>$validator->errors(),
          ]);          
        }
        try{
            DB::beginTransaction();          
            $result = Menus::where('id',$request->menu_id)->first();
            // dd($result);
            
            if($result->status == 0){
                $menu['status'] = 1;
            }else{
                $menu['status'] = 0;
            }
            Menus::where('id',$request->menu_id)->update($menu);
            DB::commit();
            return response()->json([
                'status'=>'0',
                'message'=>'done',
            ]);

        }
        catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status'=>'1',
                'message'=>$e->getMessage(),
            ]);
        }
    }
    public function add_menus(Request $request)
    { 
        $validator = Validator::make($request->all(), [ 
            'nameEn'     => 'required',
            'nameItl'    => 'required',
            'image'      => 'required|image|mimes:jpg,png,jpeg',
            'category'   => 'required',
            'description'   => 'required',
            'descriptionit'   => 'required',
        ]);
        if ($validator->fails()) { 
          return response()->json([
            'status'=>'0',
            'message'=>$validator->errors()->first(),
          ]);          
        } 
        if($request->menu_price && !$request->price){
            if(empty(array_filter($request->menu_price))){
                return response()->json([
                    'status'=>'0',
                    'message'=>'Please select price',
                  ]);
            }
        } 
        try
        {
            DB::beginTransaction();  
            $menus =  New Menus;
            $menus->restor_id           = Auth::guard('staff')->user()->restor_id;
            $menus->staff_id            = Auth::guard('staff')->user()->id;
            $menus->category_id         = $request->input('category');
            $menus->sub_cat_id          = $request->input('sub_cat_id');
            $menus->item_name           = $request->input('nameEn');
            $menus->item_italian_name   = $request->input('nameItl');
            $menus->item_price          = $request->input('price');
            $menus->description         = $request->input('description');
            $menus->description_it      = $request->input('descriptionit');
            if($request->hasfile('image'))
            {
                $file = $request->image;
                $path = storage_path().'/staff/'.Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id;
                File::makeDirectory($path, $mode = 0777, true, true);
                $imagePath = storage_path().'/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id;         
                $post_image        = time().$file->getClientOriginalName();
                $image_url          = 'https://phpstack-102119-2434585.cloudwaysapps.com//storage/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/'. $post_image;   
                $file->move($imagePath, $post_image); 
            }
            $menus->item_image            = $image_url;
            $menus->save();
            $id                           = $menus->id;
            if($request->menu_size && $request->menu_price){
                $array = array_combine($request->menu_size,$request->menu_price);
                if($array)  {
                    foreach($array as $size => $key)
                    {
                        $sizes = explode('/',$size);
                        if($key) {           
                            DB::table('menu_size_price')->insert([
                                'menu_id'  => $id,
                                'menu_size'  => $sizes[0],
                                'price'   => $key,
                                'menu_size_italian' => $sizes[1]
                            ]);
                        } 
                    }
                }  
            }    
            DB::commit();
            return response(['status' => 1 , 'message' => 'saved']);  
        }
        catch(Exception $e){
            DB::rollback();
            return response(['status' => 0 , 'message' => $e->getMessage()]); 

        }
        
    }
    public function edit_menus($id)
    {
       
        $menus = Menus::with(['getDetail'])->find($id);
        if($menus->sub_cat_id){
           
        }
        $menus->data = DB::table('menu_size_price')->where('menu_id',$id)->get();
        $menus->size_varient = DB::table('menu_size_price')->where('menu_id',$id)->exists() ? 1 : 0; 
        // $menus->more_cat = DB::table('sub_category_size')->where('sub_cat_id',$id)->exists() ? 1 : 0;
        // dd($menus->data);      
        return view('Staff.edit_menus',compact('menus'));
    }

    public function get_category_sizes(Request $request){

        if($request->sub_cat_id)
        {
            $ids = [];
            $exist_size = DB::table('menu_size_price')->where('menu_id',$request->menu_id)->first();
            if($exist_size){
                $ids = DB::table('menu_size_price')->where('menu_id',$request->menu_id)->pluck('menu_size');
            }
          
            $dataValue = DB::table('sub_category_size')->where('sub_cat_id',$request->sub_cat_id)->whereNotIn('size_en',$ids)->get();
            $data = '';
            if(count($dataValue) > 0){
                foreach($dataValue as $value)
                {              
                    $data .=  '<div class="row mb-3 varient_sizes" ><label for="recipient-name" class="col-form-label">Enter Size Varient Price</label><div class="col-md-6" id="item_size" class="" ><input type="text" class="form-control" name="menu_size[]" id="menu_size" readonly value="'.$value->size_en.'/'.$value->size_itl.'" ></div><div class="col-md-6" id="item_size"><input  type="text" class="form-control" placeholder="Enter '.$value->size_en.'/'.$value->size_itl.' Price" name="menu_price[]"  id="menu_price" value=""></div></div>';
                }
                return response()->json([
                    'status'=>'1',
                    'message'=>$data,
                ]);    
            }  
                  

        }

    }

    public function show_sub_category(Request $request)
    {
        
        $validator = Validator::make($request->all(), [ 
          'cat_id'                    => 'required',
        ]);
        if ($validator->fails()) { 
          return response()->json([
            'status'=>'0',
            'message'=>$validator->errors(),
          ]);          
        }
        try
        {
            $sub_category = DB::table('manage_sub_category')->where('category_id',$request->cat_id)->get();
            $data = '';
            if(count($sub_category)){
                $data = '<div class="form-group"><label for="">Select Sub Category</label><select class="form-control" id="sub_category" name="sub_cat_id" required onChange="showSizes(this)"><option value="">Select Sub-Category</option>';
                foreach ($sub_category as $value) {
                    $data .= '<option value="'.$value->id.'">'. $value->sub_cat_name .'/'. $value->sub_cat_name_italian .'</option>';
                }
                $data .= '</select></div>';
                return response()->json([
                    'status'=>'1',
                    'message'=>$data,
                ]);
            }
            else{
               $data .= '<div class="form-group" id="normal_price"><label for="recipient-name" class="col-form-label">Price(*)</label><input type="text" class="form-control" name="price" id="price" pattern="[0-9.]{1,}" required=""></div>';
               return response()->json([
                    'status'=>'2',
                    'message'=>$data,
                ]);
            }
            
        }
        catch(Exception $e){
            return response()->json([
                'status' =>'0',
                'message'=>$e->getMessage(),
            ]); 
        }
    }

    public function add_id(Request $request)
    {
        $sizes = DB::table('sub_category_size')->where('sub_cat_id', $request->input('cat_id'))->get();
        $data = '';
        if(count($sizes) > 0) 
        {    
            $data = '<div class="form-check mb-3" style="padding-left: 0px !important">
                  <label class="form-check-label"><input type="checkbox" class="form-check-input" onclick="CheckStatus(this)" value="1" name="checkbox" id="sizecheckbox">Have  Different Sizes Varient</label></div>';      
            foreach($sizes as $size){
            $data .=  '<div class="row mb-3 varient_sizes" style="display:none"><label for="recipient-name" class="col-form-label">Enter Size Varient Price</label><div class="col-md-6" id="item_size" class="" ><input type="text" class="form-control" name="menu_size[]" id="menu_size" readonly value="'.$size->size_en.'/'.$size->size_itl.'" ></div><div class="col-md-6" id="item_size"><input  type="text" class="form-control" placeholder="Enter '.$size->size_en.'/'.$size->size_itl.' Price" name="menu_price[]"  id="menu_price"></div></div>';
            }
            $data .= ' <div class="form-group" id="normal_price"><label for="recipient-name" class="col-form-label">Price</label><input type="text" class="form-control"  name="price" id="price" pattern="[^AZ az][0-9]{1,}" ></div>';
        }
        else{
            $data .= ' <div class="form-group"><label for="recipient-name" class="col-form-label">Price(*)</label><input type="text" class="form-control"  name="price" pattern="[0-9.]{1,}" id="price"></div>';
        }          
        return response()->json([
            'status'=>'1',
            'message'=>$data,
          ]);
    }

    public function update_menus($id,Request $request)
    {
        $request->validate([
            'item_name'  => 'required',
            'item_italian_name'  => 'required',            
        ]); 
        
        $array = $request->menu_price;  
              
        $menus = Menus::with(['getDetail'])->find($id);
        $menus->category_id = $menus->category_id;
        $menus->item_name = $request->item_name;
        $menus->item_italian_name = $request->item_italian_name;
        $menus->description = $request->description;
        $menus->description_it = $request->descriptionit;
        if($request->menu_price){
            if(array_filter($array)){
                $menus->item_price = null;
            }
            else
            {
                $menus->item_price = $request->item_price;
            }
        }else{
            $menus->item_price = $request->item_price;
        }
        
        $image_url = $request->oldImage;
        if($request->Newimage){
           $img =  explode('/', $request->oldImage);
           $pathExits = storage_path().'/staff/'.$img[6].'/'.$img[7];           
            if (File::exists($pathExits)) {
              unlink($pathExits);
            } 
            $file = $request->Newimage;
            $path = storage_path().'/staff/'.Auth::guard('staff')->user()->name;
            File::makeDirectory($path, $mode = 0777, true, true);
            $imagePath = storage_path().'/staff/'. Auth::guard('staff')->user()->name;         
            $post_image        = time().$file->getClientOriginalName();
            $image_url          = 'https://phpstack-102119-2434585.cloudwaysapps.com//storage/staff/'. Auth::guard('staff')->user()->name .'/'. $post_image;   
            $file->move($imagePath, $post_image);
        }
        $menus->item_image = $image_url;
        $menus->save();
        if($request->price_id && $request->price)
        {
           $array = array_combine($request->price_id,$request->price);    
            foreach ($array as $key => $value) {
                if($value){
                    DB::table('menu_size_price')->where('id',$key)->update(['price' => $value]);
                }else{
                    DB::table('menu_size_price')->where('id',$key)->delete();
                }
            }   
        }
        $id = $menus->id;
        if($request->menu_size && $request->menu_price){
            $array = array_combine($request->menu_size,$request->menu_price);
            if($array)  {
                foreach($array as $size => $key)
                {
                    $sizes = explode('/',$size);
                    if($key) {           
                        DB::table('menu_size_price')->insert([
                            'menu_id'  => $id,
                            'menu_size'  => $sizes[0],
                            'price'   => $key,
                            'menu_size_italian' => $sizes[1]
                        ]);
                    } 
                }
            }  
        }    
        return redirect('Staff/menus'); 
    }

    public function delete_menus($id)
    {
        Menus::find($id)->delete();
        return redirect()->back();
    }
    public function account()
    {
        return view('Staff.account');
    }
    public function account_issue(Request $request)
    {
        $request->validate([
            'issue'   => 'required',
            'description'  => 'required'
        ]); 
        $rest_id = Auth::guard('staff')->user()->restor_id;      
        $staff_id = Auth::guard('staff')->user()->id;
        DB::table('account_issue')->insert([
            'staff_id'  => $staff_id,
            'rest_id'  => $rest_id,
            'issue_title'   => $request['issue'],
            'description' => $request['description']
        ]); 
        return back()->with('status',"Saved");
    
    }

    public function banner(Request $request){
        if ($request->ajax()) {
            $data = DB::table('banner')->where('staff_id',Auth::guard('staff')->user()->id)->latest('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    if($row->type == 1){
                        return "<image src='".$row->banner_img	."' height='100px' width='100px'/>";
                    }
                    else{                        
                        return '<video controls style="height:100px;width:100px"> <source src="'.$row->banner_img.'" type="video/mp4"><source src="'.$row->banner_img.'" type="video/ogg">  </video>';;
                    }
                })
                ->addColumn('action', function($row){                   
                    $deleteurl = url("Staff/delete_banner",$row->id);
                    $actionBtn = '<a href="'.$deleteurl.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" style="margin-left:20px">
                          <i class="material-icons opacity-10">delete</i>
                        </a>';
                    return $actionBtn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        }
        $banner = DB::table('banner')->where('staff_id',Auth::guard('staff')->user()->id)->exists();        
        return view('Staff.banner',compact('banner'));
    }

    public function add_banner(Request $request){    

        $validator = Validator::make($request->all(), [ 
            'type'     => 'required',
            'image'    => 'required_if:type,==,1',
            'video'    => 'required_if:type,==,2',
        ]);
        if ($validator->fails()) { 
          return response()->json([
            'status'=>'0',
            'message'=>$validator->errors(),
          ]);          
        }   
       
        if($request->hasfile('image'))
        {
            $file = $request->image;
            $path = storage_path().'/staff/'.Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/banner/';
            File::makeDirectory($path, $mode = 0777, true, true);
            $imagePath = storage_path().'/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/banner/';         
            $post_image        = time().$file->getClientOriginalName();
            $image_url          = 'https://phpstack-102119-2434585.cloudwaysapps.com//storage/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/banner/'. $post_image;   
            $file->move($imagePath, $post_image);
        }

        if($request->hasfile('video'))
        {
            $file = $request->video;
            $path = storage_path().'/staff/'.Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/banner/';
            File::makeDirectory($path, $mode = 0777, true, true);
            $imagePath = storage_path().'/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/banner/';         
            $post_image        = time().$file->getClientOriginalName();
            $image_url          = 'https://phpstack-102119-2434585.cloudwaysapps.com//storage/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/banner/'. $post_image;   
            $file->move($imagePath, $post_image);
        }
        $image['type']              = $request->type;
        $image['staff_id']          = Auth::guard('staff')->user()->id;
        $image['banner_img']        = $image_url;
        DB::table('banner')->insert($image);
        return response(['status' => 1, 'message' => 'Saved']);
    }

    public function delete_banner($id){
        $banner = DB::table('banner')->where('id',$id)->first();       
        $img =  explode('/', $banner->banner_img);        
        $pathExits = storage_path().'/staff/'.$img[6].'/'.$img[7].'/'.$img[8];         
        if (File::exists($pathExits)) {
          unlink($pathExits);
        }
        DB::table('banner')->where('id',$id)->delete();
        return back();
    }

    public function deviceInfo(){
        return view('Staff.device_info');
    }
    public function manage_advertisement(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('advertisement')->where('staff_id',Auth::guard('staff')->user()->id)->latest('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    if($row->ad_type == 1){
                        return "<image src='".$row->ad_src	."' height='100px' width='100px' style='object-fit:cover'/>";
                    }
                    else{                        
                        return '<video controls style="height:100px;width:100px"> <source src="'.$row->ad_src.'" type="video/mp4"><source src="'.$row->ad_src.'" type="video/ogg"> </video>';;
                    }
                })
                ->addColumn('action', function($row){                   
                    $deleteurl = url("Staff/delete_advertisement",$row->id);
                    $actionBtn = '<a href="'.$deleteurl.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" style="margin-left:20px">
                          <i class="material-icons opacity-10">delete</i>
                        </a>';
                    return $actionBtn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        }
        $data = DB::table('advertisement')->where('staff_id',Auth::guard('staff')->user()->id)->exists();  
        return view('Staff.manage_advertisement',compact('data'));
    }
    public function add_advertisement(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'type'     => 'required',
            'image'    => 'required_if:type,==,1',
            'video'    => 'required_if:type,==,2',
        ]);
        if ($validator->fails()) { 
          return response()->json([
            'status'=>'0',
            'message'=>$validator->errors(),
          ]);          
        }   
       
        if($request->hasfile('image'))
        {
            $file = $request->image;
            $path = storage_path().'/staff/'.Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/advertisement/';
            File::makeDirectory($path, $mode = 0777, true, true);
            $imagePath = storage_path().'/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/advertisement/';         
            $post_image        = time().$file->getClientOriginalName();
            $image_url          = 'https://phpstack-102119-2434585.cloudwaysapps.com//storage/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/advertisement/'. $post_image;   
            $file->move($imagePath, $post_image);
        }

        if($request->hasfile('video'))
        {
            $file = $request->video;
            $path = storage_path().'/staff/'.Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/advertisement/';
            File::makeDirectory($path, $mode = 0777, true, true);
            $imagePath = storage_path().'/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/advertisement/';         
            $post_image        = time().$file->getClientOriginalName();
            $image_url          = 'https://phpstack-102119-2434585.cloudwaysapps.com//storage/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/advertisement/'. $post_image;   
            $file->move($imagePath, $post_image);
        }
        $image['ad_type']              = $request->type;
        $image['staff_id']             = Auth::guard('staff')->user()->id;
        $image['ad_src']               = $image_url;
        DB::table('advertisement')->insert($image);
        return response(['status' => 1, 'message' => 'Saved']);
    }
    public function delete_advertisement($id)
    {
        $advertisement = DB::table('advertisement')->where('id',$id)->first();       
        $img =  explode('/', $advertisement->ad_src);        
        $pathExits = storage_path().'/staff/'.$img[6].'/'.$img[7].'/'.$img[8];         
        if (File::exists($pathExits)) {
          unlink($pathExits);
        }
        DB::table('advertisement')->where('id',$id)->delete();
        return back();
    }
    public function orders(Request $request)
    {
        //$orders = Order::with('orderItems')->get();
        if ($request->ajax()) {
            $data = DB::table('order_details')->where('staff_id',Auth::guard('staff')->id())->where('payment_status',1)->latest('id')->get();          
            return DataTables::of($data)
                ->addIndexColumn()  
                ->addColumn('order_id', function($row){                
                      
                     return '00'.$row->id;
                 })  
                ->addColumn('payment_status', function($row){               
                    return $row->payment_status == 1 ? '<span class="badge bg-secondary">Success</span>' : '<span class="badge bg-secondary">Fail</span>';
                 })  
                ->addColumn('total_payment', function($row){               
                    return '€' .number_format($row->total_payment,2);
                }) 
                ->addColumn('order_items', function($row){               
                    return DB::table('order_items')->where('order_id',$row->id)->count();
                }) 
                ->addColumn('created_at', function($row){               
                    return Carbon::parse($row->created_at)->format('d/m/Y H:i:s A');
                })   
                ->addColumn('action', function($row){                  
                       
                    return '<div style="text-align:center"><a href="'.url('Staff/order_items',$row->id).'"><i class="material-icons">remove_red_eye</i></a></div>';
                })
                ->rawColumns(['action','payment_status'])
                ->make(true);
        }
       
        return view('Staff.manage_orders');
    }

    public function  order_items($orderId, Request $request){
        $orderDetail = Order::find($orderId);
        if ($request->ajax()) {       
            $orders = OrderItem::where('order_id',$orderId)->get();
            return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('price', function($row){               
                    return '€'.number_format($row->price,2);
                })            
            ->addColumn('total_price', function($row){               
                    return '€'.number_format($row->total_price,2);
                })
            ->make(true);           
        }
        return view('Staff.manage_items',compact('orderId','orderDetail'));
    }

    public function manage_wallet(Request $request){
        $earning = Order::where('staff_id',Auth::guard('staff')->user()->id)->where('payment_status',1)->latest('id')->sum('total_payment');;
        return view('Staff.manage_wallet',compact('earning'));
    }
    public function add_csv(Request $request)
    {
        if ($request->ajax()) {  
           
            if ( $request->hasFile('csv_data')) {
            $file = $request->csv_data;
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes
      
            $location = "'../storage/staff/Arun/'"; //Created an "uploads" folder for that
            // Upload file
            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);
           
            $csv= file_get_contents($filepath);
            $array = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', $csv));
            $json = json_encode($array);
           
            $file = fopen($filepath, "r");
            // dd($file);
            $importData_arr = array(); // Read through the file and store the contents as an array
            // dd($importData_arr);
            $i = 0;
            $insert_data = [];
            //Read the contents of the uploaded file 
            while (($filedata = fgetcsv($file, 5000, ",")) !== FALSE) {
                // dd($filedata);
            $num = count($filedata);
            //  dd($num);
            // Skip first row (Remove below comment if you want to skip the first row)
            if ($i == 0) {
            $i++;
            continue;
            }
            for ($c = 0; $c < $num; $c++) {
               
                $importData_arr[$i][] = $filedata[$c];
            }
            $i++;
            }
            fclose($file); //Close after reading
            $j = 0;
            //  dd($importData_arr);
            foreach ($importData_arr as $importData) {

             //   dd($importData_arr);
               
             
        //   dd($importData);
        //    $data = [
        //        'id' => $importData[0],
        //        'category_name' => $importData[1],
        //        'image' => $importData[2],
        //        'category_italian_name' => $importData[3],
        //        'sub_cat_name' => $importData[4],
        //        'sub_cat_name_italian' => $importData[5],
        //        'item_name' => $importData[6],
        //        'item_italian_name' => $importData[7],
        //        'item_price' => $importData[8],
        //        'description' => $importData[9],
        //        'description_it' => $importData[10],
        //        'item_image' => $importData[11],
        //        'status' => $importData[12],
    
      
             
        //    ];

           $category = [
             'staff_id' =>  Auth::guard('staff')->id(),
            'category_name' => $importData[1],
            'category_italian_name' => $importData[3],
            'image' => $importData[2],    
            'sub_cat_name' => $importData[4],
            'sub_cat_name_italian' => $importData[5],  
            'item_name' => $importData[6],
            'item_italian_name' => $importData[7],
            'item_price' => $importData[8],
            'description' => $importData[9],
            'description_it' => $importData[10],
            'item_image' => $importData[11],  
                    
          ];
        //   dd($category);
           $j++;
            }
            $insert_data1[] = $category;
            // dd($importData_arr);
            foreach ($importData_arr as $value)
           {   


         
            $exist=Category::where('category_name',$value[1])->where('staff_id',Auth::guard('staff')->id())->exists();
        //    dd( $exist);
            if($exist){
                
               $cat_id =  Category::where('category_name',$value[1])->value('id');
         
              
               $sub_exist=Subcat::where('sub_cat_name',$value[4])->where('staff_id',Auth::guard('staff')->id())->exists();
               $menu_exists = Menus::where('item_name',$value[6])->where('staff_id',Auth::guard('staff')->id())->exists();
               

               if($sub_exist){

                $sub_id =  Subcat::where('sub_cat_name',$value[4])->value('id');
            

                $menu_exists = Menus::where('item_name',$value[6])->where('staff_id',Auth::guard('staff')->id())->exists();
              //  dd($sub_id);


                // $cat =  Category::create([   
                //     'staff_id' =>  Auth::guard('staff')->id(),
                //     'category_name' => $value[1],
                //      'category_italian_name' => $value[3],
                //      'image' => $value[2],
                //      ]);
    
                //     //  echo($cat->id); 
                 
    
                //     $subcat =  Subcat::create([  
                //         'staff_id' =>  Auth::guard('staff')->id(),
                //         'category_id' =>  $cat_id,
                //         'sub_cat_name' => $value[4],
                //         'sub_cat_name_italian' => $value[5],
                //      ]);
                if($menu_exists){
                    $menu_id =  Menus::where('item_name',$value[6])->value('id');
                  }
                  else{
                     $menu =  Menus::create([  
                        'restor_id'=> Auth::guard('staff')->user()->restor_id,
                        'staff_id' =>  Auth::guard('staff')->id(),
                        'category_id' =>  $cat_id,
                        'sub_cat_id' =>  $sub_id,
                        'item_name' => $value[6],
                        'item_italian_name' => $value[7],
                        'item_price' => $value[8],
                        'description' => $value[9],
                        'description_it' => $value[10],
                        'item_image' => $value[11],    
                     ]);
                    }
               }else{

                // $cat =  Category::create([   
                //     'staff_id' =>  Auth::guard('staff')->id(),
                //     'category_name' => $value[1],
                //      'category_italian_name' => $value[3],
                //      'image' => $value[2],
                //      ]);
    
                    //  echo($cat->id); 
                 
    
                    $subcat =  Subcat::create([  
                        'staff_id' =>  Auth::guard('staff')->id(),
                        'category_id' =>  $cat_id,
                        'sub_cat_name' => $value[4],
                        'sub_cat_name_italian' => $value[5],
                     ]);
    
                     $menu =  Menus::create([  
                        'restor_id'=> Auth::guard('staff')->user()->restor_id,
                        'staff_id' =>  Auth::guard('staff')->id(),
                        'category_id' =>  $cat_id,
                        'sub_cat_id' =>  $subcat->id,
                        'item_name' => $value[6],
                        'item_italian_name' => $value[7],
                        'item_price' => $value[8],
                        'description' => $value[9],
                        'description_it' => $value[10],
                        'item_image' => $value[11],    
                     ]);

               }
           
            
            }else{
              
              $cat =  Category::create([   
                'staff_id' =>  Auth::guard('staff')->id(),
                'category_name' => $value[1],
                 'category_italian_name' => $value[3],
                 'image' => $value[2],
                 ]);

                //  dd($cat); 
             

                $subcat =  Subcat::create([  
                    'staff_id' =>  Auth::guard('staff')->id(),
                    'category_id' => $cat->id,
                    'sub_cat_name' => $value[4],
                    'sub_cat_name_italian' => $value[5],
                 ]);

                 $menu =  Menus::create([  
                    'restor_id'=> Auth::guard('staff')->user()->restor_id,
                    'staff_id' =>  Auth::guard('staff')->id(),
                    'category_id' => $cat->id,
                    'sub_cat_id' =>  $subcat->id,
                    'item_name' => $value[6],
                    'item_italian_name' => $value[7],
                    'item_price' => $value[8],
                    'description' => $value[9],
                    'description_it' => $value[10],
                    'item_image' => $value[11],    
                 ]);
                //  dd($menu); 
                }
               
              
           
           }
  
   


           return response()->json([
               'message' => "$j records successfully uploaded"
               ]);
            }
        }
    }

}
