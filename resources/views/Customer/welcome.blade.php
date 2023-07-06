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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
      margin-top: 13px;
    }
    .custom_class_select{
      padding-left: 5px;
    }
    .select2-selection{
      border: 0px !important;
    }
    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable{
      background-color: transparent !important; 
      background: transparent !important;
      color: black;
      margin-top: 7px;
    }
    .slick-next:before {
      color: #FB9400 !important;
      font-weight: bold !important;
      font-size: 50px !important;
    }
    .select2-container--default .select2-results__option--selected{
      background: transparent !important;
      margin-top: 15px;
    }
    .select2-dropdown {
      background-color: transparent !important;
    }
    .select2-container--default .select2-selection--single{
      font-weight: bolder;
    }
    .select2-container--default .select2-results>.select2-results__options{
        margin-left: 3px;
        margin-top: 11px;
      }
      .slick-slide img {
       display: inline !important;
      }
        .wraps-food {
          text-align: center;   
        }
        .wraps-food:hover {
          background: #fff;
          border: 1px solid #FB9400;
        }
        .slick-slide img {
          display: initial;
      }
    
      .wrapslider_item-cart {
            margin: 0px 20px;
        }
        .slick-prev, .slick-next{
          top: 38% !important;
        }
      .slick-next:before{
        color: #FB9400;
        font-weight: bold;
        font-size: 50px;
      }
      .select2-selection__arrow{
        display: none;
      }
      .select2-container--open .select2-dropdown--below{
        border-left: none;
        border-bottom: none;
        border-right: none;
      }
      .slick-prev:before, .slick-next:before{
        font-size: 39px !important;
        color: #FB9400 !important;
        
      }
      .images {
    height : 280px;
    overflow-x: scroll;
    overflow-y: hidden;
    white-space: nowrap;
    background-color : #ffffff;
  
}
.images a{
  padding : 14px 5px 0px 5px;
  margin: 5px 3px 0px 3px;
  vertical-align: middle;
  display: inline-block;
}

images img {
  max-width: 100%; 
  max-height:512px;
}

.other-stuff li
{
  font-weight: normal;
}
.child {
  white-space: nowrap;
  overflow-x: scroll;
}

    </style>
</head>
<body>
<section class="first_banner">
  <div class="auto_grill_wraps">
    <div class="dropdown">
      {{--
    <button type="button"  class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
      Italian <span class="image_flag"><img src="{{url('images/flag.png')}}"></span>
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item" onclick="alert('aa')" href="#">English <span class="image_flag"><img src="{{url('images/english_flag.png')}}" style="width: 70px;"></span>
      </a>
    </div> --}}
    {{-- <select class="form-select" aria-label="Default select example" onchange="setLocale(this)">
      <option value="en">English </option>
      <option value="itl">Italian </option>
    </select> --}}
    <div class="dropdown">
      {{-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
        <a class="dropdown-item" href="#">Italian <span class="image_flag"><img src="{{url('images/flag.png')}}"></span></a>
      </button>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">English <span class="image_flag"><img src="{{url('images/english_flag.png')}}" style="width: 70px;"></span></a>
      </div> --}}
      {{-- <select class="form-select p-3" name="language" style="width: 10%;">
       <option value="en" {{ \Session::get('language') == 'en' ? 'selected' : '' }} style="background-image: {{url('images/flag.png')}}">English</option>
        <option value="it" {{ \Session::get('language') == 'it' ? 'selected' : '' }}>Italian</option>
    </select> --}}
    <select class="js-example-basic-single" name="language" id="select" style="width: 110px;height: 46px;">
      <option value="en" {{ \Session::get('language') == 'en' ? 'selected' : '' }}>English</option>
       
      <option value="it" {{ \Session::get('language') == 'it' ? 'selected' : '' }}>Italian</option>
    </select>
    </div>
  </div>
  </div>
</section>

