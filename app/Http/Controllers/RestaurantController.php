<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Staff;
use App\Models\Order;
use App\Models\OrderItem;
use Auth;
use Validator;
use DB;
use DataTables;
use App\Models\User;
use App\Models\Category;
use File;
use Carbon\Carbon;
use PDF;

class RestaurantController extends Controller
{

    public function dashboard()
    {
        $staff = Staff::where('restor_id',Auth::guard('restaurant')->user()->id)->count();
        $device = DB::table('manage_devices')->where('restor_id',Auth::guard('restaurant')->user()->id)->count();
        $orders = Order::where('rest_id',Auth::guard('restaurant')->user()->id)->count();
        $earning = Order::where('rest_id',Auth::guard('restaurant')->user()->id)->where('payment_status',1)->latest('id')->sum('total_payment');
        return view('Restaurant.dashboard',compact('staff','device','orders','earning'));
    }

    public function login_view(){       
        if(auth::guard('restaurant')->user()){
            return redirect('Restaurant/dashboard');
        }
       return view('Restaurant.Auth.sign_in');
    }

    Public function sign_up(Request $request)
    {        
        $request->validate([
            'rest_name'         => 'required',
            'email'             => 'required|unique:users',
            'password'          => 'required|min:8',
            'confirm_password'  => 'required|same:password|',
            'contact_number'    => 'required'
        ]);        
        $restaurant = New Restaurant;
        $restaurant->rest_name = $request['rest_name'];
        $restaurant->email = $request['email'];
        $restaurant->password = bcrypt($request['password']);
        $restaurant->contact_number = $request['contact_number'];
        if($restaurant->save()){
            return back()->with('message',"Successfully");
            //return redirect('Restaurant/login');
        }else{
            return back()->with('error',"Please try again");
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);       
        $active = Restaurant::where('email',$request->email)->first();
        if(!$active){
            return back()->with('message', "Credentials do not match");
        }
        if($active->status == 0){
            return back()->with('message', "This restaurant is not active yet");
        }
        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('restaurant')->attempt($credentials)) {
            return redirect()->intended('Restaurant/dashboard')
                        ->withSuccess('Signed in');
        }
        else{
            return back()->with('message','Wrong Credentials');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('Restaurant/login');
    }

    public function manage_staff(){
            
        return view('Restaurant.staff');
    }

