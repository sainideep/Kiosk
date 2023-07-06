@extends('Staff.Layout.App')
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
          <h6 class="font-weight-bolder mb-0">Manage Wallet</h6>
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
                <h6 class="text-white text-capitalize ps-3">Manage Wallet</h6>
                {{-- <div class="col-5" id="amount" style="text-align: right; margin-left: 50%; height: 59px;color: white">
                   <h5>Total Earning:220 </h5> 
                </div> --}}
                <h5 style="text-align: right;margin-right: 32px;color: white">Total Earning: €{{$earning}}</h5>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive" style="padding: 3px 20px;padding-top: 97px;height: 461px;overflow-y: scroll;">
                <table class="table align-items-center mb-0" id="table_id" style="width: 991px !important">
                  <thead>
                    <tr>
                      <th class="text-secondary text-xxs font-weight-bolder ">ID</th>
                      <th class="text-secondary text-xxs font-weight-bolder ">Order ID</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">TOTAL PAYMENT</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">PAYMENT STATUS</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">Order At</th>
                                          
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
 
  @endsection
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  
<script>
$(document).ready(function () {
    $('#table_id').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('Staff/orders') }}",
        drawCallback: function () {
          var api = this.api();
          var Total = api.column(2).data().reduce(function (a, b) {  return parseInt(a) + parseInt(b); }, 0);  
          console.log(Total)
          $('#amount').html('<h5 style="position: relative;left: 75px;">Total Earning: € '+Total.toFixed(2)+ '</h5>')
               
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false},
            {data: 'order_id', name:'order_id'},
            {data: 'total_payment', name:'total_payment','className': 'text-center'},
            {data: 'payment_status', name:'payment_status', 'className': 'text-center'},
            {data: 'created_at', name:'created_at', 'className': 'text-center'},
           
        ]
    });
});



</script>

