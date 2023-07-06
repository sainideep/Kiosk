@extends('Customer.Layouts.App')
@section('main_css')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="{{url('slick/foundation-float.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('slick/slick-theme.css')}}">
<link href="{{url('slick-new/slick.css')}}" rel="stylesheet" />
<link href="{{url('slick-new/slick-theme.css')}}" rel="stylesheet"/>
<style type="text/css">
  .wrapslider_item-cart {
      margin: 0px;
      padding: 0px 20px 0px 0px;
  }
  .realted_ads .slick-slide img {
    width: 90%;
    height: 170px;
}
.realted_ads .cart_wrap-item{
	width: 90%;
  height: 105px;
}
.foodwraps-etc{
  height: 1130px;
  overflow-y: scroll;
}

body.scrollpad_class .foodwraps-etc{
    padding-bottom: 310px !important;
}

.modal-dialog{
  transform: translate(0%, 100%) !important;
}

.main_wraps{
  overflow-y: hidden;
}
body.scrollpad_class .sidebar_scrill-fix{
  padding-bottom: 310px;
}

.cart_fixed .burgur_wrap-quantity.input-group {
    float: right;
    display: block;
}

section.navigations {
    height: 220px !important;
    position: fixed;
    width: 100%;
}
.white_logo {
    text-align: center;
}

.white_logo img {
    height: 170px;
    width: 170px;
    margin-top: 24px;
}
.cart_fixed{
  bottom: 0px;
}

section#advertisement_Section {
    padding-top: 14em;
}

div#advertise_Section {
    padding-top: 250px;
}

.sidebar_scrill-fix{
    height: 1300px;
}

.main_wraps.scrollpad_withoutad .foodwraps-etc {
    height: 1300px;
}

.main_wraps.scrollpad_withoutad .sidebar_scrill-fix {
    height: 1500px;
}

body.scrollpad_class .main_wraps.scrollpad_withoutad .sidebar_scrill-fix {
    padding-bottom: 300px !important;
}

body.scrollpad_class .main_wraps.scrollpad_withoutad .foodwraps-etc {
    padding-bottom: 280px !important;
}

body{
  background: #F9F9FB !important;
}

.cart_fixed{
  width: 90%;
}

h5.total_price{
  margin-right: 20px !important;
}
.slick-list{
  border-right: 1px solid #EEEEEE !important;
  position: relative !important;
  right: 10px !important;
}
.button-plus.click{
  background: #FB9400;
}

  </style>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
@section('main_section')
<section class="advertise" id="advertisement_Section" >


</section>
<div class="advertisement" id="advertise_Section" >


