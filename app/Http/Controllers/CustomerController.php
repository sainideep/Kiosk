<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menus;
use App\Models\Cart;
use App\Models\CartItem;
use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\App;

class CustomerController extends Controller
{
    public function index($id){
        $data = Session::get('language'); 
        // dd($data);
        app()->setLocale($data);
        // dd($data);
        $banner = DB::table('banner')->where('staff_id',$id)->first();
        $logo = DB::table('staff_logo')->where('staff_id',$id)->first();    
        return view('Customer.index',compact('banner','id','logo','data'));
    }
    public function welcome($staff_id){  

        $data = Session::get('language') ?? 'en'; 
        app()->setLocale($data); 
        $status = $data == 'en' ? 'status as status'  : 'status_it as status'; 
        $category = $data == 'en' ? 'category_name as category_name'  : 'category_italian_name as category_name';
        // dd($category);
        $categories = Category::select('id','staff_id','image',$category)->where('staff_id',$staff_id)->where('status','1')->get();
        // dd($categories);
        $logo = DB::table('staff_logo')->select('logo','staff_id',$status)->where('staff_id',$staff_id)->first();  
        return view('Customer.welcome',compact('categories','logo','staff_id','data'));
    }
    public function category($staff_id,$category_id, Request $request){
        $data = Session::get('language'); 
        app()->setLocale($data); 
        $status = $data == 'en' ? 'status as status'  : 'status_it as status';
        $category = $data == 'en' ? 'category_name as category_name'  : 'category_italian_name as category_name';
        $menu = $data == 'en' ? 'item_name as item_name'  : 'item_italian_name as item_name'; 
        $categories = Category::select('id','staff_id','image',$category)->where('staff_id',$staff_id)->where('status','1')->get();
        $sub_cats = DB::table('manage_sub_category')->where('category_id',$category_id)->get();
        $menus = Menus::select('id','staff_id','category_id','sub_cat_id','item_price','item_image',$menu)->where('category_id',$category_id)->where('status','1')->get();
    //    dd($menus);
        $advertisement = DB::table('advertisement')->where('staff_id',$staff_id)->get();
        $logo = DB::table('staff_logo')->select('logo','staff_id',$status)->where('staff_id',$staff_id)->first();
        return view('Customer.category',compact('categories','sub_cats','staff_id','advertisement','menus','logo'));
    }
    public function order_details($staff_id){
        $data = Session::get('language'); 
        app()->setLocale($data); 
        $status = $data == 'en' ? 'status as status'  : 'status_it as status';
        $logo = DB::table('staff_logo')->select('logo','staff_id',$status)->where('staff_id',$staff_id)->first();
        $temp_user_id = session()->getId(); 
        $cart         =  Cart::where('session_id',$temp_user_id)->where('staff_id',$staff_id)->first();
        if(!$cart){
            return 'Your Session is over please go to menu page and select the items first';         
            die;
        }
        $cat_ids = DB::table('cart_items')->where('cart_id',$cart->id)->distinct('cat_id')->pluck('cat_id'); 
        $menuArray = [];
        foreach($cat_ids as $cat_id)
        {
            $menuArray[$cat_id]['category_detail'] = Category::select('id', 'category_name','image')     
            ->where('id',$cat_id)->first();
            $menuArray[$cat_id]['items'] = CartItem::with(
                [
                    'MenusDetail' => function ($query) 
                                    {
                                        $query->select('id', 'item_name','item_image');
                                    },                    
                ]
            )->where('cart_id',$cart->id)->where('cat_id',$cat_id)->get()->toArray();
            $menuArray[$cat_id]['price'] = DB::table('cart_items')->where('cart_id',$cart->id)->where('cat_id',$cat_id)->sum('total_price');
        }
    //   dd($menuArray);
        return view('Customer.order-details',compact('logo','menuArray','cart','staff_id','data'));
    }
    public function checkout($staff_id,$order_id){
        $data = Session::get('language'); 
        app()->setLocale($data); 
        $status = $data == 'en' ? 'status as status'  : 'status_it as status';
        $logo = DB::table('staff_logo')->select('logo','staff_id',$status)->where('staff_id',$staff_id)->first();  
        return view('Customer.checkout',compact('staff_id','order_id','logo','data'));
   
    }
    public function thankyou($staff_id,$order_id){
        $data = Session::get('language'); 
        app()->setLocale($data); 
        $logo = DB::table('staff_logo')->where('staff_id',$staff_id)->first();    
        DB::table('order_details')->where('id',$order_id)->update(['payment_status' => 1]);
        return view('Customer.thankyou',compact('staff_id','data','logo','order_id'));  
   
    }

