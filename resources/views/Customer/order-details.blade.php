@extends('Customer.Layouts.App')
@section('main_section')
    <section class="order-details" style="height: 90%;overflow-y: scroll;padding-top: 200px;">
      <div class="wrapper">
        <p class="back_icon">
          <a href="{{ url()->previous() }}"><img src="{{url('images/arrow-back-up.png')}}" class="back_icon" alt="back icon"> <span>{{__('lang.back')}}</span></a>
        </p>

        <div class="wrap_order-details">
          <h4 class="header_order_details">{{__('lang.order')}}</h4>

          <div class="order_items-wrap">
            <div class="faq">
            <div class="accordion" id="faqExample">
            @php 
                $x = 1;
            @endphp
              @foreach($menuArray as $menu)
                <div class="card">
                    <div class="card-header p-2" id="headingOne{{$x}}">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne{{$x}}" aria-expanded="false" aria-controls="collapseOne{{$x}}">
                              <img src="{{$menu['category_detail']->image}}" alt="item image" class="order_item-image-wrap" style="height: 60px;width: 60px;margin-right: 10px;"> <span>{{$menu['category_detail']->category_name}}</span> <span class="cart_item-price">€  {{number_format($menu['price'],2)}}</span>
                            </button>
                          </h5>
                    </div>

                    <div id="collapseOne{{$x}}" class="collapse" aria-labelledby="headingOne{{$x}}" data-parent="#faqExample">
                       
                        <div class="card-body">
                            @foreach($menu['items'] as $item)
                            {{-- dd($menu['items']) --}}
                            <div class="item_wrap-description">
                                <img src="{{$item['menus_detail']['item_image']}}" alt="cart item" style="width: 60px;height: 60px" class="cart_img"> <span class="text_item"><strong>{{$item['menus_detail']['item_name']}} x {{$item['quantity']}}</strong><br/>{{--Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed.--}}</span> <span class="price_items">€   {{number_format($item['total_price'],2)}}</span>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
                @php  
                    $x++;
                @endphp
                @endforeach              
            </div>

        </div>
          </div>


          <div class="total_bill">
            <p class="total_payable bill">{{__('lang.bill')}}: <strong>€   {{number_format($cart->total_price,2)}}</strong> <a href="#"><button type="button" class="btn btn-primary checkout_wrap" onclick="checkout({{$cart->total_price}})">{{__('lang.checkout')}}</button></a></p>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>
@endsection
<script>
  function checkout(price){
    var total_price = price;
    $.ajax({
    type: 'get',
    url: "{{url('orders',$cart->staff_id)}}", 
    data: {'total_price': total_price}, 
    success: function (data) {
      if(data.status == 1){
        location.href = "{{url('checkout',$staff_id)}}" + '/' + data.order_id;
      }      
      if(data.status == 0){
          toastr["error"](data.message, "Error");
          setInterval(function () {
            location.href = "{{url('welcome',$staff_id)}}";
          }, 2000);          
      }
      if(data.status == 2){
          toastr["error"](data.message, "Error");
      }
            
    },
  });
  
  }
</script>
<script>
  if( '{{$data}}' == 'en'){
    // alert($data);
  var audio = new Audio("{{url('../storage/staff/Arun/procede_witn_payment.ogg')}}" ) ;
  
  audio.oncanplaythrough = function(){
  audio.play();
  }
  
  audio.loop = false;
 
  }
  else
  {
  var audio = new Audio("{{url('../storage/staff/Arun/pagamento.ogg')}}" ) ;
  
  audio.oncanplaythrough = function(){
  audio.play();
  }
  
  audio.loop = false;
 

  }
  </script>