</div>
<?php 
$segment1 =  Request::segment(2);  
?>
  <div class="wrapper">
    <p class="back_icon" style="padding-top: 20px;">
      <a href="{{url('welcome/'.$segment1.' ')}}"><img src="{{url('images/arrow-back-up.png')}}" class="back_icon" alt="back icon"> <span>{{__('lang.back')}}</span></a>
    </p>
  </div>

  <section class="food_category" style="padding: 0px;">
    <div class="wrapper">
      <div class="col-md-12 col-lg-12 col-sm-12 col-12" style="padding: 0px">
        <div class="row" style="max-width: 80rem;">
          <div class="col-md-4 col-lg-4 col-sm-4  sidebar_scrill-fix" style="padding-left: 0px;">
            <div class="sidebar" style="padding: 5px 10px;border-radius: 10px;height: 100%;overflow-y: scroll;">
              <h3 style="margin-bottom:20px;position: relative;left: 20px;margin-top: 20px;">{{__('lang.cat')}}</h3>
              <div class="menu_sidebar">

                <ul class="nav nav-pills flex-column foods_sidebar" id="myTab" role="tablist">
                  <?php 
                  $segment1 =  Request::segment(3);  
                  ?>
                  @foreach ($categories as $category)
                   @if($segment1 == $category->id)
                    <li class="nav-item " id="profiles">
                      <a class="nav-link data_result active"  data-category_id="{{$category->id}}" onclick="showData({{$category->id}}) " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" style="border-radius: 13px;padding:10px 10px 10px 20px;"><img src="{{$category->image}}" width="60px" height="60px" style="border-radius: 27px;height: 45px;
                        width: 45px;"> <span style="margin: 10px;">{{$category->category_name}}</span>
                      </a>
                    </li>
                    @else
                    <li class="nav-item " >
                      <a class="nav-link data_result"  data-category_id="{{$category->id}}" onclick="showData({{$category->id}}) " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" style="border-radius: 13px;padding:10px 10px 10px 20px;"><img src="{{$category->image}}" width="60px" height="60px" style="border-radius: 27px;height: 45px;
                        width: 45px;"> <span style="margin: 10px;">{{$category->category_name}}</span>
                      </a>
                    </li>
                    @endif
                  @endforeach
          
                </ul>
              </div>
            </div>              
          </div>

          <div class="col-md-8 col-lg-8 col-sm-8" >
            <div class="filters">
              <h3 class="filter_heading">{{__('lang.filter')}}</h3>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h2>Home</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
                  </div>
                  <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <!--****************************** slide start *****************************************************-->
                    <div id="progress" style="position: absolute">
                      <img src="{{url('images/Spin.gif')}}" style="width:100px;height:100px;display: block;margin-left: 350px;margin-top: 160px;" />
                     </div>
                      <div class="column" style="padding: 0px;">
                        <div class="wrap_food_option cSlider cSlider--nav" id="filter_option">
                          
                        </div>
                        <div class="row-border" style="border-top: 1px solid #F1F1F6;margin: 30px;"></div>
                        <div class="cSlider cSlider--single"  id="menudata">
                        </div>                        
                      </div>
                    <!--****************************** slider end *****************************************************-->
                    </div>
                  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                  <h2>Contact</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
                  
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      

     <!--******************************** section cart ***************************************************-->
      <div id="progress_cart" style="position: absolute;display: none">
          <img src="{{url('images/Spin.gif')}}" style="width:100px;height:100px;display: block;margin-left: 350px;margin-top: 152%;" />
      </div>
      <div class="cart_fixed" id="cart_section" style="display: none">
        <div class="cart_wrap">          

          <!--************************** slick slider ***********************************************-->
          <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="row">
              <div class="col-md-9 col-lg-9 col-sm-9">
                <div class="realted_ads">
            
                <div class="heading_cart">
                  <h5>{{__('lang.myorder')}}</h5>
                </div>
                <div class="slick-carousels" id="cart_data_show">
                    <div class="wrapslider_item-cart">
                      <div class="slider_img">
                        <a href="#"><img src="{{url('images/burgurimg.png')}}" alt="Slide 1"></a>
                      </div>
                      <div class="cart_wrap-item">
                        <h6>Ham Burger</h6>
                        <p>$ 25.00</p>
                        <div class="burgur_wrap-quantity input-group">
                          <input type="button" value="-" class="button-minus" data-field="quantity">
                          <input type="number" step="1" max="" min="1" value="1" name="quantity" class="quantity-field">
                          <input type="button" value="+" class="button-plus" data-field="quantity">
                        </div>
                      </div>
                      
                    </div>

                    <div class="wrapslider_item-cart">
                      <div class="slider_img">
                        <a href="#"><img src="{{url('images/burgurimg.png')}}" alt="Slide 1"></a>
                      </div>
                      <div class="cart_wrap-item">
                        <h6>Ham Burger</h6>
                        <p>$ 25.00</p>
                        <div class="burgur_wrap-quantity input-group">
                          <input type="button" value="-" class="button-minus" data-field="quantity">
                          <input type="number" step="1" max="" value="1" name="quantity" class="quantity-field">
                          <input type="button" value="+" class="button-plus" data-field="quantity">
                        </div>
                      </div>
                    </div>
                </div>
            
              </div>
              </div>

              <div class="col-md-3 col-lg-3 col-sm-3 payment_lasts">
                 <div class="payment_wrap">
                   <h5 class="total_price" id="total_price">{{__('lang.total')}}: $25:00</h5>
                   <div class="clear" >
                     <a href="{{url('order-details',$staff_id)}}"><button type="button" class="btn btn-primary payment">{{__('lang.cart')}}<img src="{{url('images/removebg-preview2.png')}}" alt="Slide 1" style="height: 20px;width: 20px;position: relative;left: 5px;"></button></a>
                   </div>
                   <div class="clear" style="padding-bottom: 20px;">
                    <button type="button" class="btn btn-primary payment_cancel" onclick="cart_delete()">{{__('lang.cancel')}}</button>
                   </div>
                 </div>
              </div>
              
            </div>
          </div>
          


          <!--********************** slick slider end ********************************************-->
          
        </div>        
      </div> 

      <!--********************************* section cart end *********************************************-->
    </div>
  </section>