    public function add_staff(Request $Request){       
        $validator = Validator::make($Request->all(), [ 
          'name'                    => 'required',
          'email'                   => 'required|email',
          'Password'                => 'required',
          'Confirm_Password'        => 'required|same:Password',
          'location'                => 'required',
        ]);
        if ($validator->fails()) { 
          return response()->json([
            'status'=>'0',
            'message'=>$validator->errors(),
          ]);          
        }
        try{
            DB::beginTransaction();     
            $staff['name']          =  $Request->name;     
            $staff['email']         =  $Request->email;
            $staff['password']      =  bcrypt($Request->Password);
            $staff['location']      =  $Request->location;
            $staff['restor_id']     =   Auth::guard('restaurant')->user()->id;
            Staff::insert($staff);
            DB::commit();
            return response()->json([
                'status'=>'1',
                'message'=>'Staff Added',
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

    public function update_staff(Request $Request){  

        $validator = Validator::make($Request->all(), [ 
          'name'                    => 'required',
          'email'                   => 'required|email',
          'staff_id'                => 'required',
          'location'                => 'required',
        ]);
        if ($validator->fails()) { 
          return response()->json([
            'status'=>'0',
            'message'=>$validator->errors(),
          ]);          
        }
        try{
            DB::beginTransaction(); 
            $staff['name']         =  $Request->name;         
            $staff['email']         =  $Request->email;
            $staff['location']      = $Request->location;           
            Staff::where('id',$Request->staff_id)->update($staff);
            DB::commit();
            return response()->json([
                'status'=>'1',
                'message'=>'Staff Added',
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

    public function getAllStaff(Request $request){
        if ($request->ajax()) {
            $data = Staff::where('restor_id',Auth::guard('restaurant')->user()->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name ?? '-';
                })
                ->addColumn('created_at', function($row){
                    return ($row->created_at)->format('d/m/Y H:i:s A');
                })
                ->addColumn('action', function($row){
                    $url = url('Restaurant/editStaff',$row->id);
                    $deleteurl = url('Restaurant/deleteStaff',$row->id);
                    $confirm = "return confirm('Are you sure?')";
                    $actionBtn = '<a href="'.$url.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" style="margin-left:79px">
                          <i class="material-icons opacity-10">edit</i>
                        </a>
                        <a href="'.$deleteurl.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" onclick="'.$confirm.'">
                          <i class="material-icons opacity-10">delete</i>
                        </a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function editStaff($id){
        $staff = Staff::find($id);

        return view('Restaurant.Edit_staff',compact('staff'));
    }
    public function deleteStaff($id){
       $status = Staff::where('id',$id)->delete();
    //    DB::table('account_issue')->where('staff_id',$id)->delete();
       if($status){
        return back();
       }
    }

    public function Fiscal_devices(){
        return view('Restaurant.fiscal_printer');
    }

    public function manage_devices(Request $request){
         $restor = Staff::where('restor_id', Auth::guard('restaurant')->user()->id)->whereNotIn('id',DB::table('manage_devices')->where('restor_id', Auth::guard('restaurant')->user()->id)->pluck('staff_id'))->get();
         if ($request->ajax()) {
            $data = DB::table('manage_devices')->where('restor_id',Auth::guard('restaurant')->user()->id)->latest('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('staff_name', function($row){
                    return Staff::where('id',$row->staff_id)->value('name');
                })
                ->addColumn('status', function($row){
                    return $row->status == 0 ? 'Not Active' : "Active";
                })
                ->addColumn('action', function($row){                   
                    $deleteurl = url("Restaurant/delete_device",$row->id);
                    $confirm = "return confirm('Are you sure?')";
                    $actionBtn = '<a href="'.$deleteurl.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" onclick="'.$confirm.'" style="margin-left:20px">
                          <i class="material-icons opacity-10">delete</i>
                        </a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Restaurant.manage_devices',compact('restor'));
    }

    public function add_device(Request $Request){  
      
        $validator = Validator::make($Request->all(), [ 
          'device_name'             => 'required',
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
            $staff['device_name']         =  $Request->device_name;
            $staff['restor_id']           =  Auth::guard('restaurant')->user()->id;
            $staff['staff_id']            = $Request->staffId;
            $staff['unique_link']         = url('App',$Request->staffId);            
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

    public function Settings(){
        return view('Restaurant.setting');
    }

    public function update_password(Request $request){           
        $request->validate([
            'password'          => 'required|min:8',
            'confirm_password'  => 'required|same:password|',
        ]);
        User::where('id',auth::guard('restaurant')->user()->id)->update([
            'password'      => bcrypt($request['password'])
            ]);
        return back()->with('status',"Password Changed Successfully");  
    }

    public function delete_device($id){
        $result = DB::table('manage_devices')->where('id',$id)->delete();
        if($result){
            return back();
        }
    }

    public function manage_issue(Request $request){

        if ($request->ajax()) {
            $data = DB::table('account_issue')->where('rest_id',Auth::guard('restaurant')->user()->id)->latest('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('staff_name', function($row){
                    return Staff::where('id',$row->staff_id)->value('name');
                })
                ->addColumn('action', function($row){                   
                    $deleteurl = url("Restaurant/delete_issue",$row->id);
                    $confirm = "return confirm('Are you sure?')";
                    $actionBtn = '<a href="'.$deleteurl.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" onclick="'.$confirm.'" style="margin-left:20px">
                          <i class="material-icons opacity-10">delete</i>
                        </a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Restaurant.manage_issues');
    }

    public function manage_logo(){
        // dd('hh');
        $data = DB::table('staff_logo')->where('staff_id',Auth::guard('staff')->user()->id)->first();
        return view('Staff.manage_logo',compact('data'));
    }

    public function changeLogo(Request $request){
        $data = DB::table('staff_logo')->where('staff_id',Auth::guard('staff')->user()->id)->first();
        if($data){
            $img =  explode('/', $data->logo);           
            $pathExits = storage_path().'/staff/'.$img[6].'/'.$img[7].'/'.$img[8];           
            if (File::exists($pathExits)) {
              unlink($pathExits);
            } 
            if($request->hasfile('change_logo'))
            {
                $file = $request->change_logo;
                $path = storage_path().'/staff/'.Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/logo';
                File::makeDirectory($path, $mode = 0777, true, true);
                $imagePath = storage_path().'/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/logo';         
                $post_image        = time().$file->getClientOriginalName();
                $image_url          = 'https://phpstack-102119-2434585.cloudwaysapps.com//storage/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/logo/'. $post_image;   
                $file->move($imagePath, $post_image);
                $dataArray['logo'] = $image_url;
            }
            if($request->status)
            {
                $dataArray['status'] = $request->status;
            }
            if($request->itstatus)
            {
                $dataArray['status_it'] = $request->itstatus;
            }
            // dd($dataArray);
            DB::table('staff_logo')->where('staff_id',Auth::guard('staff')->user()->id)->update(                   
            $dataArray
            );
            return redirect()->back()->with('status', 'saved');
        }
        // return redirect()->back()->with('status', 'saved');
        // if($request->hasfile('change_logo'))
        // {
        //     $file = $request->change_logo;
        //     $path = storage_path().'/staff/'.Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/logo';
        //     File::makeDirectory($path, $mode = 0777, true, true);
        //     $imagePath = storage_path().'/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/logo';         
        //     $post_image        = time().$file->getClientOriginalName();
        //     $image_url          = 'https://phpstack-102119-2434585.cloudwaysapps.com//storage/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/logo/'. $post_image;   
        //     $file->move($imagePath, $post_image);
        // }
        else{
            $request->validate([
                'change_logo'          => 'required',
                'status'               => 'required',
                'itstatus'             => 'required',
            ]);
            if($request->hasfile('change_logo'))
            {
                $file = $request->change_logo;
                $path = storage_path().'/staff/'.Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/logo';
                File::makeDirectory($path, $mode = 0777, true, true);
                $imagePath = storage_path().'/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/logo';         
                $post_image        = time().$file->getClientOriginalName();
                $image_url          = 'https://phpstack-102119-2434585.cloudwaysapps.com//storage/staff/'. Auth::guard('staff')->user()->name.Auth::guard('staff')->user()->id.'/logo/'. $post_image;   
                $file->move($imagePath, $post_image);
            }
             DB::table('staff_logo')->insert([
               
            'staff_id' => Auth::guard('staff')->user()->id,
           
            'logo'     => $image_url,
            'status'   => $request->status,
            'status_it' => $request->itstatus
            ]);
            return redirect()->back()->with('status', 'saved');
        }
        // if($data){
        //     DB::table('staff_logo')->where('staff_id',Auth::guard('staff')->user()->id)->update([
        //     'logo'     => $image_url,
        //     'status'   => $request->status,
        //     'status_it' => $request->itstatus
        //     ]);
        //     return back()->with('status', 'saved');
        // }
        // DB::table('staff_logo')->insert([
        //     'staff_id' => Auth::guard('staff')->user()->id,
        //     'logo'     => $image_url,
        //     'status'   => $request->status,
        //     'status_it' => $request->itstatus
        //     ]);
        return redirect()->back()->with('status', 'saved');
    }
    public function delete_issue($id)
    {
        DB::table('account_issue')->where('id',$id)->delete();
        return redirect()->back();
    }

    public function manage_staff_order(Request $request){

         if ($request->ajax()) {

            $data = Staff::where('restor_id',Auth::guard('restaurant')->user()->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name ?? '-';
                })
                ->addColumn('Total_Order', function($row){               
                    return DB::table('order_details')->where('staff_id',$row->id)->count();
                })
                ->addColumn('action', function($row){
                    $url = url('Restaurant/manage_orders',$row->id);
                    $actionBtn = '<a href="'.$url.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" >
                          <i class="material-icons opacity-10">remove_red_eye</i>
                        </a>';
                        
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Restaurant.manage_staff');
    }

     public function manage_orders(Request $request,$staff_id){
         $staff_name = DB::table('staff')->where('id',$staff_id)->first();
        if ($request->ajax()) {       
            $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->where('payment_status',1)->latest('id')->get();
            return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('order_id', function($row){               
                    return '00'.$row->id;
                }) 
            ->addColumn('Staff_name', function($row){               
                    return DB::table('staff')->where('id',$row->staff_id)->value('name');
                })
            ->addColumn('payment_status', function($row){               
                    return $row->payment_status == 1 ? '<span class="badge bg-secondary">Received</span>' : '<span class="badge bg-secondary">Fail</span>';
                 })  
            ->addColumn('total_payment', function($row){               
                    return '€'.number_format($row->total_payment,2);
                })
            ->addColumn('created_at', function($row){               
                    return ($row->created_at)->format('d/m/Y H:i:s A');
                })
            ->addColumn('order_items', function($row){ 
                    $order_items = OrderItem::where('order_id',$row->id)->count();
                    // $items = '<ul>';
                    // foreach ($order_items as  $value) 
                    // {
                    //    $items .= '<li style="text-align:left"><b>'.$value->menu_item_name.' ('.$value->price.' * '.$value->count .' = '.$value->total_price .')</b></li>';         
                    // }  
                    // $items .= '</ul>';         
                    return $order_items;
                })
            ->addColumn('action', function($row){
                    $url = url('Restaurant/manage_order_items',$row->id);
                    $actionBtn = '<a href="'.$url.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" >
                          <i class="material-icons opacity-10">remove_red_eye</i>
                        </a>';
                        
                    return $actionBtn;
                })
            ->rawColumns(['payment_status','action'])
            ->make(true);           
        }
        return view('Restaurant.manage_orders',compact('staff_id','staff_name'));
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
        return view('Restaurant.manage_order_items',compact('orderId','orderDetail'));
    }

    public function manage_payment(Request $request){
         if ($request->ajax()) {

            $data = Staff::where('restor_id',Auth::guard('restaurant')->user()->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name ?? '-';
                })
                ->addColumn('payment', function($row){
                    return '€'.number_format(DB::table('order_details')->where('staff_id',$row->id)->sum('total_payment'),2);
                })
                ->addColumn('action', function($row){
                    $url = url('Restaurant/manage_payment_orders',$row->id);
                    $actionBtn = '<a href="'.$url.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" >
                          <i class="material-icons opacity-10">remove_red_eye</i>
                        </a>';
                        
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Restaurant.manage_payment');
    }

    public function manage_payment_orders(Request $request,$staff_id){
        if ($request->ajax()) {       
            $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->where('payment_status',1)->latest('id')->get();
    
            return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('order_id', function($row){               
                    return '00'.$row->id;
                }) 
            ->addColumn('Staff_name', function($row){               
                    return DB::table('staff')->where('id',$row->staff_id)->value('name');
                })
            ->addColumn('payment_status', function($row){               
                    return $row->payment_status == 1 ? '<span class="badge bg-secondary">Received</span>' : '<span class="badge bg-secondary">Fail</span>';
                 }) 
             ->addColumn('created_at', function($row){               
                    return ($row->created_at)->format('d/m/Y H:i:s A');
                }) 
            ->addColumn('total_payment', function($row){               
                    return '€'.number_format($row->total_payment,2);
                })
            ->addColumn('order_items', function($row){ 
                    $order_items = OrderItem::where('order_id',$row->id)->count();
                    // $items = '<ul>';
                    // foreach ($order_items as  $value) 
                    // {
                    //    $items .= '<li style="text-align:left"><b>'.$value->menu_item_name.' ('.$value->price.' * '.$value->count .' = '.$value->total_price .')</b></li>';         
                    // }  
                    // $items .= '</ul>';         
                    return $order_items;
                })
            ->addColumn('action', function($row){
                    $url = url('Restaurant/manage_order_items',$row->id);
                    $actionBtn = '<a href="'.$url.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" >
                          <i class="material-icons opacity-10">remove_red_eye</i>
                        </a>';
                        
                    return $actionBtn;
                })
            ->rawColumns(['payment_status','action'])
            ->make(true);           
        }
        return view('Restaurant.manage_payment_orders',compact('staff_id'));
    }
        public function manage_reports(Request $request)
        {
            if ($request->ajax()) {

                $data = Staff::where('restor_id',Auth::guard('restaurant')->user()->id)->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('name', function($row){
                        return $row->name ?? '-';
                    })
                    ->addColumn('action', function($row){
                        $url = url('Restaurant/manage_orders_report',$row->id);
                        $actionBtn = '<a href="'.$url.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" >
                            <i class="material-icons opacity-10">remove_red_eye</i>
                            </a>';
                            
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('Restaurant.manage_reports');
        }
        public function manage_orders_report(Request $request,$staff_id){
            $staff = DB::table('staff')->where('id',$staff_id)->value('name');
            $earning = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->where('payment_status',1)->latest('id')->sum('total_payment');
            // dd($payment);
            if ($request->ajax()) {   
            //    dd($request->value);
                $now = Carbon::now(); 
                $yesterday = Carbon::yesterday();
                $date = Carbon::now()->subDays(7);
  
                if($request->from_date)
                {
                  
                 $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)
                 ->whereDate('created_at','>=',$request->from_date)
                 ->whereDate('created_at','<=',$request->to_date)
                //  ->whereBetween('created_at', [$request->from_date, $request->to_date])
                 ->where('payment_status',1)->latest('id')->get();
                 $earning = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id) ->whereDate('created_at','>=',$request->from_date)
                 ->whereDate('created_at','<=',$request->to_date)->where('payment_status',1)->latest('id')->sum('total_payment');
                //  dd( $earning);
                }
                else{
                    $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->where('payment_status',1)->latest('id')->get();
                    $earning = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->where('payment_status',1)->latest('id')->sum('total_payment');
                   
                  
                }
                if($request->value == 'today')
                {
                    $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at',$now)->where('payment_status',1)->latest('id')->get();
                } 
                if($request->value == 'yesterday')
                {
                    $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at', $yesterday)->where('payment_status',1)->latest('id')->get(); 
                }  
                if($request->value == 'weekly')
                {
                    // $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('payment_status',1)->latest('id')->get();
                    $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at','>=',$date)->where('payment_status',1)->latest('id')->get();  
                } 
                if($request->value == 'monthly')
                {
                    $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereMonth('created_at',Carbon::now()->month)->where('payment_status',1)->latest('id')->get(); 
                } 
                return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('order_id', function($row){               
                        return '00'.$row->id;
                    }) 
                ->addColumn('Staff_name', function($row){               
                        return DB::table('staff')->where('id',$row->staff_id)->value('name');
                    })
                ->addColumn('payment_status', function($row){               
                        return $row->payment_status == 1 ? '<span class="badge bg-secondary">Received</span>' : '<span class="badge bg-secondary">Fail</span>';
                     })  
                ->addColumn('total_payment', function($row){               
                        return '€'.number_format($row->total_payment,2);
                    })
                ->addColumn('created_at', function($row){               
                        return ($row->created_at)->format('d/m/Y H:i:s A');
                    })
                ->addColumn('order_items', function($row){ 
                        $order_items = OrderItem::where('order_id',$row->id)->count();
                        // $items = '<ul>';
                        // foreach ($order_items as  $value) 
                        // {
                        //    $items .= '<li style="text-align:left"><b>'.$value->menu_item_name.' ('.$value->price.' * '.$value->count .' = '.$value->total_price .')</b></li>';         
                        // }  
                        // $items .= '</ul>';         
                        return $order_items;
                    })
                ->addColumn('action', function($row){
                        $url = url('Restaurant/manage_order_items',$row->id);
                        $actionBtn = '<a href="'.$url.'" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" >
                              <i class="material-icons opacity-10">remove_red_eye</i>
                            </a>';
                            
                        return $actionBtn;
                    })
                ->rawColumns(['payment_status','action'])
                ->make(true);           
            }
            return view('Restaurant.manage_order_report',compact('staff_id','staff','earning'));
        }

        public function export_pdf(Request $request,$staff_id)
        {
            $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->where('payment_status',1)->get();
            view()->share ('orders', $orders);
            $staff = DB::table('staff')->where('id',$staff_id)->value('name');
            $earning = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->where('payment_status',1)->latest('id')->sum('total_payment');
            // $pdf = PDF ::loadView ('manage_order_report', $orders);
            // dd($pdf);
            // return $pdf->download ('file-pdf.pdf');
            $pdf = PDF::loadView('Restaurant.order_table',['orders' => $orders,'staff_id' =>$staff_id,'staff' =>$staff,'earning'=>$earning ] )->setOptions(['defaultFont' => 'sans-serif']);
            // dd($pdf);
            return $pdf->download('order-pdf.pdf');   
        }
        public function order_table(Request $request, $staff_id)
        {
                $now = Carbon::now(); 
                $yesterday = Carbon::yesterday();
                $date = Carbon::now()->subDays(7);
            // dd($request->value);
            if($request->from_date && $request->to_date )
            {
                $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)
                ->whereDate('created_at','>=',$request->from_date)
                ->whereDate('created_at','<=',$request->to_date)
            //  ->whereBetween('created_at', [$request->from_date, $request->to_date])
                ->where('payment_status',1)->latest('id')->orderBy('id', 'DESC')->get();

                $earning = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at','>=',$request->from_date)->whereDate('created_at','<=',$request->to_date)->where('payment_status',1)->latest('id')->sum('total_payment');
                $staff = DB::table('staff')->where('id',$staff_id)->value('name');
                $pdf = PDF::loadView('Restaurant.order_table',['orders' => $orders,'staff_id' =>$staff_id,'staff' =>$staff,'earning'=>$earning ] )->setOptions(['defaultFont' => 'sans-serif']);
                $path = public_path('pdf/'); 
                $fileName =  time().'.'. 'pdf' ; 
                $pdf->save($path . '/' . $fileName); 
                $pdf = public_path('pdf/'.$fileName); 
                return response()->json($fileName);
            }
            if($request->value == 'today')
            {
                $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at',$now)->where('payment_status',1)->latest('id')->get();
                $earning = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at',$now)->where('payment_status',1)->latest('id')->sum('total_payment');
                $staff = DB::table('staff')->where('id',$staff_id)->value('name');
                $pdf = PDF::loadView('Restaurant.order_table',['orders' => $orders,'staff_id' =>$staff_id,'staff' =>$staff,'earning'=>$earning ] )->setOptions(['defaultFont' => 'sans-serif']);
                $path = public_path('pdf/'); 
                $fileName =  time().'.'. 'pdf' ; 
                $pdf->save($path . '/' . $fileName);
                $pdf = public_path('pdf/'.$fileName);            
                return response()->json($fileName);
            } 
            if($request->value == 'yesterday')
            {
                $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at', $yesterday)->where('payment_status',1)->latest('id')->get(); 
                $earning = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at',$yesterday)->where('payment_status',1)->latest('id')->sum('total_payment');
                $staff = DB::table('staff')->where('id',$staff_id)->value('name');
                $pdf = PDF::loadView('Restaurant.order_table',['orders' => $orders,'staff_id' =>$staff_id,'staff' =>$staff,'earning'=>$earning ] )->setOptions(['defaultFont' => 'sans-serif']);
                $path = public_path('pdf/'); 
                $fileName =  time().'.'. 'pdf' ; 
                $pdf->save($path . '/' . $fileName);
                $pdf = public_path('pdf/'.$fileName);            
                return response()->json($fileName);
            }  
            if($request->value == 'weekly')
            {
                // $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('payment_status',1)->latest('id')->get();
                $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at','>=',$date)->where('payment_status',1)->latest('id')->get(); 
                $earning = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereDate('created_at','>=',$date)->where('payment_status',1)->latest('id')->sum('total_payment');
                $staff = DB::table('staff')->where('id',$staff_id)->value('name');
                $pdf = PDF::loadView('Restaurant.order_table',['orders' => $orders,'staff_id' =>$staff_id,'staff' =>$staff,'earning'=>$earning ] )->setOptions(['defaultFont' => 'sans-serif']);
                $path = public_path('pdf/'); 
                $fileName =  time().'.'. 'pdf' ; 
                $pdf->save($path . '/' . $fileName);
                $pdf = public_path('pdf/'.$fileName);            
                return response()->json($fileName); 
            } 
            if($request->value == 'monthly')
            {
                $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereMonth('created_at',Carbon::now()->month)->where('payment_status',1)->latest('id')->get(); 
                $earning = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->whereMonth('created_at',Carbon::now()->month)->where('payment_status',1)->latest('id')->sum('total_payment');
                $staff = DB::table('staff')->where('id',$staff_id)->value('name');
                $pdf = PDF::loadView('Restaurant.order_table',['orders' => $orders,'staff_id' =>$staff_id,'staff' =>$staff,'earning'=>$earning ] )->setOptions(['defaultFont' => 'sans-serif']);
                $path = public_path('pdf/'); 
                $fileName =  time().'.'. 'pdf' ; 
                $pdf->save($path . '/' . $fileName);
                $pdf = public_path('pdf/'.$fileName);            
                return response()->json($fileName);
            } 
            else{
                $orders = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->where('payment_status',1)->orderBy('id', 'DESC')->get();

                $earning = Order::where('staff_id',$staff_id)->where('rest_id',Auth::guard('restaurant')->user()->id)->where('payment_status',1)->latest('id')->sum('total_payment');
                $staff = DB::table('staff')->where('id',$staff_id)->value('name');

                

                $pdf = PDF::loadView('Restaurant.order_table',['orders' => $orders,'staff_id' =>$staff_id,'staff' =>$staff,'earning'=>$earning ] )->setOptions(['defaultFont' => 'sans-serif']);
                // dd($pdf);
                $path = public_path('pdf/'); 

                $fileName =  time().'.'. 'pdf' ; 

                $pdf->save($path . '/' . $fileName); 



                $pdf = public_path('pdf/'.$fileName); 
                // try { 
                //     $pdf->download($pdf);  
                //  }
                // catch (\Exception $e) {
                //     // add error
                    
                // }
                 
                return response()->json($fileName);
            }
           
            // return response()->json(view('Restaurant.order_table',['orders'=>$orders,'staff'=>$staff,'earning'=>$earning])->render());
        }
    
}
