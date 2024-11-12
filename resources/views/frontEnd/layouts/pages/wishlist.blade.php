@extends('frontEnd.layouts.master')
@section('title', 'My Wishlist')
@section('content')
    <section class="customer-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="customer-sidebar">
                        @include('frontEnd.layouts.customer.sidebar')
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="customer-content">
                        <h5 class="account-title">My Wishlist</h5>
                        <div class="vcart-inner">
                            <div class="vcart-content" id="wishlist">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Cart</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $value)
                                                <tr>
                                                    <td><img src="{{ asset($value->options->image) }}" alt=""></td>
                                                    <td><a
                                                            href="{{ route('product', $value->options->slug) }}">{{ $value->name }}</a>
                                                    </td>
                                                    <td>{{ $value->qty }}</td>
                                                    <td>{{ $value->price }} ৳</td>
                                                    <td><button data-id="{{ $value->id }}"
                                                            class="wcart-btn addcartbutton"><i
                                                                data-feather="shopping-cart"></i></button></td>
                                                    <td><button class="remove-cart wishlist_remove"
                                                            data-id="{{ $value->rowId }}"><i
                                                                class="fas fa-times"></i></button></td>
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
        </div>
    </section>
@endsection
