<!DOCTYPE html>
<html>
<head>
  @include('Customer.Layouts.Style')  
  <style>
    .select2-container{
      padding: 1px !important;
      text-align: left !important;
      border: 0px !important;
      width:200px !important;
      }
      .select2-results__option{
        padding: 5px !important;
        font-weight: bolder !important;
      }
      .custom_class_select{
        padding-left: 5px;
       
      }
      .select2-selection{
        border: 0px !important;
      }
      .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable{
        background-color: transparent !important; 
       
        color: black;
      }
      .select2-container--default .select2-results__option--selected{
        background: transparent !important;
        /* margin-top: 10px; */
      }
  
      .select2-container--default .select2-selection--single{
        font-weight: bolder;
        background-color: transparent !important;
      }
          
      .select2-selection__arrow{
        display: none;
      }
      .select2-container--open .select2-dropdown--below{
        border-left: none;
        border-bottom: none;
        border-right: none;
      }
      .select2-dropdown{
        background: transparent !important;
      }
      .select2-container--default .select2-results>.select2-results__options{
        margin-left: 3px;
        margin-top: 11px;
      }
    .select_wrap-texts {
    position: absolute;
    top: 53px;
    right: 50px;
}
      </style>
</head>
<body>
  {{-- <embed src="{{url('../storage/staff/Arun/welcome.ogg')}}" loop="true" autostart="true" > --}}
    {{-- <iframe src="{{url('../storage/staff/Arun/welcome.ogg')}}" allow="autoplay" style="display:none" id="iframeAudio">
    </iframe> 
    <audio autoplay loop  id="playAudio">
      <source src="{{url('../storage/staff/Arun/welcome.ogg')}}">
  </audio> --}}
  <div class="bannrwrap-image">
    @if($banner)
    @if($banner->type == 1)
      <img src="{{$banner->banner_img}}" style='height: 1550px;width: 100%;'>    
    @else
      <video autoplay muted loop style='width: 100%;height: 1550px; object-fit: cover;z-index: -100;'> <source src='{{$banner->banner_img}}' type='video/mp4' ></video>      
    @endif
  @else
  <img src="{{url('images/main.png')}}" style='height: 1550px;width: 100%;'> 
  @endif
    <div class="select_wrap-texts">
      <select class="js-example-basic-single" name="language" id="select" style="width: 110px;height: 46px;">
        <option value="en" {{ \Session::get('language') == 'en' ? 'selected' : '' }}>English</option>
         
        <option value="it" {{ \Session::get('language') == 'it' ? 'selected' : '' }}>Italian</option>
      </select>
    </div>
  </div>

  
<section class="welcome">
  <div class="welcome_wrap">
    <h1 style="padding: 15px 0px 10px 0px;">{{__('lang.welcome')}}</h1>
    @if($logo)
      <a  href="{{url('welcome',$id)}}">
        <img src="{{$logo->logo}}" class="logo" alt="logo" style="height: 200px; object-fit: contain;">
      </a>
    @else
    <a href="{{url('welcome',$id)}}">
      <img src="{{url('images/logo1.png')}}" class="logo" alt="logo">
    </a>
    @endif
  </div>
</section>

{{--<!-- <script type="text/javascript">
   window.setTimeout(function(){
        window.location.href = "{{url('welcome',$id)}}";

    }, 4000);
</script> -->--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$('#select').select2({
  templateResult: formatState,
  templateSelection: formatState,
  minimumResultsForSearch: -1 
 
});
// $('#select').val(null).trigger('change');
function formatState (state) { 
  if (!state.id) { return state.text; }
  if(state.text == 'English'){
  var $state = $(
   '<span class="custom_class_select"> ' + state.text + '<img  src="{{url("images/english.png")}}"  style="height:37px;margin-left:9px; border-radius: 50%;" /> </span>'
  );
  }
  else{
    var $state = $(
   '<span class="custom_class_select"> ' + state.text + '<img  src="{{url("images/flag.png")}}" style="height:37px;margin-left:16px;margin-top: 1px;"" /> </span>'
  );
  }
  
  return $state;
 }
//  function formState(state){
//   console.log(state.text);
//   if (!state.id) { return state.text; }
//   if(state.text == 'English'){
//   var $state = $(
//    '<span class="custom_class_select"> ' + state.text + '<img  src="{{url("images/english_flag.png")}}"  style="height:15px;margin-left:9px" /> </span>'
//   );
//   }
//   else{
//     var $state = $(
//    '<span class="custom_class_select"> ' + state.text + '<img  src="{{url("images/flag.png")}}" style="height:23px;margin-left:20px"" /> </span>'
//   );
//   }
  
//   return $state;
//  }


</script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
<script>
$(document).ready(function() {
  // $("#audio").get(0).play();
$('select[name=language]').change(function() {                  
  var lang = $(this).val();                    
  $.ajax({
    type: "get",
    data: {'lang':lang},
    url:"{{url('language_change/locale')}}",
    success: function(data) {  
      window.location.reload();            
        console.log(data);
    }
  });
});
});
  </script>
  <script>
   
   if( '{{$data}}' == 'en'){
      // alert($data);
    var audio = new Audio("{{url('../storage/staff/Arun/welcome.ogg')}}" ) ;
    
    audio.oncanplaythrough = function(){
    audio.play();
    }
    
    audio.loop = false;
    setTimeout(function () {
    new Audio("{{url('../storage/staff/Arun/select_language.ogg')}}").play();
     }, 3000);
    // audio.onended = function(){
    // // audio.play();
    // }
    }
    else
    {
    var audio = new Audio("{{url('../storage/staff/Arun/benvenuto.ogg')}}" ) ;
    
    audio.oncanplaythrough = function(){
    audio.play();
    }
    
    audio.loop = false;
    setTimeout(function () {
    new Audio("{{url('../storage/staff/Arun/seleziona_lingua.ogg')}}").play();
     }, 3000);
    // audio.onended = function(){
    // // audio.play();
    // }
    }
  
    
//     function createTimedLink(element, callback, timeout){
//   setTimeout( function(){callback(element);}, timeout);
//   return false;
// }

function myFunction(element) { 
/* Block of code, with no 'return false'. */
  window.location = element.href;
 }
    </script>
    <script>
    navigator.mediaDevices.getUserMedia({ audio: true })
      .then(function(stream) {
        console.log('You let me use your mic!')
      })
      .catch(function(err) {
        console.log('No mic for you!')
      });
      </script>
      <script>
           $(document).ready(function() {
                $('select[name=language]').change(function() {                  
                  var lang = $(this).val();                    
                  $.ajax({
                    type: "get",
                    data: {'lang':lang},
                    url:"{{url('language_change/locale')}}",
                    success: function(data) {  
                      window.location.reload();            
                        console.log(data);
                    }
                  });
                });
              });
        </script>
</body>
</html>