<section class="wrap_welcome">
  <div class="welcome_wraps">
    @if($logo)
    <img src="{{$logo->logo}}" class="logo" alt="logo" style="height: 220px;object-fit: contain;">
    @else
    <img src="{{url('images/logo1.png')}}" class="logo" alt="logo">
    @endif
    @if($logo)
    <h1 style="font-size: 35px;">{{$logo->status}}</h1>
    @else
    <h1>Welcome to traveler!</h1>
    @endif
    
  </div>
</section>

<section class="brings_you">
  <div class="container">


     <!--************************** slick slider ***********************************************-->
          <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="row">
              <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="realted_ads">
                <link href="{{url('slick-new/slick.css')}}" rel="stylesheet" />
                <link href="{{url('slick-new/slick-theme.css')}}" rel="stylesheet"/>
                <div class="wraps_brings">
                  
                  <h3>{{__('lang.msg')}}</h3>
                </div>
                {{-- <div class="slick-carousels" id="categories" style="display: none"> --}}
                  {{-- <div data-role="page"> --}}
                    <div class="product-all-contents">
                    <div data-role="content">
                  <div class="images" id="content"> 
                
                  
                 @if($categories)
                    @foreach ($categories as $category)                   

                    {{-- <div class="wrapslider_item-cart"> --}}
                      <a href="{{url('category/')}}/{{$category->staff_id}}/{{$category->id}}" >
                        {{-- <div class="tlClogo"> --}}

                        <div class="wraps-food" style="padding: 30px;width: 280px;">
                          
                        <img  src="{{$category->image}}" alt="Refreshment" style="height: 120px;width: 120px;object-fit:cover;">
                        <h5>{{$category->category_name}}</h5>
                      </div>
                    {{-- </div> --}}

                      </a>   
                 
                    {{-- </div> --}}
                    @endforeach
                  @endif 
                 {{-- </div> --}}
                </div>
              
                <button type="button" id="left-button" style="position: relative;right: 68px;bottom: 146px;background-color: Transparent;background-repeat:no-repeat;border: none;cursor:pointer;overflow: hidden;outline:none;"> <img src="{{url('images/left-arrow-new.png')}}" alt="arrow" style="width: 43px;"></button>
                <button type="button" id="right-button" style="position: relative;left: 852px;bottom: 152px;  background-color: Transparent;background-repeat:no-repeat;border: none;cursor:pointer;overflow: hidden;outline:none;"><img src="{{url('images/right-arrow-new.png')}}" alt="arrow" style="width: 43px;"></button>
              </div>
            </div>
           
                {{-- </div> --}}
                  {{-- @if($categories)
                    @foreach ($categories as $category)                   
                 
                    <div class="wrapslider_item-cart">
                      <a href="{{url('category/')}}/{{$category->staff_id}}/{{$category->id}}" >
                        <div class="wraps-food" style="padding: 30px">
                        <img src="{{$category->image}}" alt="Refreshment" style="height: 120px;width: 120px;object-fit:cover;">
                        <h5>{{$category->category_name}}</h5>
                      </div>
                      </a>                    
                    </div>
                    @endforeach
                  @endif --}}
                    {{-- <div class="wrapslider_item-cart">
                      <a href="{{url('category')}}"><div class="wraps-food active">
                        <img src="{{url('images/second.png')}}" alt="Bar">
                        <h5>Bar</h5></div>
                      </a>
                    </div>

                    <div class="wrapslider_item-cart">
                      <a href="{{url('category')}}"><div class="wraps-food">
                        <img src="{{url('images/third.png')}}" alt="Expense">
                        <h5>Expense</h5></div>
                      </a>
                    </div>

                    <div class="wrapslider_item-cart">
                      <a href="{{url('category')}}"><div class="wraps-food">
                        <img src="{{url('images/first.png')}}" alt="Refreshment">
                        <h5>Refreshment</h5></div>
                      </a> 
                    </div> --}}
                </div>
                      
                <script src="{{url('slick-new/jquery.min.js')}}"></script>
                <script src="{{url('slick-new/slick.min.js')}}"></script>
                <script type="text/javascript">
                  $(document).ready(function(){
                  $('.slick-carousels').slick({
                    arrows: true,
                    centerPadding: "20px",
                    dots: false,
                    infinite: true,
                    slidesToShow: 3,
                    // slidesToScroll: 3,
                    cssEase: 'linear',
                    loop: true,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    responsive: [
                {
                  breakpoint: 768,
                  settings: {
                  slidesToShow: 1,
                  centerMode: false, /* set centerMode to false to show complete slide instead of 3 */
                  slidesToScroll: 1
                  }
                }
               ]
                  });
                  $('#categories').show();
                });
               
              function setLocale(val){
                var locale = $(val).val();
                  $.ajax({
                    type: "get",
                    url:"{{url('staffData',$staff_id)}}" +'/'+locale,
                    success: function(data) {              
                        console.log(data);
                    }
                });
              }
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

              $(document).ready(function() {
                // alert('hh');
              let divMain = $('.product-all-contents')[0];
              // alert(divMain);
              let position = $(divMain).children().position().left;
              // alert(position);
              const slideAmount = 150;

              $('#arrow-right').click(function() {
              //  alert('hh');
                $(divMain).animate({
                  scrollLeft: position + slideAmount
                }, 500);
                position += slideAmount;
              })

              $('#arrow-left').click(function() {
                // alert('left');
                $(divMain).animate({
                  scrollLeft: position - slideAmount
                }, 500);
                position -= slideAmount;
              })
            });
        
            
          //  document.addEventListener("contextmenu", function (e){
          //     e.preventDefault();
          // }, false);
        
        
          $('#right-button').click(function() {
                event.preventDefault();
                $('#content').animate({
                  scrollLeft: "+=400px"
                }, "medium");
            });
            
              $('#left-button').click(function() {
                event.preventDefault();
                $('#content').animate({
                  scrollLeft: "-=400px"
                }, "medium");
            });
                </script>
              </div>
              </div>
            </div>
          </div>
          


          <!--********************** slick slider end ********************************************-->
    </div>
  

