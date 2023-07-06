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
<section class="thankyou">
  <div class="wraps_thankyou">
    @if($logo)
    <img src="{{$logo->logo}}" class="logo" alt="logo" style="height: 120px;width: 136px;">
    @else
    <img src="{{url('images/logo.png')}}" class="logo" alt="logo">
    @endif
    <h1>{{__('lang.thanks')}}</h1>
  </div>
</section>
<script type="text/javascript">

  setInterval(function () {
            location.href = "{{url('receipt/'.$staff_id.'/'.$order_id)}}";
          }, 6000);
</script>
{{-- <script type="text/javascript">
  setInterval(function () {
            location.href = "{{url('App',$staff_id)}}";
          }, 3000);
</script> --}}
<script>
  if( '{{$data}}' == 'en'){
      // alert($data);
    var audio = new Audio("{{url('../storage/staff/Arun/thank_you.ogg')}}" ) ;
    
    audio.oncanplaythrough = function(){
    audio.play();
    }
    
    audio.loop = false;
    setTimeout(function () {
    new Audio("{{url('../storage/staff/Arun/dont_forget.ogg')}}").play();
     }, 3000);
    // audio.onended = function(){
    // // audio.play();
    // }
    }
    else
    {
    var audio = new Audio("{{url('../storage/staff/Arun/grazie_per_lacquisto.ogg')}}" ) ;
    
    audio.oncanplaythrough = function(){
    audio.play();
    }
    
    audio.loop = false;
    setTimeout(function () {
    new Audio("{{url('../storage/staff/Arun/scontrino.ogg')}}").play();
     }, 3000);
    // audio.onended = function(){
    // // audio.play();
    // }
    }
</script>

</body>
</html>