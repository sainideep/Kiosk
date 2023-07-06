@extends('Restaurant.layout.App')
@section('bg-mmm','active')
<style>
  .paginate_button{
    margin-right:8px !important;
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

  #todayfilter{
    padding: .3125rem 3rem .3125rem 1rem;
    background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E');
    background-repeat: no-repeat, repeat;
    background-position: right 1rem center;
    border-radius: .25rem;
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
    border: 1px solid #d8e2ef;
    color: #344040;
    background-size: 10px 12px;
    background-color: #fff;
    box-shadow: 0 1px 2px rgba(0,0,0,0.075);
    outline:none;
}
</style>
@section('main_section')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Manage Orders Report({{$staff}})</h6>
        </nav>
        
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-1 " style="width: 100%;height: 115px;">
                <h6 class="text-white text-capitalize ps-3">Manage Orders Report</h6>
                <div class="col-5" id="amount" style="text-align: right; margin-left: 59%; height: 59px;color: white">
                  <h5 style="position: relative;left: -65px;margin-top:-15px;">Total Earning: €{{$earning}}</h5>
                </div>  
               <button  class="btn btn-primary" type="button"  id="downloadpdf"  style="width: max-content;background: beige; color: black;padding: inherit;width: 136px;float: right;margin-right: 10px;">Download Report</button>     
              </div>
            </div>
          
            <div class="card-body px-0 pb-2"> 
              <div class="row input-daterange" style="z-index:9;">
                <div class="col-md-4" style="width: 200px;position: relative;left: 20px;">
                    <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" style="border: 1px solid;height: 25px;background: white;margin-top:10px;" />
                </div>
                <div class="col-md-4" style="width: 200px;position: relative;left: 5px;">
                    <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" style="border: 1px solid;height: 25px;background: white;margin-top:10px;"  />
                </div>
                <div class="col-md-4" style="background: white;margin-top:10px;">
                    <button type="button" name="filter" id="filter" class="btn bg-gradient-primary" style="height: 25px;padding: inherit;">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-secondary" style="height: 25px;padding: inherit;">Clear</button>
                </div>
            </div>
            <div class="form-group" style="margin-top: -66px;float: right;margin-right: 76px;z-index:9;">
              <label for="" style="color: black">Filter By:</label>
              <select class="form-control" name="todayfilter" id="todayfilter" style="border: 1px solid;width: 129px;height: 30px;margin-top: -7px;text-align:center;">
                <option value="">All</option>
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="weekly">This Week</option>
                <option value="monthly">This Month</option>
              </select>
            </div>
              <div class="table-responsive" style="padding: 3px 20px;padding-top: 38px;">
                <table class="table align-items-center mb-0" id="table_id" style="width: 991px !important">
                  <thead>
                    <tr>
                      <th class="text-secondary text-xxs font-weight-bolder ">ID</th>
                      <th class="text-secondary text-xxs font-weight-bolder ">Order ID</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">TOTAL PAYMENT</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">PAYMENT STATUS</th>
                      <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">ORDER ITEMS</th>
                       <th class="text-secondary text-xxs font-weight-bolder " style="text-transform: inherit;">ORDER AT</th>
                      {{-- <th class="text-center text-secondary text-xxs font-weight-bolder " >ACTION</th>                      --}}
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
      <a id="download" download></a>
    </div>
  </main>
  {{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
   
      
        <div class="tab-content">
          <div id="home" class="tab-pane fade in active show">
            <div class="modal-body">
              <form action="{{url('Staff/add_category')}}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label" style="text-transform: inherit;">Category Name (en)</label>
                  <input type="text" class="form-control @error('category') is-invalid @enderror" placeholder="Enter English Name" name="categoryEn" id="category" required="">
                  @error('category')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('category') }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label" style="text-transform: inherit;">NOME DELLA CATEGORIA (it)</label>
                  <input type="text" class="form-control @error('category') is-invalid @enderror" placeholder="Enter Italian Name" name="categoryItl" id="category" required="">
                  @error('category')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('category') }}</strong>
                  </span>
                  @enderror
                </div>                
                <div class="form-group">
                  <label for="">Category Image (120*120)</label>
                  <input type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" id="image" accept="image/x-png,image/jpeg" required="" />
                  @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('image') }}</strong>
                  </span>
                  @enderror
                </div>                
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn bg-gradient-primary" id="submitForm">Add Category</button>
                </div>
              </form>
            </div>
          </div>
       
       
      </div>
    </div>
  </div> --}}
 
  @endsection
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  
  <script>
    $(document).ready(function () {
    //   $('.input-daterange').datepicker({
    //   todayBtn:'linked',
    //   format:'yyyy-mm-dd',
    //   autoclose:true
    //  });
    load_data();
    function load_data(from_date = '', to_date = '', value = '')
     {
        $('#table_id').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
            url: "{{ url('Restaurant/manage_orders_report')}}/{{ Request::segment(3) }}",
            data:{from_date:from_date, to_date:to_date, value:value},
           },
            // drawCallback: function () {
             
            //   var api = this.api();
            //   // alert(api);
            //   var Total = api.column(1).data().reduce(function (a, b) {  return parseInt(a) + parseInt(b); }, 0);  
            //   console.log(Total)
            //   $('#amount').html('<h5 style="position: relative;left: -15px;">Total Earning: € '+Total.toFixed(1)+ '</h5>')
            
            // },
          
            // data:{from_date:from_date, to_date:to_date}
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false},
                {data: 'order_id', name:'order_id'},
                {data: 'total_payment', name:'total_payment','className': 'text-center'},
                {data: 'payment_status', name:'payment_status', 'className': 'text-center'},
                {data: 'order_items', name:'order_items', searchable: false, 'className': 'text-center'},    
                {data: 'created_at', name:'created_at', searchable: false, 'className': 'text-center'},       
                // {
                //   data: 'action', searchable: false
                // },
            ]
         
        });
      }
      $('#filter').click(function(){
      var from_date = $('#from_date').val();
      // alert(from_date);
      var to_date = $('#to_date').val();
      if(from_date != '' &&  to_date != '')
      {
       $('#table_id').DataTable().destroy();
       load_data(from_date, to_date);
      }
      else
      {
       alert('Both Date are required');
      }
     });
    
     $('#refresh').click(function(){
      //  alert('hh');
      $('#from_date').val('');
      $('#to_date').val('');
      $('#table_id').DataTable().destroy();
      load_data();
     });

     $('#todayfilter').change(function(){
      var from_date = $('#from_date').val();
      // alert(from_date);
      var to_date = $('#to_date').val();
      var value = $(this).val();
      // alert(value);
      $('#table_id').DataTable().destroy();
       load_data(from_date, to_date, value);
      
    });

    });
    
    // $('#filter').change(function(){
    //   // alert('hh');  
    //      $('#table_id').DataTable().draw(true);
    // }); 
    
    </script>
{{-- <script>
  $(document).ready(function () {
   
  $('#filter').change(function () {
    // $('#table_id').DataTable().draw(true);
    var value = $(this).find(':selected')[0].value;
    // alert(value);
    $.ajax({
        type: 'get',
        url: '{{ url("Restaurant/manage_orders_report")}}/{{ Request::segment(3) }}',
        data: {
            'value': value
        },
        success: function (data) {
        console.log(data)
        }
        
    });
    
});
  });
  </script> --}}
  {{-- <script>
    $(document).ready(function(){
      $('#filter').click(function(){
      var from_date = $('#from_date').val();
      // alert(from_date);
      var to_date = $('#to_date').val();
      $.ajax({
        type: 'get',
        url: "{{ url('Restaurant/order_table')}}/{{ Request::segment(3) }}",
        dataType: 'json',
        data:{'from_date':from_date, 'to_date':to_date,'method':'ajax'},       
        success: function (data) {
          
              console.log(data);
             
           
                  
        },
      
    });

   
      });
    });
  </script> --}}
  <script>
    $(document).ready(function(){
      $('#downloadpdf').click(function(){

      var from_date = $('#from_date').val();
      // alert(from_date);
      var to_date = $('#to_date').val();
      var value = $('#todayfilter').val();
      // if(from_date != '' &&  to_date != '')
      // {
        
      $.ajax({
        type: 'get',
        url: "{{ url('Restaurant/order_table')}}/{{ Request::segment(3) }}",
        dataType: 'json',
        data:{'from_date':from_date, 'to_date':to_date, 'value':value},       
        success: function (response) {
          $('#download').attr('href',"{{url('/pdf/')}}"+"/"+response);
          $('#download')[0].click();
          // window.location.replace("{{url('/pdf/')}}"+"/"+response);
        },
      
    });
  // }else{
  //   alert('select date range');
  // }
     
      
    });

    });

    </script> 
