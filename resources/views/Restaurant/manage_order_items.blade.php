@extends('Restaurant.layout.App')
@section('bg-gradient','active')
<style>
  .paginate_button {
     margin-right: 8px !important;
 }
 #table_id_previous{
   border: 1px solid;
   padding-left: 5px;
   padding-right: 5px;
 }
 #table_id_next{
   border: 1px solid;
   padding-left: 5px;
   padding-right: 5px;
 }
 </style>
@section('main_section')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Manage Orders Items</h6>
        </nav>
        
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-1 " style="height: 106px;">
                <h6 class="text-white text-capitalize ps-3">Order ID : - 00{{$orderId}}</h6>
                <div style="position: relative;
                left: 15px;color:white;font-weight:500;bottom: 10px;"> 
                  Total Payment:- €{{number_format($orderDetail->total_payment,2)}} <br>
                  Payment Status:- {{$orderDetail->payment_status == 1 ? 'Success' : 'Fail'}}
                </div>
               
                <div class="col-5" style="text-align: right; margin-left: 59%; height: 59px">
                  <a href="{{url()->previous()}}" style="color: white !important;padding: 1px 68px 12px 7px;"><i class="material-icons opacity-10" style="position: relative;bottom: 44px;">arrow_back</i></a>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive" style="padding: 3px 20px;">
                <table class="table align-items-center mb-0" id="table_id" style="width: 991px !important">
                  <thead>
                    <tr>
                      <th class="text-secondary text-xxs font-weight-bolder ">ID</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">Menu Name</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">Menu Price</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">Quantity</th>
                      <th class="text-center text-secondary text-xxs font-weight-bolder " >Total Price</th>                     
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
      {{-- <section>
        <table class="table align-items-center mb-0  bg-white"  style="width: 341px !important">
        <thead>
          <tr>
            <th class="text-secondary text-xxs font-weight-bolder text-center" colspan="2"><h6>Order Detail</h6></th>
            </tr>
            <tr>
          <tr>
            <th class="text-secondary text-xxs font-weight-bolder ">Order ID</th>
            <td class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">00{{$orderDetail->id}}</td></tr>
            <tr>
            <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">Payment Status</td>
            <td class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">{{$orderDetail->payment_status == 1 ? 'Success' : 'Fail'}}</td>
            <tr>
            <th class=" text-secondary text-xxs font-weight-bolder " >Total Amount</th>
             <td class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">€{{number_format($orderDetail->total_payment,2)}}</td>                     
          </tr>
        </thead>
        <tbody>
        
        </tbody>
      </table>
      </section>        --}}
     
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  
<script>
$(document).ready(function () {
    $('#table_id').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('Restaurant/manage_order_items',$orderId) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false},
            {data: 'menu_item_name', name:'menu_item_name'},
            {data: 'price', name:'price','className': 'text-center'},
            {data: 'count', name:'count', 'className': 'text-center'},
            {data: 'total_price', name:'total_price', searchable: false, 'className': 'text-center'},           
        ]
    });
});



</script>

