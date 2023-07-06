@extends('Restaurant.layout.App')
<style>
  .paginate_button {
     margin-right: 8px !important;
 }
 #device_table_previous{
   border: 1px solid;
   padding-left: 5px;
   padding-right: 5px;
 }
 #device_table_next{
   border: 1px solid;
   padding-left: 5px;
   padding-right: 5px;
 }
 .loader {
        border: 2px solid #f3f3f3;
        border-radius: 50%;
        border-top: 2px solid blue;
        border-bottom: 2px solid blue;
        width: 20px;
        height: 20px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
        margin-left: 50%;
    }

   
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

 </style>
@section('main_section')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
   <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">          
              <h6 class="font-weight-bolder mb-0">Manage Device</h6>
          </div>
        </nav>
      </div>
    </nav>
    <!-- End Navbar --> 
    <div class="container-fluid ">
       <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2">
                <div class="row">
                  <div class="col-6">
                    <h6 class="text-white text-capitalize ps-3">Manage Devices</h6>
                  </div>
                  <div class="col-5" style="text-align: right;margin-left: 59px">
                     <button class="btn bg-gradient-primary mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" style="width: max-content;background: beige; color: black"> Add New Device</button>
                  </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive" style="padding: 3px 20px">
                <table class="table align-items-center mb-0" id="device_table" style="width: 100%">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">S.No</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Action</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Staff Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Device Name</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder" style="text-align: center;">Kiosk App Link</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder">Status</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder">POS ID</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder">IP Address</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder"> Fiscal IP Address</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder"> Fiscal Port</th>




                     
                    </tr>
                  </thead>
                  <tbody>
                 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- modal start here  -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add New Device</h5>
              <button type="button" style="    background-color: black;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
             <form id="add_device">
              <div class="modal-body">  
              @csrf             
                  <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Device Name:</label>
                    <input type="text" class="form-control border" id="recipient-name" name="device_name" required="">
                     <p id="device_name" class="d-none text-danger">This Filed is Required</p>
                  </div>  

                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Staff Name:</label>
                     <Select class="form-control border" name="staffId" required="">
                      <option value=""> Select Staff</option>   
                      @foreach($restor as $rest )
                        <option value="{{ $rest->id}}"> {{ $rest->name}}</option>

                      @endforeach                   
                    </Select>
                     <p id="staffId" class="d-none text-danger">This Filed is Required</p>
                  </div>   
                  
                  <div class="mb-3">
                  <div class="row">
                      <div class="col-8">
                      <label for="recipient-name" class="col-form-label">Enter Fiscal Printer IP Address:</label>
                      <input type="text" class="form-control border" placeholder="xxx.xxx.xxx.xx" id="fiscal_ip" name="fiscal_ip" >
                      <p id="fiscal_ip" class="d-none text-danger">This Filed is Required</p>
                      </div>

                      <div class="col-4">
                      <label for="recipient-name" class="col-form-label">Fiscal  Port:</label>
                      <input type="text" class="form-control border" placeholder="Enter Port" id="fiscal_port" name="fiscal_port" >
                      <p id="fiscal_port" class="d-none text-danger">This Filed is Required</p>
                      </div>


                    </div>
                  </div>  


                  
                 
                  
                  <div class="mb-3 ">
                    <div class="row">
                      <div class="col-9">
                        <label for="ip-name" class="col-form-label">Enter Raspberry IP Address:</label>
                        <input type="text" class="form-control border"  placeholder="xxx.xxx.xxx.xx" id="ip_address" name="ip_address" required=""> 
                    </div>
                      <div class=" col-3 " style="margin-top: 2.6rem;">
                        <button class="btn btn-success btn-md" id="get_pos" type="button">Get  Pos</button>
                      </div>
                  </div>
                  <div class="pos_status" style="display:none;">No Pos Available On This IP Address</div>
                     <p id="ip_address" class="d-none text-danger">This Filed is Required</p>
                     @error('ip_address') <div class="d-none text-danger ">Please Enter Valid IP Address</div>@enderror

                  </div>   

                  <div style="display: none;" class="loader"></div>
                  <div class="mb-3 pos_devices" style="display: none;" > 
                    <label for="message-text" class="col-form-label">Select POS Device:</label>
                    
                     <Select class="form-control border" name="posid" required="" id="sel">
                      <option value=""> Select POS Device</option>   
                   
                    </Select>
                     <p id="posid" class="d-none text-danger">This Filed is Required</p>
                     
                  </div>  

                               
              </div>
              <div class="modal-footer butt_close" style="display: none;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit"   class="btn bg-gradient-primary">Add Device</button>
              </div>
          </form>
          </div>
        </div>
      </div>

        <!-- end modal here -->
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>  
  <script> 
    var table = $('#device_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('Restaurant/manage_devices') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: false
            },
            {data: 'staff_name'},
            {data: 'device_name'},
            {data: 'unique_link', searchable: false},
            {data: 'status', searchable: false},
            {data: 'posID', searchable: false},
            {data: 'ip_address', searchable: false},
            {data: 'fiscal_ip', searchable: false},
            {data: 'fiscal_port', searchable: false},




            
        ]
    });     
  </script> 
  <!-- <script>
    var ipv4_address = $('#ipv4');
