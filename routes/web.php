<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\Auth\ForgotPasswordController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('view', [CustomerController::class, 'view'])->name('view');
Route::get('language_change/{locale}', [CustomerController::class, 'changeLanguage'])->name('changeLanguage');






Route::group(['middleware' => 'is_account_active'], function () {

    Route::get('App/{staffid}', [CustomerController::class,'index']);
    Route::get('welcome/{staffid}', [CustomerController::class,'welcome']);  
    Route::get('category/{staffid}/{categoryId}', [CustomerController::class,'category']);
    Route::get('order-details/{staffid}', [CustomerController::class,'order_details']);
    Route::get('checkout/{staffid}/{orderId}', [CustomerController::class,'checkout']);
    Route::get('thankyou/{staffid}/{orderId}', [CustomerController::class,'thankyou']);
    Route::get('getadvertisement/{staffid}', [CustomerController::class,'getadvertisement']);
    Route::get('subcategory/{staffid}', [CustomerController::class,'subcategory']);
    Route::get('getcategory/{staffid}', [CustomerController::class,'getcategory']);
    Route::get('getmenu/{staffid}', [CustomerController::class,'getmenu']);

    Route::get('orders/{staffid}', [CustomerController::class,'orders']);

    Route::get('receipt/{staffid}/{orderId}', [CustomerController::class,'receipt']);
    //add to cart

     Route::get('add_to_cart/{staffid}', [CustomerController::class,'add_to_cart']);
     Route::get('show_cart_data/{staffid}', [CustomerController::class,'show_cart_data']);
     Route::get('update_to_cart/{staffid}', [CustomerController::class,'update_to_cart']);
     Route::get('delete_cart/{staffid}', [CustomerController::class,'delete_cart']);
     Route::get('cartitem_delete/{staffid}', [CustomerController::class,'cartitem_delete']);
    

    //Set Locale

    Route::get('staffData/{staffid}/{locale?}', [CustomerController::class,'setlocale']);


    // get data 
    Route::get('category/{staffid}', [CustomerController::class,'getCategory_data']);
    Route::post('poslist', [CustomerController::class,'poslist']);
        

});



// Admin routes without login
Route::group(['prefix' => 'Admin'], function () {

   Route::get('login',[AdminController::class,'login_view'])->name('admin_login');
   Route::post('Admin_login',[AdminController::class,'Admin_login']);

});

//ADmin with login routes here
Route::group(['prefix'=>'Admin','middleware'=> 'auth:web' ], function () {

    Route::get('dashboard',[AdminController::class,'dashboard']);
    //restaurant routes
    Route::get('manage_restaurant',[AdminController::class,'manage_restaurant']);
    Route::get('getRestaurantData',[AdminController::class,'getAllRestaurant']);
    Route::get('change_status_restor',[AdminController::class,'change_status_restor']);
    Route::post('add_restaurant',[AdminController::class,'add_restaurant']); 
    Route::get('edit_restaurant/{id}',[AdminController::class,'edit_restaurant']);
    Route::post('update_restaurant/{id}',[AdminController::class,'update_restaurant']);  
    Route::get('delete_restaurant/{id}',[AdminController::class,'delete_restaurant']);
    Route::get('manage_staff',[AdminController::class,'manage_staff']);
    Route::get('getStaffData',[AdminController::class,'getAllStaff']);
    Route::post('add_staff',[AdminController::class,'add_staff']);
    Route::get('edit_staff/{id}',[AdminController::class,'edit_staff']);
    Route::post('update_staff/{id}',[AdminController::class,'update_staff']);
    Route::get('delete_staff/{id}',[AdminController::class,'delete_staff']);
    Route::post('add_device',[AdminController::class,'add_device']);
    Route::get('get_staff',[AdminController::class,'get_staff']);
    Route::get('edit_device/{id}',[AdminController::class,'edit_device']);
    Route::post('update_device/{id}',[AdminController::class,'update_device']);
    Route::get('delete_device/{id}',[AdminController::class,'delete_device']);


    Route::get('change_Staff_status',[AdminController::class,'change_Staff_status']);
    //orders routes here
    Route::get('getOrders',[AdminController::class,'getOrders']);

     //Commision routes here
    Route::get('getCommision',[AdminController::class,'getCommision']);

     //Account Settings
    Route::get('Settings',[AdminController::class,'Settings']);
    Route::post('update_password',[AdminController::class,'update_password']);

     //devices
    Route::get('manage_devices',[AdminController::class,'getDevices']);
    Route::get('change_Device_status',[AdminController::class,'change_Device_status']);

    Route::get('logout',[AdminController::class,'logout']);

});

// End admin routes here