</div>

  <div class="modal" id="myModal" id="model">
  
  </div>
 
</body>


@endsection
@section('main_script')   
  <script src="{{url('slick-new/jquery.min.js')}}"></script>
  <script src="{{url('slick-new/slick.min.js')}}"></script>
  <script>

  
       
    </script>

   <script src="{{url('slick/jquery.min.js')}}"></script>
   <script src="{{url('slick/slick.js')}}"></script>
   <script src="{{url('js/main.js')}}"></script>
   <script type="text/javascript">

    $('.slick-carousels').slick({
          arrows: true,
          centerPadding: "20px",
          dots: false,
          infinite: true,
          slidesToShow: 3,
          cssEase: 'linear',
          loop: true,
          centerMode: false,
          autoplay: true,
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


  $(document).on('click', '.button-plus', function(e) {
    incrementValue(e);
  });

  $(document).on('click', '.button-minus', function(e) {
    decrementValue(e);
  });

  function incrementValue(e) {
        console.log(e);
      e.preventDefault();
      var fieldName = $(e.target).data('field');
      
      var parent = $(e.target).closest('div');
     
      var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
      if (!isNaN(currentVal)) {
        parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
      } else {
        parent.find('input[name=' + fieldName + ']').val(0);
      }
    }

    function decrementValue(e) {
      e.preventDefault();
      var fieldName = $(e.target).data('field');
      var parent = $(e.target).closest('div');
      var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

      if (!isNaN(currentVal) && currentVal > 1) {
        parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
      } else {
        parent.find('input[name=' + fieldName + ']').val(1);
      }
    }

  </script>



<script type="text/javascript">
    function showData(cat_id){
      var cat_id = cat_id; 
      const $rootSingle = $('.cSlider--single');
      const $rootNav = $('.cSlider--nav');
      $rootNav.slick('unslick');
      $rootSingle.slick('unslick');
      options = {
                  slide: '.cSlider__item',
                  slidesToShow: 3,
                  slidesToScroll: 1,
                  dots: false,
                  focusOnSelect: false,
                  infinite: false,
                  responsive: [{
                    breakpoint: 1024,
                    settings: {
                      slidesToShow: 3,
                      slidesToScroll: 1,
                    }
                  }, {
                    breakpoint: 640,
                    settings: {
                      slidesToShow: 2,
                      slidesToScroll: 1,
                    }
                  }, {
                    breakpoint: 420,
                    settings: {
                      slidesToShow: 2,
                      slidesToScroll: 1,
                  }
                  }]
                };

        root_options = {
                        slide: '.cSlider__item',
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        fade: true,
                        lazyLoad: 'ondemand',
                        infinite: false,
                        cssEase: 'linear',
                      };
           
      $.ajax({
         type: 'get',
         url: '{{url('getcategory',$staff_id)}}',
         beforeSend : function(){
            $('#filter_option').html('');
            $('#menudata').html('');          
            $('#progress').show();
          },
         data: {'cat_id' : cat_id}, 
          success: function (data) {
           $('#progress').hide();
           $('#filter_option').html(data.message);
           $('#menudata').html(data.menus);
          
            $rootNav.on('init', function(event, slick) {
                              $(this).find('.slick-slide.slick-current').addClass('is-active');
                            }).slick(options);
            $rootSingle.slick(root_options);

            $rootSingle.on('afterChange', function(event, slick, currentSlide) {
              $rootNav.slick('slickGoTo', currentSlide);
              $rootNav.find('.slick-slide.is-active').removeClass('is-active');
              $rootNav.find('.slick-slide[data-slick-index="' + currentSlide + '"]').addClass('is-active');
            });
            $rootNav.on('click', '.slick-slide', function(event) {
              event.preventDefault();
              var goToSingleSlide = $(this).data('slick-index');
              // console.log(goToSingleSlide);
               $rootSingle.slick('slickGoTo', goToSingleSlide);
            });
                 
          }
      });
    } 
    
   $('#profiles').find('a').trigger('click'); 


  function showAdvertisement(){
  $.ajax({
      type: 'get',
      url: '{{url('getadvertisement',$staff_id)}}',
      data: {'staff_id' : 1},
      success: function (data) {
        if(data.status == 1)
        {
        $('#advertisement_Section').html(data.message);
        $('#advertise_Section').hide();
        $('.main_wraps').removeClass('scrollpad_withoutad');
        }
        else{
          $('#advertisement_Section').hide();
          $('#advertise_Section').show();
          $('.main_wraps').addClass('scrollpad_withoutad');
        }
      
      },
    });
  }

showAdvertisement();
setInterval(function(){ 
  showAdvertisement();
}, 10000);


function show(id=''){
     var menu_id = id;
     $.ajax({
       type: 'get',
       url: '{{url('getmenu',$staff_id)}}',
     
       data: {'menu_id' : menu_id}, 
       success: function (data) {
        $('#myModal').html(data.menu);
         console.log(data);
       
       },
     });
}

function changePrice(price){
  
  $('#Price_change').html('€' + price.toFixed(2));
} 

function show_cart_data(){
  slick_options = 
        {
          arrows: true,
          centerPadding: "20px",
          dots: false,
          infinite: false,
          slidesToShow: 3,
          slidesToScroll: 3,
          cssEase: 'linear',
          loop: true,
          centerMode: false,
          autoplay: true,
          autoplaySpeed: 6000,
          responsive: 
            [
              {
                breakpoint: 768,
                settings: {
                slidesToShow: 1,
                centerMode: false, /* set centerMode to false to show complete slide instead of 3 */
                slidesToScroll: 1
                }
              }
            ]
        };
  $('.slick-carousels').slick('unslick');
  $.ajax({
      type: 'get',
      url: '{{url("show_cart_data",$staff_id)}}',     
      success: function (data) {
        if(data.status == 1){
          $('#cart_section').show();
          $('body').addClass('scrollpad_class');
          $('#cart_data_show').html(data.data);
          $('#total_price').html(data.total_price);
          $('.slick-carousels').slick(slick_options);
        }
        if(data.status == 2){
          $('#cart_section').hide();
          $('body').removeClass('scrollpad_class');
        }     
      },
  });
}
show_cart_data();
$(document).ready(function() {
  $(document).on("submit","#addToCart",function(e) {
      e.preventDefault();
      var formdata = $( this ).serialize(); 
      $.ajax({
        type: 'get',
        url: '{{url('add_to_cart',$staff_id)}}',     
        data: formdata, 
        success: function (data) {            
            show_cart_data();
            if(data.status == 0)
            {
            toastr["error"](data.message, "Error");
            }  
        },
      }).done(function() { //use this
        $('.close').trigger('click');  
      });
  });
}); 

function update_cart(val,cart_item_id,quantity){  
  if(val == 1)
  {
    quantity--;
  }
  else if(val == 2){
    quantity++;
  }
  $.ajax({
    type: 'get',
    url: '{{url('update_to_cart',$staff_id)}}',
    beforeSend : function(){
      $('#cart_section').hide();
      $('#progress_cart').show();
    },     
    data: {'cart_item_id': cart_item_id, 'quantity' : quantity}, 
    success: function (data) {
        $('#progress_cart').hide();
        show_cart_data();

            
    },
  });
} 

function cart_delete()
{
  $.ajax
  ({
    type: 'get',
    url: '{{url('delete_cart',$staff_id)}}',
    beforeSend : function(){
      $('#cart_section').hide();
    },      
    success: function (data) {      
        show_cart_data();            
    },
  });
} 
   

function cartitem_delete($id)
{
  $menu_id = $id;
  $.ajax
  ({
    type: 'get',
    url: '{{url('cartitem_delete',$staff_id)}}', 
    data: {'menu_id' : $menu_id},    
    success: function (data) {      
        console.log(data); 
        window.location.reload();           
    },
  });
}
</script>

@endsection