ipv4_address.inputmask({
    alias: "ip",
    greedy: false //The initial mask shown will be "" instead of "-____".
});
  </script> -->
   <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
   
   <script>
$('#get_pos').on('click', function(e){
  e.preventDefault();

   var ip_address = $('#ip_address').val();
    $(".pos_devices").hide();
    $('#sel').html('');
    $('.loader').show();

   $.ajax({
     url: "http://"+ip_address+':'+'8080'+"/rsb2pos/poslist",
     method: "POST",
     success: function(response) {
          console.log(response);
          $(".pos_status").css("display", "none");
          $('#sel').html('');
        $.each(response, function (i, item) {
       
  
        $.each(item, function (index, value) {
          console.log(value);

          if(value.PosStatus== "OK"){
          $(".pos_devices").show();
          $(".butt_close").show();
          $('#sel').append('<option value="' + value.PosId + '">POS ' + ' ' + value.PosId + ' '+ '(' +value.PosStatus + ')'+ '</option>');
          $('.loader').hide();

          }
         
     
        });
   
 
      });
  },
  error: function(xhr, status, error) {
        console.log("Error: " + status + " - " + error);
        $('#sel').append('');
        // $('.loader').show();
        setTimeout(function(){
        $('.loader').hide();
        }, 5000);
        $(".pos_devices").hide();
        $(".butt_close").hide();

        $(".pos_status").css("display", "block");

    }
  });

});


   </script>

  <script type="text/javascript">   
    $( '#add_device' ).on( 'submit', function(e) {
        e.preventDefault();
        var data = new FormData(this);
        // var ip_address = $('#ip_address').val();
        // var settings = {
        // "url": "https://"+ip_address+"/rsb2pos/version",
        // "method": "POST",
        // "timeout": 0,
        // };

        // $.ajax(settings).done(function (response) {
        // console.log(response);
        // });

        $.ajax({
            type: "POST",
            url:"{{'add_device'}}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {              
                if(data.status == 0){
                  $.each(data.message, function (key, value) {
                         $('#'+key).removeClass('d-none');
                         $('#'+key).html(value[0]);
                      });
                  }
                  if(data.status == 1){
                      Swal.fire(
                      'Good job!',
                      'Staff Added!',
                      'success'
                    )
                      location.reload();
                  }
            }
        });

    });
  </script>



<script type="text/javascript">   

    $('#get_pos').on('click', function(e){
      e.preventDefault();
      var ip_address = $('#ip_address').val();

      
      
      var settings = {
      "url": "https://"+ip_address+':'+'443'+"/rsb2pos/poslist",
      "method": "POST",
      "timeout": 0,
    };

    $(".pos_devices").hide();
    $('#sel').html('');
    $('.loader').show();

      setTimeout(function(){
        $.ajax(settings).done(function (response) {

      $(".pos_status").css("display", "none");
      $('#sel').html('');
      $.each(response, function (i, item) {
            
        
              $.each(item, function (index, value) {
                console.log(value);

                if(value.PosStatus== "OK"){
                  

                  $(".pos_devices").show();

                  
                  $(".butt_close").show();



                  $('#sel').append('<option value="' + value.PosId + '">POS ' + ' ' + value.PosId + ' '+ '(' +value.PosStatus + ')'+ '</option>');
                  $('.loader').hide();
                }
              
          
              });
        
      
      });




      }).fail(function (jqXHR, textStatus) {
      $('#sel').append('');
      // $('.loader').show();
      setTimeout(function(){
      $('.loader').hide();
      }, 5000);
      $(".pos_devices").hide();
      $(".butt_close").hide();

      $(".pos_status").css("display", "block");
      });


      
      }, 10000);




      });

</script>

  @endsection
