@extends('frontEnd.layouts.master') 
@section('title','Hot Deals')
@push('css')
<link rel="stylesheet" href="{{asset('public/frontEnd/css/jquery-ui.css')}}" />
@endpush 
@section('content')
<section class="product-section">
    <div class="container">
        <div class="sorting-section">
            <div class="row">
                <div class="col-sm-6">
                    <div class="category-breadcrumb d-flex align-items-center">
                        <a href="{{ route('home') }}">Home</a>
                        <span>/</span>
                        <strong>Hot Deals</strong>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="showing-data">
                                <span>Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} Results</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mobile-filter-toggle">
                                <i class="fa fa-list-ul"></i><span>filter</span>
                            </div>
                            <div class="page-sort">
                                <form action="" class="sort-form">
                                    <select name="sort" class="form-control form-select sort">
                                        <option value="1" @if(request()->get('sort')==1)selected @endif>Product: Latest</option>
                                        <option value="2" @if(request()->get('sort')==2)selected @endif>Product: Oldest</option>
                                        <option value="3" @if(request()->get('sort')==3)selected @endif>Price: High To Low</option>
                                        <option value="4" @if(request()->get('sort')==4)selected @endif>Price: Low To High</option>
                                        <option value="5" @if(request()->get('sort')==5)selected @endif>Name: A-Z</option>
                                        <option value="6" @if(request()->get('sort')==6)selected @endif>Name: Z-A</option>
                                    </select>
                                    <input type="hidden" name="min_price" value="{{request()->get('min_price')}}" />
                                    <input type="hidden" name="max_price" value="{{request()->get('max_price')}}" />
                                </form>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                 <div class="offer_timer" id="simple_timer"></div>
            </div>
            <div class="col-sm-12">
                <div class="category-product main_product_inner">
                    @foreach($products as $key=>$value)
                    <div class="product_item wist_item">
                            <div class="product_item_inner">
                                 {{-- <div class="wish-compare">
                                    <div class="wish-compare-inner">
                                        <!--<a title="Compare" href="#" data-id="{{ $value->id }}"-->
                                        <!--    class="comparecartbutton"><i class="fa-solid fa-sliders"></i>-->
                                        <!--</a>-->
                                        <button data-id="{{ $value->id }}" class="hover-zoom compare_store"
                                            title="Compare"><i class="fa-solid fa-sliders"></i></button>
                                        <button data-id="{{ $value->id }}" class="hover-zoom wishlist_store"
                                            title="Wishlist"><i class="fa-regular fa-heart"></i></button>
                                    </div>
                                </div>--}}
                                @if ($value->variable_count > 0 && $value->type == 0)
                                    @if ($value->variable->old_price)
                                        <div class="sale-badge">
                                            <div class="sale-badge-inner">
                                                <div class="sale-badge-box">
                                                    <span class="sale-badge-text">
                                                        <p>@php $discount=(((($value->variable->old_price)-($value->variable->new_price))*100) / ($value->variable->old_price)) @endphp {{ number_format($discount, 0) }}%</p>
                                                        Of
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if ($value->old_price)
                                        <div class="sale-badge">
                                            <div class="sale-badge-inner">
                                                <div class="sale-badge-box">
                                                    <span class="sale-badge-text">
                                                        <p>@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp {{ number_format($discount, 0) }}%</p>
                                                        Of
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="pro_img">
                                    <a href="{{ route('product', $value->slug) }}">
                                        <img src="{{ asset($value->image ? $value->image->image : '') }}"
                                            alt="{{ $value->name }}" />
                                    </a>
                                </div>
                                <div class="pro_des">
                                    <div class="pro_name">
                                        <a
                                            href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 80) }}</a>
                                    </div>
                                    <div class="pro_price">
                                        @if ($value->variable_count > 0 && $value->type == 0)
                                            <p>
                                                @if ($value->variable->old_price)
                                                    <del>৳ {{ $value->variable->old_price }}</del>
                                                @endif

                                                ৳ {{ $value->variable->new_price }}

                                            </p>
                                        @else
                                            <p>
                                                @if ($value->old_price)
                                                    <del>৳ {{ $value->old_price }}</del>
                                                @endif

                                                ৳ {{ $value->new_price }}

                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($value->variable_count > 0 && $value->type == 0)
                                <div class="pro_btn">

                                    <div class="cart_btn order_button">
                                        <a href="{{ route('product', $value->slug) }}" class="addcartbutton">Order Now
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="pro_btn">

                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $value->id }}" />
                                        <input type="hidden" name="qty" value="1" />
                                        <button type="submit">Order Now</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="custom_paginate">
                    {{$products->links('pagination::bootstrap-4')}}
                   
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
@push('script')
<script>
    $(".sort").change(function(){
       $('#loading').show();
       $(".sort-form").submit();
    })
</script>
<script>
    $("#simple_timer").syotimer({
        date: new Date(2015, 0, 1),
        layout: "hms",
        doubleNumbers: false,
        effectType: "opacity",

        periodUnit: "d",
        periodic: true,
        periodInterval: 1,
    });
</script>
@endpush