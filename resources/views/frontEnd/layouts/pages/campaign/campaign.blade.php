<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $generalsetting->name }}</title>
        <link rel="shortcut icon" href="{{asset($generalsetting->favicon)}}" type="image/x-icon" />
        <!-- fot awesome -->
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/all.css" />
        <!-- core css -->
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/bootstrap.min.css" />
        <link rel="stylesheet" href="{{asset('public/backEnd/')}}/assets/css/toastr.min.css" />
        <!-- owl carousel -->
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/owl.theme.default.css" />
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/owl.carousel.min.css" />
        <!-- owl carousel -->
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/style.css" />
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/responsive.css" />
        @foreach($pixels as $pixel)
        <!-- Facebook Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '{{{$pixel->code}}}');
          fbq('track', 'PageView');
        </script>
        <noscript>
          <img height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id={{{$pixel->code}}}&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
        @endforeach

        <meta name="app-url" content="{{route('campaign',$campaign->slug)}}" />
        <meta name="robots" content="index, follow" />
        <meta name="description" content="{{$campaign->short_description}}" />
        <meta name="keywords" content="{{ $campaign->slug }}" />

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="product" />
        <meta name="twitter:site" content="{{$campaign->name}}" />
        <meta name="twitter:title" content="{{$campaign->name}}" />
        <meta name="twitter:description" content="{{ $campaign->short_description}}" />
        <meta name="twitter:creator" content="" />
        <meta property="og:url" content="{{route('campaign',$campaign->slug)}}" />
        <meta name="twitter:image" content="{{asset($campaign->banner)}}" />

        <!-- Open Graph data -->
        <meta property="og:title" content="{{$campaign->name}}" />
        <meta property="og:type" content="product" />
        <meta property="og:url" content="{{route('campaign',$campaign->slug)}}" />
        <meta property="og:image" content="{{asset($campaign->banner)}}" />
        <meta property="og:description" content="{{ $campaign->short_description}}" />
        <meta property="og:site_name" content="{{$campaign->name}}" />
    </head>

    <body>
         @php
            $subtotal = Cart::instance('shopping')->subtotal();
            $subtotal = str_replace(',', '', $subtotal);
            $subtotal = str_replace('.00', '', $subtotal);
            $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
            $coupon = Session::get('coupon_amount') ? Session::get('coupon_amount') : 0;
            $discount = Session::get('discount') ? Session::get('discount') : 0;
        @endphp

        <section class="banner-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-10">
                        <div class="campaign_banner">
                            <div class="banner_title">
                                <h2>{{$campaign->name}}</h2>
                            </div>
                            <div class="banner-img">
                                <img src="{{asset($campaign->banner)}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- banner section end -->

        <!-- short-desctiption section start -->
        <section class="short-des">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        <div class="short-des-title">
                            {!! $campaign->short_description !!}
                        </div>
                        <div class="ord_btn">
                            <a href="#order_form" class="order_place"> Order Now <i class="fa-solid fa-arrow-down"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
         <!-- short-desctiption section end -->

        <!-- desctiption section start -->
        <section class="description-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="description-inner">
                            <div class="description-title">
                                <h2>{{$campaign->description_title}}</h2>
                            </div>
                            <div class="main-description">
                                {!! $campaign->description !!}
                            </div>
                        </div>
                        <div class="ord_btn mt-5">
                            <a href="#order_form" class="order_place"> Order Now <i class="fa-solid fa-arrow-down"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
         <!-- desctiption section end -->

        <!-- desctiption section start -->
        <section class="whychoose-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="whychoose-inner">
                            <div class="whychoose-title">
                                <h2>আমাদের প্রোডাক্ট কোনো কিনবেন?</h2>
                            </div>
                            <div class="main-whychoose">
                                {!! $campaign->why_chooseus !!}
                            </div>
                        </div>
                        <div class="ord_btn my-5">
                            <a href="#order_form" class="order_place"> Order Now <i class="fa-solid fa-arrow-down"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
         <!-- desctiption section end -->

         <!-- review section start -->
         @if($campaign->images)
         <section class="review-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="rev_inn">
                            <div class="rev_title">
                                <h2>আমাদের কাস্টমারের রিভিউ?</h2>
                            </div>
                            <div class="review_slider owl-carousel">
                            @foreach($campaign->images as $key=>$value)
                            <div class="review_item">
                                <img src="{{asset($value->image)}}" alt="">
                            </div>
                            @endforeach
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
        <!-- review section end -->

        <!-- offer price form end -->
        <section class="price-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="offer_price">
                            <div class="offer_title">
                                <h2>অফারটি সীমিত সময়ের জন্য, তাই অফার শেষ হওয়ার আগেই Order Now</h2>
                            </div>
                            <div class="product-price">
                                <h2>
                                    @if($old_price)
                                    <p class="old_price"> আগের দাম : <del> {{$old_price}}</del> /=</p>
                                    @endif
                                    <p>বর্তমান দাম {{$new_price}}/=</p>
                                </h2>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="form_sec">
        <div class="container">
           <div class="row">
             <div class="col-sm-12">
                <div class="form_inn">
                    <div class="col-sm-12">
                        <div class="row order_by">
                            <div class="col-sm-5">
                                <div class="checkout-shipping" id="order_form">
                                    <form action="{{route('customer.ordersave')}}" method="POST" data-parsley-validate="">
                                    @csrf
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="potro_font">👇 অর্ডারটি কনফার্ম করতে আপনার ইনফরমেশন দিন  </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="name">আপনার নাম লিখুন * </label>
                                                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{old('name')}}" required>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- col-end -->
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="phone">আপনার মোবাইল লিখুন *</label>
                                                        <input type="number" minlength="11" id="number" maxlength="11" pattern="0[0-9]+"  placeholder="Your Phone" title="please enter number only and 0 must first character" title="Please enter an 11-digit number." id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}" required>
                                                        @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- col-end -->
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="address">আপনার ঠিকানা লিখুন*</label>
                                                        <input type="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Your Address" name="address" value="{{old('address')}}"  required>
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="area">আপনার এরিয়া সিলেক্ট করুন  *</label>
                                                        <select type="area" id="area" class="form-control @error('area') is-invalid @enderror" name="area"   required>
                                                            <option value="">Select...</option>
                                                            @foreach($shippingcharge as $key=>$value)
                                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- col-end -->
                                                @if($productcolors->count() > 0)
                                                     <div class="pro-color" style="width: 100%;">
                                                        <div class="color_inner">
                                                            <p>Color -</p>
                                                            <div class="size-container">
                                                                <div class="selector">
                                                                    @foreach ($productcolors as $key=>$procolor)
                                                                    <div class="selector-item color-item" data-id="{{$key}}">
                                                                        <input
                                                                            type="radio"
                                                                            id="fc-option{{ $procolor->color }}"
                                                                            value="{{ $procolor->color}}"
                                                                            name="product_color"
                                                                            class="selector-item_radio emptyalert stock_color stock_check" required data-color="{{ $procolor->color}}"
                                                                        />
                                                                        <label for="fc-option{{ $procolor->color }}" class="selector-item_label">{{ $procolor->color}}
                                                                        </label>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($productsizes->count() > 0)
                                                        <div class="pro-size" style="width: 100%;">
                                                            <div class="size_inner">
                                                                <p>Size - <span class="attibute-name"></span></p>
                                                                <div class="size-container">
                                                                    <div class="selector">
                                                                        @foreach ($productsizes as $prosize)
                                                                            <div class="selector-item">
                                                                                <input type="radio"
                                                                                    id="f-option{{ $prosize->size }}"
                                                                                    value="{{ $prosize->size}}"
                                                                                    name="product_size"
                                                                                    class="selector-item_radio emptyalert stock_size stock_check" data-size="{{ $prosize->size}}"
                                                                                    required />
                                                                                <label
                                                                                    for="f-option{{ $prosize->size }}"
                                                                                    class="selector-item_label">{{ $prosize->size}}</label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <button class="order_place confirm_order" type="submit">অর্ডার কন্ফার্ম করুন </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- card end -->
                                </form>
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-7 cust-order-1">
                                <div class="cart_details">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="potro_font">Product Details </h5>
                                        </div>
                                        <div class="card-body cartlist  table-responsive">
                                            <table class="cart_table table table-bordered table-striped text-center mb-0">
                                                <thead>
                                                   <tr>
                                                      <th style="width: 20%;">Delete</th>
                                                      <th style="width: 40%;">Product</th>
                                                      <th style="width: 20%;">Qty</th>
                                                      <th style="width: 20%;">Price</th>
                                                     </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach(Cart::instance('shopping')->content() as $value)
                                                    <tr>
                                                        <td>
                                                            <a class="cart_remove" data-id="{{$value->rowId}}"><i class="fas fa-trash text-danger"></i></a>
                                                        </td>
                                                        <td class="text-left">
                                                             <a style="font-size: 14px;" href="{{route('product',$value->options->slug)}}"><img src="{{asset($value->options->image)}}" height="30" width="30"> {{Str::limit($value->name,20)}}</a>
                                                        </td>
                                                        <td width="15%" class="cart_qty">
                                                            <div class="qty-cart vcart-qty">
                                                                <div class="quantity">
                                                                    <button class="minus cart_decrement"  data-id="{{$value->rowId}}">-</button>
                                                                    <input type="text" value="{{$value->qty}}" readonly />
                                                                    <button class="plus  cart_increment" data-id="{{$value->rowId}}">+</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>৳ <strong>{{$value->price*$value->qty}}</strong></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                     <tr>
                                                      <th colspan="3" class="text-end px-4">Total</th>
                                                      <td>
                                                       <span id="net_total"><span class="">৳ </span><strong>{{$subtotal}}</strong></span>
                                                      </td>
                                                     </tr>
                                                     <tr>
                                                      <th colspan="3" class="text-end px-4">Delevery Charge</th>
                                                      <td>
                                                       <span id="cart_shipping_cost"><span class="">৳ </span><strong>{{$shipping}}</strong></span>
                                                      </td>
                                                     </tr>
                                                      <tr>
                                                        <th colspan="3" class="text-end px-4">Discount</th>
                                                        <td class="px-4">
                                                            <span id="cart_shipping_cost"><span class="">৳
                                                                </span><strong>{{ $discount + $coupon }}</strong></span>
                                                        </td>
                                                    </tr>
                                                     <tr>
                                                      <th colspan="3" class="text-end px-4">Total</th>
                                                      <td>
                                                       <span id="grand_total"><span class="">৳ </span><strong>{{$subtotal+$shipping}}</strong></span>
                                                      </td>
                                                     </tr>
                                                    </tfoot>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- col end -->
                            </div>
                    </div>
                </div>

             </div>
            </div>
        </div>
    </section>

        <script src="{{ asset('public/frontEnd/campaign/js') }}/jquery-2.1.4.min.js"></script>
        <script src="{{ asset('public/frontEnd/campaign/js') }}/all.js"></script>
        <script src="{{ asset('public/frontEnd/campaign/js') }}/bootstrap.min.js"></script>
        <script src="{{ asset('public/frontEnd/campaign/js') }}/owl.carousel.min.js"></script>
        <script src="{{ asset('public/frontEnd/campaign/js') }}/select2.min.js"></script>
        <script src="{{ asset('public/frontEnd/campaign/js') }}/script.js"></script>
        <script src="{{asset('public/backEnd/')}}/assets/js/toastr.min.js"></script>
        {!! Toastr::message() !!}


        <!-- bootstrap js -->
        <script>
            $(document).ready(function () {
                $(".owl-carousel").owlCarousel({
                    margin: 15,
                    loop: true,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 6000,
                    autoplayHoverPause: true,
                    items: 1,
                    });
                $('.owl-nav').remove();
            });
        </script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
        <script>
             $("#area").on("change", function () {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    data: { id: id },
                    url: "{{route('shipping.charge.campaign')}}",
                    dataType: "html",
                    success: function(response){
                        $('.cartlist').html(response);
                    }
                });
            });
        </script>
           <script>
            $(".cart_remove").on("click", function () {
                var id = $(this).data("id");
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.remove_bn')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                            }
                        },
                    });
                }
            });
            $(".cart_increment").on("click", function () {
                var id = $(this).data("id");
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.increment_bn')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                            }
                        },
                    });
                }
            });

            $(".cart_decrement").on("click", function () {
                var id = $(this).data("id");
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.decrement_bn')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                            }
                        },
                    });
                }
            });

        </script>
        <script>
            $('.review_slider').owlCarousel({
                dots: false,
                arrow: false,
                autoplay: true,
                loop: true,
                margin: 10,
                smartSpeed: 1000,
                mouseDrag: true,
                touchDrag: true,
                items: 6,
                responsiveClass: true,
                responsive: {
                    300: {
                        items: 1,
                    },
                    480: {
                        items: 2,
                    },
                    768: {
                        items: 5,
                    },
                    1170: {
                        items: 5,
                    },
                }
            });
        </script>
        <script>
            $(".stock_check").on("click", function () {
                var color = $(".stock_color:checked").data('color');
                var size = $(".stock_size:checked").data('size');
                var id = {{$campaign->product_id}};
                if(id){
                    $.ajax({
                        type: "GET",
                        data: { id:id,color: color ,size:size},
                        url: "{{route('campaign.stock_check')}}",
                        dataType: "json",
                        success: function(status){
                            if(status == true){
                                $('.confirm_order').prop('disabled', false);
                                return cart_content();
                            }else{
                                $('.confirm_order').prop('disabled', true);
                                toastr.error('Stock Out',"Please select another color or size");
                            }
                            console.log(status);
                            // return cart_content();
                        }
                    });
                }
            });
            function cart_content() {
                $.ajax({
                    type: "GET",
                    url: "{{route('cart.content')}}",
                    success: function (data) {
                        if (data) {
                           $(".cartlist").html(data);
                        } else {
                           $(".cartlist").html(data);
                        }
                    },
                });
            }
        </script>
    </body>
</html>