</section>
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
   '<span class="custom_class_select"> ' + state.text + '<img  src="{{url("images/english.png")}}"  style="height:37px;margin-left:9px;border-radius:50%" /> </span>'
  );
  }
  else{
    var $state = $(
   '<span class="custom_class_select"> ' + state.text + '<img  src="{{url("images/flag.png")}}" style="height:37px;margin-left:16px"" /> </span>'
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
<script>
  //pageinit event of page
$(document).on("pageinit", "[data-role=page]", function() {
  //cache popup for future use
  var $popup = $("#popupInfo");
  //click event for "a" tag inside .images
  $(this).on("click", ".images > a[href=#]", function(e) {
    //prevent default action
    e.preventDefault();
    //clone the image inside "a"
    var $img = $(this).find("img").clone();
    //add the cloned image inside #stuff
    $popup.find("#stuff").html($img);
    //open popup()
    $popup.popup().popup("open");
  });

});
window.setInterval(function() {
  var elem = document.getElementById('content');
  elem.scrollLeft = 0;
}, 60000);
  </script>

  <script>
    if( '{{$data}}' == 'en'){
      // alert($data);
    var audio = new Audio("{{url('../storage/staff/Arun/tap_the_screen.ogg')}}" ) ;
    
    audio.oncanplaythrough = function(){
    audio.play();
    }
    
    audio.loop = false;
   
    }
    else
    {
    var audio = new Audio("{{url('../storage/staff/Arun/tocca_schermo_per_comporre_menu.ogg')}}" ) ;
    
    audio.oncanplaythrough = function(){
    audio.play();
    }
    
    audio.loop = false;
   
 
    }
    </script>
</body>
</html>