// Restaurant routes here without login
Route::group(['prefix' => 'Restaurant'], function () {
   Route::get('login', [RestaurantController::class,'login_view'])->name('Restaurant_login');
   Route::post('Restaurant_login',[RestaurantController::class,'login']);
   Route::get('sign_up', function () {
    return view('Restaurant.Auth.sign_up');
    });
   Route::post('sign_up',[RestaurantController::class,'sign_up']);

   Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');



});
//Restaurant after login routes here
Route::group(['prefix'=>'Restaurant','middleware'=> ['auth:restaurant','is_active'] ], function () {

    Route::get('dashboard',[RestaurantController::class,'dashboard']);
    Route::get('manage_staff',[RestaurantController::class,'manage_staff']);

    //staff registered routes here

    Route::post('add_staff',[RestaurantController::class,'add_staff']);
    Route::get('getAllStaff',[RestaurantController::class,'getAllStaff']);
    Route::get('editStaff/{id}',[RestaurantController::class,'editStaff']);
    Route::get('deleteStaff/{id}',[RestaurantController::class,'deleteStaff']);
    Route::post('update_staff',[RestaurantController::class,'update_staff']);

    // devices routes here
    Route::get('manage_devices',[RestaurantController::class,'manage_devices']);
    Route::get('Fiscal_devices',[RestaurantController::class,'Fiscal_devices']);

    Route::post('add_device',[RestaurantController::class,'add_device']);
    Route::get('delete_device/{id}',[RestaurantController::class,'delete_device']);

    //setting routes here
    Route::get('Setting',[RestaurantController::class,'Settings']);
    Route::post('update_password',[RestaurantController::class,'update_password']);

    //manage issues
    Route::get('manage_issue',[RestaurantController::class,'manage_issue']);
    Route::get('delete_issue/{id}',[RestaurantController::class,'delete_issue']);
    
    Route::get('manage_reports',[RestaurantController::class,'manage_reports']);
    Route::get('manage_orders_report/{staffid}',[RestaurantController::class,'manage_orders_report']);
    Route::get('export_pdf/{staffid}',[RestaurantController::class,'export_pdf']);
    Route::get('order_table/{staffid}',[RestaurantController::class,'order_table']);
    //manage Orders
    Route::get('manage_staff_order',[RestaurantController::class,'manage_staff_order']);
    Route::get('manage_orders/{staffid}',[RestaurantController::class,'manage_orders']);
    Route::get('manage_order_items/{orderId}', [RestaurantController::class,'order_items']);

    //manage payments
    Route::get('manage_payment',[RestaurantController::class,'manage_payment']);
    Route::get('manage_payment_orders/{staffid}',[RestaurantController::class,'manage_payment_orders']);

    Route::get('logout',[RestaurantController::class,'logout']);

});
// End Restaurant routes here

// Staff routes here without login 
Route::group(['prefix' => 'Staff'], function () {

   Route::get('login', function () {
    	return view('Staff.Auth.sign_in');
   })->name('Staff_login');
   Route::post('staff_login', [StaffController::class,'staff_login']);
  
});

//  staff after login routes here
Route::group(['prefix'=>'Staff','middleware'=> ['auth:staff','is_staff_active','prevent-back-history' ]], function () {

    Route::get('dashboard', [StaffController::class,'dashboard']);
    // category routes here
    Route::get('category', [StaffController::class,'category']);
    Route::post('add_category', [StaffController::class,'add_category']);
    Route::get('edit_category/{category}', [StaffController::class,'edit_category']);
    Route::post('edit_category/update/{id}', [StaffController::class,'update_category']);
    Route::get('delete_category/{Category}', [StaffController::class,'delete_category']);
    Route::get('hide_category/{id}', [StaffController::class,'hide_category']);
    Route::get('change_status',[StaffController::class,'change_status']);

    // sub category routes here
    Route::get('view_Category/{id}', [StaffController::class,'Sub_category']);
    Route::post('add_sub_category', [StaffController::class,'add_sub_category']);
    Route::get('edit_sub_category/{Category}', [StaffController::class,'edit_sub_category']);
    Route::post('edit_sub_category/update/{id}', [StaffController::class,'update_sub_category']);
    Route::get('delete_sub_category/{Category}', [StaffController::class,'delete_sub_category']);

    //menus routes here
    Route::get('menus', [StaffController::class,'menus']);
    Route::get('show_sub_category', [StaffController::class,'show_sub_category']);
    Route::post('add_menus', [StaffController::class,'add_menus']);    
    Route::get('edit_menus/{id}', [StaffController::class,'edit_menus']);
    Route::post('edit_menus/update/{id}', [StaffController::class,'update_menus']);
    Route::get('delete_menus/{id}', [StaffController::class,'delete_menus']);
    Route::get('add_id', [StaffController::class,'add_id']);
    Route::get('get_category_sizes', [StaffController::class,'get_category_sizes']);
    Route::get('change_menu_status',[StaffController::class,'change_menu_status']);
    Route::post('add_csv', [StaffController::class,'add_csv']);  
    

    //order 
    Route::get('orders', [StaffController::class,'orders']);
    Route::get('order_items/{orderId}', [StaffController::class,'order_items']);
    //account routes here
    Route::get('account', [StaffController::class,'account']);
    Route::post('account_issue', [StaffController::class,'account_issue']);

    //banner routes here
    Route::get('banner', [StaffController::class,'banner']);
    Route::post('add_banner', [StaffController::class,'add_banner']);
    Route::get('delete_banner/{id}', [StaffController::class,'delete_banner']);
  
    Route::get('manage_advertisement', [StaffController::class,'manage_advertisement']);
    Route::post('add_advertisement', [StaffController::class,'add_advertisement']);
    Route::get('delete_advertisement/{id}', [StaffController::class,'delete_advertisement']);
    // manage device 
    Route::get('device', [StaffController::class,'deviceInfo']);

    //mangae logo
    Route::get('manage_logo', [RestaurantController::class,'manage_logo']);
    Route::post('changeLogo', [RestaurantController::class,'changeLogo']);

    //manage wallet section
    Route::get('manage_wallet', [StaffController::class,'manage_wallet']);

   Route::get('logout',[StaffController::class,'logout']);

});

// end staff routes here





