<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AutoGrill</title>
  <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('css/style.css')}}">
  <script src="{{url('js/jquery.slim.min.js')}}"></script>
  <script src="{{url('js/popper.min.js')}}"></script>
  <script src="{{url('js/bootstrap.bundle.min.js')}}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
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
        <div class="col-md-6 col-lg-6 col-sm-6">
          <a href="javascript:delay('{{url('thankyou',['staff_id' =>$staff_id, 'order_id' => $order_id])}}')" class="active"><div class="payment_option active_payment">
            <div class="wrap_checkouts">
              <img src="{{url('images/first_option.png')}}" alt="payment icons" class="payment_img" id="play">
              <h5 class="credit_card">Credit Card / Debit Card</h5>
            </div>
            <p><span class="tick_imgs"><img src="{{url('images/tick.png')}}" class="tick image" alt="tick"></span></p>
          </div></a>
        </div>

        <div class="col-md-6 col-lg-6 col-sm-6">
          <a href="javascript:delay('{{url('thankyou',['staff_id' =>$staff_id, 'order_id' => $order_id])}}')"><div class="payment_option">
            <div class="wrap_checkouts">
              <img src="{{url('images/second_option.png')}}" alt="payment icons" class="payment_img">
              <h5 class="credit_card">SatisPay</h5>
            </div>
            <p><span class="tick_imgs"><img src="{{url('images/tick.png')}}" class="tick image" alt="tick"></span></p>
          </div></a>
        </div>

        <div class="col-md-6 col-lg-6 col-sm-6">
          <a href="javascript:delay('{{url('thankyou',['staff_id' =>$staff_id, 'order_id' => $order_id])}}')"><div class="payment_option">
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
        </div>
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
  </script>