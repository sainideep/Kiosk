<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AutoGrill</title>
  @include('Customer.Layouts.Style')
<style>
  /* #data{
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.625;
  } */
  .verticalAlign
  {
    /* display: flex;
    justify-content: center;
    align-items: center; */
    /* height: 800px; */
  }

  
  </style>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
  <div class="main_wraps">
  <section class="navigations verticalAlign " style="height: 213px;position: fixed;z-index: 99999;width: 100%">
    <div class="wrapper">
      <div class="col-md-12 col-lg-12 col-sm-12 col-12">
        <div class="row">
          <div class="col-md-3 col-sm-3 col-lg-3">
            <div class="white_logo">
              @if($logo)
              <img src="{{$logo->logo}}" class="verticalAlign" alt="logo white"  style="height: 170px;width: 170px;margin-top: 24px;"> 
              @else
              <img src="{{url('images/logo_white.png')}}" alt="logo white">
              @endif
            </div>
          </div>

          <div class="col-md-9 col-sm-9 col-lg-9" id="data" >
            <div class="feel_good" style="padding-top: 60px;padding-bottom: 60px;">
              @if($logo)
              <h4 style="font-size: 35px;margin-left: 30px;" class="verticalAlign mb-5">{{substr($logo->status,0,50) . '...'}}</h4>
              @else
              <h4>Feeling good on the move</h4>
              @endif
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>
  @yield('main_section')
  @include('Customer.Layouts.Script')
  </html>