<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Restaurant;
use App\Models\Order;
use DataTables;
use App\Models\User;
use App\Models\Staff;
use DB;
use Validator;
use Session;

class AdminController extends Controller
{

    public function login_view(){
        if(auth::user()){
            return redirect('Admin/dashboard');
        }
        return view('Admin.Auth.sign_in');        
    }

    public function Admin_login(Request $Request){
         $Request->validate([
            'email'          => 'required',
            'password'       => 'required',
        ]);
        $credentials = [
            'email' => $Request['email'],
            'password' => $Request['password'],
        ];       
        if(Auth::attempt($credentials)){
            return redirect('Admin/dashboard');
        }
        else{
            return back()->with('message','Credentials do not match');
        }

    }

    public function dashboard(){
        $restaurant = Restaurant::count();
        $device = DB::table('manage_devices')->count();
        $orders = Order::count();      
        $earning = Order::sum('total_payment');  
        return view('Admin.dashboard',compact('restaurant','device','orders','earning'));
    }

    public function logout(){
        Auth::guard('web')->logout();
        return view('Admin.Auth.sign_in');
    }

    public function manage_restaurant(){
        $data = Restaurant::count();      
        return view('Admin.restaurants',compact('data'));
    }

     public function getAllRestaurant(Request $request){
        if ($request->ajax()) {
            $data = Restaurant::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    return $row->status == 1 ? "Active" : "Deactive";
                })
                ->addColumn('countryCode', function($row){

                    return $row->countryCode == Null ? "-" : $row->countryCode;
                })
                ->addColumn('action', function($row){
                    $sign = $row->status == 1 ? 'checked' : '';
                    $actionBtn = '<div style="margin-left:50px; padding:3px"><div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" onclick="show('.$row->id.')" id="flexSwitchCheckChecked"  '.$sign.'>
                        </div></div>';
                       
                    return $actionBtn;
                })
                ->addColumn('actionData', function($row){
                    $sign = $row->status == 1 ? 'checked' : '';
                    $confirm = "return confirm('Are you sure?')";  
                    $actionBtn = '<div style="margin-left: -23px; padding:3px"><div class="form-check form-switch">
                    <a href="'.url('Admin/edit_restaurant',$row->id).'"><i class="material-icons">edit</i></a>
                    <a href="'.url('Admin/delete_restaurant',$row->id).'" ><i class="material-icons"   onclick="'.$confirm.'">delete</i></a>
                        </div></div>';
                       
                    return $actionBtn;
                })
                ->rawColumns(['action','actionData'])
                ->make(true);
        }
    }

    public function change_status_restor(Request $request){
        $validator = Validator::make($request->all(), [ 
          'restor_id'  => 'required',
        ]);
        if ($validator->fails()) { 
          return response()->json([
            'status'=>'0',
            'message'=>$validator->errors(),
          ]);          
        }
        try{
            DB::beginTransaction();          
            $result = Restaurant::where('id',$request->restor_id)->first();
            
            if($result->status == 1){
                $restor['status'] = 0;
            }else{
                $restor['status'] = 1;
            }
            Restaurant::where('id',$request->restor_id)->update($restor);
            DB::commit();
            return response()->json([
                'status'=>'1',
                'message'=>'done',
            ]);

        }
        catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status'=>'0',
                'message'=>$e->getMessage(),
            ]);
        }
    }

    public function getOrders(){

       return view('Admin.manage_orders');
    }

    public function getCommision(){

       return view('Admin.manage_commision');
    }

    public function Settings(){
        return view('Admin.setting');
    }

    public function update_password(Request $request){           
        $request->validate([
            'password'          => 'required|min:8',
            'confirm_password'  => 'required|same:password|',
        ]);
        User::where('id',auth::user()->id)->update([
            'password'      => bcrypt($request['password'])
            ]);
        return back()->with('status',"Password Changed Successfully");  
    }

    public function getDevices(Request $request){
        $data = DB::table('manage_devices')->count();
        $restaurants = Restaurant::all();
        $staff = Staff::all();
        if ($request->ajax()) {
            $data = DB::table('manage_devices')->latest('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                 ->addColumn('restor_name', function($row){
                    return Restaurant::where('id',$row->restor_id)->value('rest_name');
                })
                ->addColumn('staff_name', function($row){
                    return Staff::where('id',$row->staff_id)->value('email');
                })
                ->addColumn('status', function($row){
                    return $row->status == 1 ? 'Active' : 'Not-Active';
                })
                ->addColumn('action', function($row){
                    $sign = $row->status == 1 ? 'checked' : '';
                    $actionBtn = '<div class="form-check form-switch" style="padding-left:44px">
                          <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" onchange="show('.$row->id.')" '.$sign.'>
                        </div>';
                    return $actionBtn;
                })
                ->addColumn('activity', function($row){
                    $confirm = "return confirm('Are you sure?')";
                    $Btn = '<div style=" padding:3px"><div >
                    <a href="'.url('Admin/edit_device',$row->id).'"><i class="material-icons">edit</i></a>
                    <a href="'.url('Admin/delete_device',$row->id).'"><i class="material-icons" onclick="'.$confirm.'">delete</i></a>
                        </div></div>';
                    return $Btn;
                })
                ->rawColumns(['action','activity'])
                ->make(true);
        }
        return view('Admin.manage_devices',compact('restaurants','staff','data'));
    }

    public function change_Device_status(Request $request){
        $validator = Validator::make($request->all(), [ 
          'device_id'  => 'required',
        ]);
        if ($validator->fails()) { 
          return response()->json([
            'status'=>'0',
            'message'=>$validator->errors(),
          ]);          
        }
        try{
            DB::beginTransaction();          
            $result = DB::table('manage_devices')->where('id',$request->device_id)->first();
            if($result->status == 1){
                $device['status'] = 0;
            }else{
                $device['status'] = 1;
            }
            DB::table('manage_devices')->where('id',$request->device_id)->update($device);
            DB::commit();
            return response()->json([
                'status'=>'1',
                'message'=>'done',
            ]);

        }
        catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status'=>'0',
                'message'=>$e->getMessage(),
            ]);
        }
    }
    public function add_restaurant(Request $request)
    {
        $request->validate([
            'name'                     => 'required',
            'contact_number'           => 'required',
            'email'                    => 'required',
            'password'                 => 'required',
        ]);
        $restaurant = New Restaurant;
        $restaurant->rest_name             =        $request['name'];
        $restaurant->contact_number        =        $request['contact_number'];
        $restaurant->email                 =        $request['email'];
        $restaurant->password              =        bcrypt($request['password']);
        if($restaurant->save())
        {
            return redirect()->back();
        }
    }
    public function edit_restaurant($id)
    {
        $restaurant = Restaurant::find($id);
        return view('Admin.edit_restaurant',compact('restaurant'));
    }
    public function update_restaurant($id,Request $request)
    {
        $request->validate([
            'name'                     => 'required',
            'contact_number'           => 'required',
            'email'                    => 'required',
            //'password'                 => 'required',
        ]);
        $restaurant = Restaurant::find($id);
        $restaurant->rest_name             =        $request['name'];
        $restaurant->contact_number        =        $request['contact_number'];
        $restaurant->email                 =        $request['email'];
       // $restaurant->password              =        bcrypt($request['password']);
   
        if($restaurant->save())
        {
            return redirect('Admin/manage_restaurant');
            // return Redirect($url);
        }
    }
    public function delete_restaurant($id)
    {
      
       $staff_ids = DB::table('staff')->where('restor_id',$id)->pluck('id');
       DB::table('category')->whereIn('staff_id',$staff_ids)->delete();
       DB::table('banner')->whereIn('staff_id',$staff_ids)->delete();
       DB::table('manage_sub_category')->whereIn('staff_id',$staff_ids)->delete();
       DB::table('banner')->whereIn('staff_id',$staff_ids)->delete();
       DB::table('staff_logo')->whereIn('staff_id',$staff_ids)->delete();
       DB::table('restaurants')->where('id',$id)->delete();
       DB::table('staff')->where('restor_id',$id)->delete();
       DB::table('menu_items')->where('restor_id',$id)->delete();
       DB::table('manage_devices')->where('restor_id',$id)->delete();
       DB::table('account_issue')->where('rest_id',$id)->delete();
       return redirect()->back();
    }
    public function manage_staff()
    {
        $data = Staff::count();
        $restaurants = Restaurant::all();
        return view('Admin.manage_staff',compact('restaurants','data'));
    }
    public function getAllStaff(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('staff')->latest('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                 ->addColumn('restor_name', function($row){
                    return Restaurant::where('id',$row->restor_id)->value('rest_name');
                })  
                ->addColumn('status', function($row){
                    return $row->status == 1 ? 'Active' : 'Not-Active';
                })
                ->addColumn('activity', function($row){
                    $sign = $row->status == 1 ? 'checked' : '';
                    $Btn = '<div style="margin-left:43px; padding:3px"><div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" onchange="showing('.$row->id.')" '.$sign.'>
                        </div></div>';
                    return $Btn;
                })           
                ->addColumn('action', function($row){
                    $confirm = "return confirm('Are you sure?')";
                    $actionBtn = '<div style="margin-left: -7px; padding:3px"><div class="form-check form-switch">
                    <a href="'.url('Admin/edit_staff',$row->id).'"><i class="material-icons">edit</i></a>
                    <a href="'.url('Admin/delete_staff',$row->id).'"><i class="material-icons" onclick="'.$confirm.'">delete</i></a>
                        </div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action','activity'])
                ->make(true);
        }
    }
    public function add_staff(Request $request)
    {
        
        $validator = Validator::make($request->all(), [ 
            'name'                    => 'required',
            'email'                   => 'required|email',
            'password'                => 'required|min:6',
            'confirm_password'        => 'required|same:password',
            'location'                => 'required',
          ]);
          if ($validator->fails()) { 
            return response()->json([
              'status'=>'0',
              'message'=>$validator->errors(),
            ]);          
          }          
          $staff = New Staff;
          $staff->restor_id = $request->input('restaurant');
          $staff->name = $request->input('name');
          $staff->email = $request->input('email');
          $staff->password = bcrypt($request->input('password'));
          $staff->location = $request->input('location');
          $staff->save();
          return response()->json(['status' => 1 , 'message' => 'Saved']);
    }
    public function edit_staff($id)
    {
        $restaurants = Restaurant::all();
        $staff = Staff::where('id',$id)->first();
        return view('Admin.edit_staff',compact('restaurants','staff'));
    }
    public function update_staff($id,Request $request)
    {
        $request->validate([
            'restaurant'                => 'required',
            'name'                      => 'required',
            'email'                     => 'required',
            'location'                  => 'required',
            //'password'                 => 'required',
        ]);
        $staff = Staff::find($id);
        $staff->restor_id               =        $request['restaurant'];
        $staff->name                    =        $request['name'];
        $staff->email                   =        $request['email'];
        $staff->location                =        $request['location'];
       // $restaurant->password              =        bcrypt($request['password']);
        if($staff->save())
        {
            return redirect('Admin/manage_staff');
        }
    }
    public function delete_staff($id)
    {
        Staff::find($id)->delete();
        DB::table('manage_devices')->where('staff_id',$id)->delete();
        return redirect()->back();
    }
    public function add_device(Request $request)
    {           
        $validator = Validator::make($request->all(), [ 
            'restor_id'            => 'required',    
            'device_name'          => 'required',
            'staffId'              => 'required|unique:manage_devices,staff_id',          
          ]);
          if ($validator->fails()) { 
            return response()->json([
              'status'=>'0',
              'message'=>$validator->errors(),
            ]);          
          }
          try{
              DB::beginTransaction();          
              $staff['device_name']         =  $request->device_name;
              $staff['restor_id']           =  $request->restor_id;
              $staff['staff_id']            = $request->staffId;
              $staff['unique_link']         = url('App',$request->staffId);            
              DB::table('manage_devices')->insert($staff);
              DB::commit();
              return response()->json([
                  'status'=>'1',
                  'message'=>'device Added',
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
    public function get_staff(Request $request)
    { 
        $staff = Staff::where('restor_id',$request->restid)->whereNotIn('id',DB::table('manage_devices')->where('restor_id', $request->restid)->pluck('staff_id'))->where('status',1)->get();
        $option = '';
        if(count($staff) > 0)
        {   $option = '<option value="">Select Staff</option>';
            foreach($staff as $value){
                $option .= '<option value="'.$value->id.'">'.$value->name.'</option>';
            }
        }
        else
        {           
            $option = '<option value="">No Staff Found</option>';
        }
        return response()->json(['status' => 1, 'data' => $option]);
       
    }
    public function edit_device($id)
    { 
        $device =  DB::table('manage_devices')->where('id',$id)->first();
        $device->restor_name = Restaurant::where('id',$device->restor_id)->value('rest_name');
        $device->staff_name = Staff::where('id',$device->staff_id)->value('name');
        return view('Admin.edit_device',compact('device'));
       
    }
    public function update_device($id,Request $request)
    {
        $request->validate([
            'restaurant'                => 'required',
            'staff'                     => 'required',
            'device_name'               => 'required',
        ]);
         $device['device_name'] = $request['device_name'];
         $device['restor_id']   = $request['restaurantid'];
         $device['staff_id']    = $request['staffid'];
         $device['unique_link'] =  url('App',$request->staffId);
         DB::table('manage_devices')->where('id',$id)->update($device);
         return redirect('Admin/manage_devices');
    }
    public function delete_device($id)
    {
        DB::table('manage_devices')->where('id',$id)->delete();
        return redirect()->back();
    }
    public function change_Staff_status(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'staff_id'  => 'required',
          ]);
          if ($validator->fails()) { 
            return response()->json([
              'status'=>'0',
              'message'=>$validator->errors(),
            ]);          
          }
          try{
              DB::beginTransaction();          
              $result = DB::table('staff')->where('id',$request->staff_id)->first();
              if($result->status == 1){
                  $staff['status'] = 0;
              }else{
                  $staff['status'] = 1;
              }
              DB::table('staff')->where('id',$request->staff_id)->update($staff);
              DB::commit();
              return response()->json([
                  'status'=>'1',
                  'message'=>'done',
              ]);
  
          }
          catch(Exception $e){
              DB::rollback();
              return response()->json([
                  'status'=>'0',
                  'message'=>$e->getMessage(),
              ]);
          }
    }
}