    public function poslist(Request $request){
        $url = 'https://testca.valuepay.it/ecr2pos/poslist';
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL =>$url ,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getCategory_data(Request $Request){
        $lang = Session::get('language');
        app()->setLocale($lang); 
        $sub_cat = $lang == 'en' ? 'sub_cat_name as sub_cat_name'  : 'sub_cat_name_italian as sub_cat_name'; 
        $data = DB::table('manage_sub_category')->select('id','staff_id','category_id',$sub_cat)->where('category_id',$Request->cat_id)->get();
        // $data = DB::table('manage_sub_category')->where('category_id',$Request->cat_id)->get();
        $filters = '<div class="cSlider__item arun" ><h2 style="font-size: smaller;height: 45px;font-weight: bold;"><span>All</span></h2></div>';
        if($data){
            foreach ($data as $value) {
                $filters .= '<div class="cSlider__item arun1" ><h2 style="font-size: smaller;height: 45px;font-weight: bold;"><span>'.$value->sub_cat_name.'</span></h2></div>';
            }
        }
        return response(['status' => 1, 'message' => $filters]);
    }

    public function setlocale($staffid,$locale = null){   
        // $locale = App::currentLocale();
        // dd($locale);  
        try{  
            if (isset($locale) && in_array($locale, config('app.available_locales'))) {
                dd(App::getLocale($locale));
               $result =  App::setLocale($locale);
            } 
            return response(['status' => 1, 'locale' => $result]);
        }
        catch(Exception $e){
            return response(['status' => 1, 'locale' => $e->getMessage()]);
        }   
        
    }
    public function getadvertisement($staff_id,Request $request)
    {
       if($request->ajax())
        {
            $advertisement = DB::table('advertisement')->where('staff_id',$staff_id)->inRandomOrder()->first();
            if($advertisement){
                if($advertisement->ad_type == 1)
                {
                    $data = "<img src='".$advertisement->ad_src."' style='height: 220px;width: 100%;'>";
                }
                else{
                    $data = "<video autoplay muted loop style='width: 100%;height: 220px; object-fit: cover;z-index: -100;'> <source src='".$advertisement->ad_src."' type='video/mp4' ></video>";
                }        
                return response(['status' => 1, 'message' => $data]);
            }
            else{
                return response(['status' => 2 ]);
            }
        }
    }
  
    public function getcategory($staff_id,Request $request)
    {     
      
        if($request->ajax())
        {
            $lang = Session::get('language');
            app()->setLocale($lang); 
            $menu_name = $lang == 'en' ? 'item_name as item_name'  : 'item_italian_name as item_name';           
            $sub_cat = $lang == 'en' ? 'sub_cat_name as sub_cat_name'  : 'sub_cat_name_italian as sub_cat_name'; 
            $sub_cats = DB::table('manage_sub_category')->select('id','staff_id','category_id',$sub_cat)->where('category_id',$request->input('cat_id'))->get();           
            $menus = DB::table('menu_items')->select('id','staff_id','category_id','sub_cat_id','item_price','item_image',$menu_name)->where('category_id',$request->input('cat_id'))->where('status','1')->get();
            // dd($menus);
           
            $data = "<div class='cSlider__item' style='width:auto'><h2 ><span>".trans('lang.all')."</span></h2></div>";  

            $cats = '';
            $menu_cat = [];  
            $menu_cat[] = 'All';
            if($sub_cats->count() > 0)
            {          
                foreach($sub_cats as $subcat)
                {     
                                      
                   $data .= "<div class='cSlider__item slider_item_name'><h2 style='padding-right:10px;padding-left:10px;'><span>".$subcat->sub_cat_name."</span></h2></div>";
                   $menu_cat[] =  $subcat->id;                         
                }
            }

            // $menu_Query =  DB::table('menu_items')->select('id','staff_id','category_id','sub_cat_id','item_price','description','item_image',$menu_name)->where('category_id',$request->input('cat_id'))->where('status','1');
         
           
            $category = $sub_cats->count();
            // dd($category);
            $menu = '';
            for($i = 0; $i <= $category; $i++){
                $menu_Query =  DB::table('menu_items')->select('id','staff_id','category_id','sub_cat_id','item_price','description','item_image',$menu_name)->where('category_id',$request->input('cat_id'))->where('status','1');
                $menu .= '<div class="cSlider__item">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-12 foodwraps-etc" id="position">
                                <div class="row" id="category">';
                              
                if($menu_cat[$i] != 'All'){
                  $menu_Query->where('sub_cat_id',$menu_cat[$i]);
                }

                $menu_datas = $menu_Query->latest('id')->get();        
                // dd($menu_datas);
                if(count($menu_datas) > 0){
                    foreach ($menu_datas as $value) {
                        $menu_price = $value->item_price;
                        $multiple_price = DB::table('menu_size_price')->where('menu_id',$value->id)->first();
                        if($multiple_price){
                            $menu_price = $multiple_price->price;
                        }
                        $menu .=  '<div class="col-md-4 col-lg-4 col-sm-4">
                                      <div class="food_itms">
                                        <img src="'.$value->item_image.'" alt="burger" class="food_item_img"> 
                                        <p class="plus_icon"><a href="#" data-toggle="modal" onclick="show('.$value->id.')" data-target="#myModal"><span><img src="'.url('images/add.png').'"></span></a></p>
                                        <div class="food_description">
                                          <h6>'.$value->item_name.'</h6>
                                          <p>€  '.number_format($menu_price,2).'</p>
                                        </div>
                                      </div>
                                    </div>';
                    }
                }
                else
                {
                 $menu .= "<center><p style='margin-left:283px'> No Menu available</p>";   
                }
                

                $menu .= '</div></div></div>';

            // dd($menu);
            }
          
            return response(['status' => 1, 'menus' => $menu ,'message' => $data]);
        }
    }
    public function getmenu($staff_id,Request $request)
    {
        if($request->ajax())
        {
            $lang = Session::get('language');
            app()->setLocale($lang); 
            $menu = $lang == 'en' ? 'item_name as item_name'  : 'item_italian_name as item_name';
            $description = $lang == 'en' ? 'description as description'  : 'description_it as description';
            $size = $lang == 'en' ? 'menu_size as menu_size'  : 'menu_size_italian as menu_size';
            $menus = DB::table('menu_items')->select('id','staff_id','category_id','sub_cat_id','item_price','item_image',$menu,$description)->where('id',$request->input('menu_id'))->first();
            $multi_price = DB::table('menu_size_price')->select('id','menu_id','price',$size)->where('menu_id',$request->input('menu_id'))->exists() ? 1 : 0;
            $multiValue = '';

            if($multi_price){
                $menu_size = DB::table('menu_size_price')->select('id','menu_id','price',$size)->where('menu_id',$request->input('menu_id'))->get();
                $m = 1;
                
                foreach ($menu_size as $value) 
                {
                    $checked = '';
                    if($m == 1){
                        $checked = "checked";
                    }
                    $multiValue .= '<div class="form-check-inline">
                                      <label class="form-check-label form_label-wrap" for='.$value->menu_size.'>'.$value->menu_size.'
                                        <input type="radio" class="form-check-input" id="'.$value->menu_size.'" name="multiple_price_id" '.$checked.' required value="'.$value->id.'" onclick="changePrice('.$value->price.')">
                                        <span class="checkmark"></span>
                                      </label>
                                    </div>';
                    $m++;
                }
                $price = '<p id="Price_change">€ ' .number_format($menu_size[0]->price,2).'</p>';                
            }
            else
            {
                $price = '<p id="Price_change">€ ' .number_format($menus->item_price,2).'</p>';
            }
            $menu_size = DB::table('menu_size_price')->select('id','menu_id','price',$size)->where('menu_id',$request->input('menu_id'))->get();
            $menu = '';
            $menu .='<div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">                    
                                <img src="'.$menus->item_image.'" class="modal_img" alt="Burger image" style="height:336px">
                                    <button type="button" class="close" data-dismiss="modal"   style="position: relative;margin-right: -50px;background: #ffffffab;color: black;font-weight: bolder; font-size: 28px;">&times;
                                    </button>
                            </div>
                            <div class="modal-body">
                                <h4>'.$menus->item_name.'</h4>
                                <p style="font-size: 21px;font-weight: 400;">'.$menus->description.'</p>
                                '.$price.' 
                               
                                <form id="addToCart">
                                   '.$multiValue.'
                                    <input type="hidden" value="'.$menus->id.'" name="menu_id"/>
                                    <div class="burgur_wrap-quantity modal__quantity input-group" >
                                        <input type="button" value="-" class="button-minus" data-field="quantity" >
                                        <input type="number" step="1" max="" min="1" value="1" name="quantity" id="plus" class="quantity-field">
                                        <input type="button" value="+" onclick("change_color()") class="button-plus" data-field="quantity" >
                                        <button type="submit" class="btn btn-primary add_quanity-modal" id="addToCartButton">'.trans('lang.add').'</button>
                                    </div>
                          
                                </form>
                            </div>
                        </div>
                    </div>'; 
         
             return response(['status' => 1, 'menu' => $menu]);
        }
    }

    public function view()
    {
        return view('language');
    }
    public function changeLanguage(Request $request,$locale)
    {
     
       if($request->ajax())
       {
        
        \Session::put('language', $request->lang);
        $data = Session::get('language'); 
        
        app()->setLocale($data);
        //  echo trans('lang.msg');
         echo trans('lang.welcome');
        
       }  
        

        // return redirect('Customer.welcome');
    }

    public function add_to_cart(Request $request,$staff_id){        
        $request->validate([
            'menu_id'       => 'required',
        ]);        
        $temp_user_id = session()->getId();        
        $cart = Cart::where('session_id',$temp_user_id)->where('staff_id',$staff_id)->first();
        $rest_id = DB::table('staff')->where('id',$staff_id)->value('restor_id');
        if(!$cart){
            $cart_data['session_id'] = $temp_user_id;
            $cart_data['staff_id']   = $staff_id;
            $cart_data['rest_id']    = $rest_id;
            Cart::insert($cart_data);
            $cart = Cart::where('session_id',$temp_user_id)->first();
        }
        $multiple_price_id = 0;
        if($request->multiple_price_id)
        {
            $multiple_price_id = $request->multiple_price_id;
        }
        $menu_data = DB::table('menu_items')->where('id',$request->menu_id)->where('staff_id',$staff_id)->first();   
        if($menu_data){
            $existMenu = CartItem::where('cart_id',$cart->id)->where('menu_id',$menu_data->id)->where('menu_size_id',$multiple_price_id)->first();
            $menu_price = $menu_data->item_price;
            if($request->multiple_price_id)
            {
                $menu_price = DB::table('menu_size_price')->where('id',$request->multiple_price_id)->value('price');
                $menu_items['menu_size_id'] = $request->multiple_price_id;
            }
            if(!$existMenu)
            {
                $menu_items['menu_id']      = $menu_data->id;
                $menu_items['cart_id']      = $cart->id;
                $menu_items['cat_id']       = $menu_data->category_id;
                $menu_items['menu_price']   = $menu_price;
                $menu_items['quantity']     = $request->quantity;
                $menu_items['total_price']  = $menu_price * $request->quantity;
                CartItem::insert($menu_items);
                $message = "Menu added";
                $status = 1;
            }
            else{
                $status = 0;
                $message = "This Item is already in cart";
            }
        }
        $this->update_price($cart->id);      
        return response(['status' => $status, 'message' => $message]);           
    }

    public function update_to_cart(Request $request, $staff_id)
    {  
        $request->validate([
            'cart_item_id'       => 'required',
            'quantity'           => 'required',
        ]);
        $existMenu = CartItem::where('id',$request->cart_item_id)->first();
        $cartId = $existMenu->cart_id;
        if($existMenu)
        {
            if($request->quantity > 0){
                DB::table('cart_items')->where('id',$request->cart_item_id)->update(
                    [
                        'quantity'      => $request->quantity,
                        'total_price'   => $existMenu->menu_price * $request->quantity
                    ]
                );
            }
            else
            {
                DB::table('cart_items')->where('id',$request->cart_item_id)->delete();   
            }
        }
        $this->update_price($existMenu->cart_id);
        $existCartItems = DB::table('cart_items')->where('cart_id',$cartId)->count();
        if($existCartItems == 0){
            DB::table('cart')->where('id',$cartId)->delete();
        }

        return response(['status' => 1, 'message' => 'Updated']);
    }

    public function show_cart_data($staff_id)
    {
        $data = Session::get('language');
        app()->setLocale($data);
        $menuinfo = $data == 'en' ? 'item_name as item_name'  : 'item_italian_name as item_name';
        
        $temp_user_id = session()->getId(); 
        // $segment1 =  Request::segment(1); 
        // dd($segment1);
        $cart =  Cart::where('session_id',$temp_user_id)->first();
        if(!$cart){
            return response(['status' => 2]);
        }
        $menus = CartItem::where('cart_id',$cart->id)->get();
       
        $cart_items = '';
        if($menus){            
            foreach ($menus as $value) {
                $menu = DB::table('menu_items')->select('id','staff_id','category_id','sub_cat_id','item_price','description','item_image',$menuinfo)->where('id',$value->menu_id)->first();
                // dd($menu);
                $cart_items .='<div class="wrapslider_item-cart">
                                    <div class="slider_img">
                                        <a href="#"><img src="'.$menu->item_image.'" alt="Slide 1"></a>
                                        <button type="button" onclick="cartitem_delete('.$menu->id.')"  style="position: relative;margin-right:30px;left:160px;bottom: 171px;background: #ffffffab;color: black;font-weight: bolder; font-size: 28px;">&times;</button>
                                    </div>
                                <div class="cart_wrap-item">
                                    <h6>'.$menu->item_name.'</h6>
                                    <p>€ '.number_format($value->menu_price,2).'</p>
                                    <div class="burgur_wrap-quantity input-group">
                                      <input type="button" value="-" class="button-minus" data-field="quantity" onclick="update_cart(1,'.$value->id.','.$value->quantity.')">
                                      <input type="number" step="1" max="" value="'.$value->quantity.'" name="quantity" class="quantity-field" id="cart_update_val" >
                                      <input type="button" value="+" class="button-plus" data-field="quantity" onclick="update_cart(2,'.$value->id.','.$value->quantity.')">
                                    </div>
                                </div>                      
                            </div>';
            }
            $price = trans('lang.total').': € '.number_format($cart->total_price,2);
            return response(['status' => 1, 'data' => $cart_items , 'total_price' => $price]);
        }
        return response(['status' => 2]);
        
    }

    function delete_cart()
    {
        $temp_user_id = session()->getId(); 
        $cart =  Cart::where('session_id',$temp_user_id)->first();
        CartItem::where('cart_id',$cart->id)->delete();
        Cart::where('session_id',$temp_user_id)->delete();
        return response(['status' => 1]);
    }

    function update_price($cartId)
    {
        $price = CartItem::where('cart_id',$cartId)->sum('total_price');
        DB::table('cart')->where('id',$cartId)->update(['total_price' => $price]);
        return true;
    }
    public function orders($staff_id, Request $request)
    {
        try
        {
            DB::beginTransaction();      
            $temp_user_id = session()->getId(); 
            $cart = Cart::where('session_id',$temp_user_id)->where('staff_id',$staff_id)->first();
            if(!$cart){
                return response(['status' => 0 , 'message' => 'Your session is over please go to menu page']); 
            }
            $cart_items = CartItem::where('cart_id',$cart->id)->get();
            //$order_details['session_id']      = $temp_user_id;
            $order_details['rest_id']         = $cart->rest_id;
            $order_details['staff_id']        = $staff_id;
            $order_details['total_payment']   = $request->total_price;
            $order_details['payment_status']  = 0;
            $orderId = DB::table('order_details')->insertGetId($order_details);
            foreach($cart_items as $cart_item){
                $menu = DB::table('menu_items')->where('id',$cart_item->menu_id)->first();
                DB::table('order_items')->insert([
                    'order_id'  => $orderId,
                    'menu_item_name' => $menu->item_name,
                    'price' => $cart_item->menu_price,
                    'count' => $cart_item->quantity,
                    'total_price' => $cart_item->total_price,
                ]);          
                
            }
            DB::table('cart_items')->where('cart_id',$cart->id)->delete();
            DB::table('cart')->where('id',$cart->id)->delete();
            DB::commit();
            return response(['status' => 1 , 'message' => 'saved', 'order_id' => $orderId]);
        }
        catch(Exception $e){
                DB::rollback();
                return response(['status' => 2 , 'message' => $e->getMessage()]); 

        }
    }
    public function receipt($staff_id,$order_id)
    {
        $staff = DB::table('staff')->where('id',$staff_id)->first();
        $order = DB::table('order_details')->where('id',$order_id)->first();
        $order_item = DB::table('order_items')->where('order_id',$order_id)->get();
        // dd($order_item);
        return view('Customer.reciept',compact('staff','order','order_item'));
    }
    public function cartitem_delete($staff_id,Request $request)
    {
        // dd($request->menu_id);
        DB::table('cart_items')->where('menu_id',$request->menu_id)->delete();
        return redirect()->back();
    }

}
