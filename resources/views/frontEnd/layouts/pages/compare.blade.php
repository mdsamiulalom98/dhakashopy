@extends('frontEnd.layouts.master')
@section('title','Compare Products')
@section('content')
<section class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="custom-breadcrumb">
                    <ul>
                        <li><a href="{{route('home')}}">Home </a></li>
                        <li><a ><i class="fa-solid fa-angles-right"></i> </a></li>
                        <li><a href="">Compare Products</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end -->

<section class="vcart-section">
    @php
        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal=str_replace(',','',$subtotal);
        $subtotal=str_replace('.00', '',$subtotal);
        view()->share('subtotal',$subtotal);
        $shipping = Session::get('shipping')?Session::get('shipping'):0;
        $discount = Session::get('discount')?Session::get('discount'):0;
    @endphp
    <div class="container">
        <div class="row" id="cartlist">
            <div class="col-sm-12">
                <div class="vcart-inner">
                    <div class="cart-title">
                        <h4>Compare Products</h4>
                    </div>
                    <div class="vcart-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Remove</th>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($compareproduct as $value)
                                    <tr>
                                    	<td>
                                    		<form action="{{url('/compare-remove-cart')}}" method="POST">
                                    			@csrf
                                           		<input type="hidden" name="rowId" value="{{$value->rowId}}">
                                          		<button type="submit" class="btn btn-danger cart-remove"><i class="fa fa-trash"></i><i data-feather="x"></i></button>
                                        	</form>
                                    	</td>
                                        <td><img style="height: 50px; width: 50px" src="{{asset($value->options->image)}}" alt=""></td>
                                        <td class="cart_name"><a href="{{ route('product', $value->id) }}" target="_blank">{{$value->name}}</a></td>
                                        <td>{{$value->price}} ৳</td>
                                        
                                        <td>{!! $value->options->description !!}</td>
                                        <td><a href="{{url('compare-product-add/'.$value->id.'/'.$value->rowId)}}" class="btn btn-success"><i data-feather="shopping-cart"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</section>

@endsection