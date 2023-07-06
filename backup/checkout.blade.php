<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AutoGrill</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('css/style.css')}}">
  <script src="{{url('js/jquery.slim.min.js')}}"></script>
  <script src="{{url('js/popper.min.js')}}"></script>
  <script src="{{url('js/bootstrap.bundle.min.js')}}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<style>
   .loader {
    margin-left: 50%;
    margin-top: 5px;
        border: 2px solid #f3f3f3;
        border-radius: 50%;
        border-top: 2px solid blue;
        border-bottom: 2px solid blue;
        width: 20px;
        height: 20px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }
</style>
<body>
<section class="wrap_welcome">
  <div class="welcome_wraps welcome_traveler-wrap">
    @if($logo)
    <img src="{{$logo->logo}}" class="logo" alt="logo" style="height: 100px;width: 115px;">
    <h1 class="welcome_traveler">{{$logo->status}}</h1>
    @else
    <img src="{{url('images/logo.png')}}" class="logo" alt="logo">
    <h1 class="welcome_traveler">Feel good on the move</h1>
    @endif
  </div>
</section>

<section class="brings_you">
  <div class="wrapper">
    <div class="col-md-12 col-lg-12 col-sm-12">
      <div class="row">
      @if($posid)
        <div class="col-md-6 col-lg-6 col-sm-6">
        
            <div class="payment_option active_payment">
            <div class="wrap_checkouts">
              <img src="{{url('images/first_option.png')}}" alt="payment icons" class="payment_img" id="play">

              <a data-posid="{{ $posid}}" class="active button poslist" data-oid="{{$order_id}}" data-staff_id="{{$staff_id}}" 
              data-PosIpAddr = "" data-MacAddr="">
              <legend  class="credit_card "> POS {{ $posid }} </legend>
              </a>
              <!-- <div class="newinput" style="padding-top: 10px;" id="newinput"></div> -->
            </div>
            
            <p><span class="tick_imgs"><img src="{{url('images/tick.png')}}" class="tick image" alt="tick"></span></p>
          </div>
         
        </div>

        <div class="col-md-6 col-lg-6 col-sm-6">
        
          <!-- <a href="javascript:delay('{{url('thankyou',['staff_id' =>$staff_id, 'order_id' => $order_id])}}')"> -->
            <div class="payment_option">
            <div class="wrap_checkouts">
              <img src="{{url('images/pos_status.png')}}" style="height:250px;" alt="payment icons" class="payment_img">
              <div style="display: none;" class="loader"></div>
              <div class="newinput" style="padding-top: 10px;" id="newinput"></div>
            </div>
            <p><span class="tick_imgs"><img src="{{url('images/tick.png')}}" class="tick image" alt="tick"></span></p>
          </div>
        <!-- </a> -->
        </div>
       
        @else
        <div class="col-md-6 col-lg-6 col-sm-6">
         
            <div class="payment_option active_payment">
            <div class="wrap_checkouts">
              <img src="{{url('images/first_option.png')}}" alt="payment icons" class="payment_img" id="play">
              <a data-posid="" class="active" data-oid="{{$order_id}}" data-staff_id="{{$staff_id}}" >
              Select Your Pos Device</a>
            </div>
            <p><span class="tick_imgs"><img src="{{url('images/tick.png')}}" class="tick image" alt="tick"></span></p>
          </div>
        </div>


        @endif

       

        {{-- <div class="col-md-6 col-lg-6 col-sm-6">
          <a href="javascript:delay('{{url('thankyou',['staff_id' =>$staff_id, 'order_id' => $order_id])}}')">
            <div class="payment_option">
            <div class="wrap_checkouts">
              <img src="{{url('images/third_option.png')}}" alt="payment icons" class="payment_img">
              <h5 class="credit_card">Loram Ipsum</h5>
            </div>
            <p><span class="tick_imgs"><img src="{{url('images/tick.png')}}" class="tick image" alt="tick"></span></p>
          </div></a>
        </div>

        <div class="col-md-6 col-lg-6 col-sm-6">
          <a href="javascript:delay('{{url('thankyou',['staff_id' =>$staff_id, 'order_id' => $order_id])}}')"><div class="payment_option">
            <div class="wrap_checkouts">
              <img src="{{url('images/fourth_option.png')}}" alt="payment icons" class="payment_img">
              <h5 class="credit_card">Auto Card</h5>
            </div>
            <p><span class="tick_imgs"><img src="{{url('images/tick.png')}}" class="tick image" alt="tick"></span></p>
          </div></a>
        </div> --}}
        <div class="buttonwrap_backk">
          <a href="{{url('welcome',$staff_id)}}"><button type="button" class="btn btn-primary backto_cart">Back</button></a>
        </div>
      </div>
    </div>
    
  </div>
</section>
</body>
</html>
<script>
  if( '{{$data}}' == 'en'){
    // alert($data);
  var audio = new Audio("{{url('../storage/staff/Arun/payment_methods.ogg')}}" ) ;
  
  audio.oncanplaythrough = function(){
  audio.play();
  }
  
  audio.loop = false;
 
  }
  else
  {
  var audio = new Audio("{{url('../storage/staff/Arun/scegli_pagamento.ogg')}}" ) ;
  
  audio.oncanplaythrough = function(){
  audio.play();
  }
  
  audio.loop = false;
 

  }
  $('.payment_img').click(function() {
    if( '{{$data}}' == 'en'){
  const audio = new Audio("{{url('../storage/staff/Arun/payment_has_been_made.ogg')}}");
  audio.play();
    }
    else{
  const audio = new Audio("{{url('../storage/staff/Arun/pagamento_effettuato.ogg')}}");
  audio.play();
    }
});

function delay (URL) {
    setTimeout( function() { window.location = URL }, 5000 );
}

$('.poslist').click(function(e){
    e.preventDefault();
    var oid = $(this).data('oid');
    var posid = $(this).data('posid');
    var staff_id = $(this).data('staff_id');
    // var posipaddr = $(this).data('posipaddr');
    // var macaddr = $(this).data('macaddr');

      $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      });
      $('.loader').show();

      $('#newinput').html('');
       
        $.ajax({
          type: 'get',
          url: "{{url('pos_status')}}"+ '/' + staff_id + '/' + oid,
         dataType: "json",
         data:{"Version":"V.110","PosId":posid,"Action":"PosStatus","TerminalId":"12345678"},
        success: function(data) {
         
        if(data.status =='1'){
         
          $('.poslist').css("pointer-events", "none");
         $('#newinput').append('<button class="btn btn-primary" data-oid='+oid+' data-staff_id='+staff_id+' id="payment_ecr" type="button">Pay Now € '+data.data.total_payment+'</button>');
         $('.loader').hide();
        }else{
          $('#newinput').html('');
        } 

      }
        });



  
});
  </script>

  <script>
     $(document).on('click','#payment_ecr',function(e){
       e.preventDefault();
       var oid = $(this).data('oid');
       var staff_id = $(this).data('staff_id');
       $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

       

        $.ajax({
        type: 'post',
        url: "{{url('payment_now')}}"+ '/' + staff_id + '/' + oid,
        //  dataType: "json",
        //  data:{"Version":"V.110","PosId":posid,"Action":"PosStatus","TerminalId":"12345678"},
        success: function(data) {
         console.log(data);
         if(data.status =='1'){
          location.href = "{{url('thankyou')}}"+ '/' + staff_id + '/' + oid;
         }else{
          toastr["error"](data.message, "Error");
          setInterval(function () {
            // location.href = "{{url('welcome',$staff_id)}}";
          }, 2000);          
         }

        }
        });

     });
  </script>