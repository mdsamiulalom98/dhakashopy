@extends('backEnd.layouts.master')
@section('title', 'Dashboard')
@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet"
        type="text/css" />

@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="widget-rounded-circle card">
                    <div class="card-body bg-dark">
                        <div class="row">

                            <div class="col-12">
                                <div class="text-start">
                                    <p class="text-white mb-1 text-truncate">Total Sales</p>
                                    <h3 class="text-white mt-1 taka-sign"><span
                                            data-plugin="counterup">{{ $total_sale}}</span></h3>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="widget-rounded-circle card">
                    <div class="card-body bg-dark">
                        <div class="row">

                            <div class="col-12">
                                <div class="text-start">
                                    <p class="text-white mb-1 text-truncate">This Month Sales</p>
                                    <h3 class="text-white mt-1 taka-sign"><span
                                            data-plugin="counterup">{{ $current_month_sale}}</span></h3>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="widget-rounded-circle card">
                    <div class="card-body bg-dark">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-start">
                                    <p class="text-white mb-1 text-truncate">Today Sales </p>
                                    <h3 class="text-white mt-1 taka-sign"><span
                                            data-plugin="counterup">{{ $today_sales}}</span></h3>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-4">
                <div class="widget-rounded-circle card">
                    <div class="card-body bg-dark">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-start">
                                    <p class="text-white mb-1 text-truncate">Total Order</p>
                                    <h3 class="text-white mt-1"><span data-plugin="counterup">{{ $total_order }}</span></h3>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-4">
                <div class="widget-rounded-circle card">
                    <div class="card-body bg-dark">
                        <div class="row">

                            <div class="col-12">
                                <div class="text-start">
                                    <p class="text-white mb-1 text-truncate">This Month Orders</p>
                                    <h3 class="text-white mt-1"><span
                                            data-plugin="counterup">{{ $current_month_order }}</span></h3>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-4">
                <div class="widget-rounded-circle card">
                    <div class="card-body bg-dark">
                        <div class="row">

                            <div class="col-12">
                                <div class="text-start">
                                    <p class="text-white mb-1 text-truncate">Customer</p>
                                    <h3 class="text-white mt-1"><span data-plugin="counterup">{{ $total_customer }}</span>
                                    </h3>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            @foreach ($order_statuses as $key => $status)
                <div class="col-md-6 col-xl-2">
                    <div class="widget-rounded-circle card">
                        <div class="card-body bg-dark">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-start">
                                        <h3 class="text-white mt-1"><span
                                                data-plugin="counterup">{{ $status->orders_count }}</span></h3>
                                        <p class="text-white mb-1 text-truncate">{{ $status->name }}</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->
            @endforeach

        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                        <h4 class="header-title mb-3">Latest 5 Orders</h4>

                        <div class="table-responsive">
                            <table class="table table-borderless table-hover table-nowrap table-centered m-0">

                                <thead class="table-light">
                                    <tr>
                                        <th colspan="2">Id</th>
                                        <th>Invoice</th>
                                        <th>Amount</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latest_order as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td style="width: 36px;">
                                                @if($order->product)
                                                <img src="{{ asset($order->product->image ? $order->product->image->image : '') }}"
                                                    alt="contact-img" title="contact-img"
                                                    class="rounded-circle avatar-sm" />
                                                @endif
                                            </td>

                                            <td>
                                                {{ $order->invoice_id }}
                                            </td>

                                            <td>
                                                {{ $order->amount }}
                                            </td>

                                            <td>
                                                {{ $order->customer ? $order->customer->name : '' }}
                                            </td>
                                            <td>
                                                {{ $order->status?$order->status->name : '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                        <h4 class="header-title mb-3">Latest Customers</h4>

                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                <thead class="table-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latest_customer as $customer)
                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">{{ $loop->iteration }}</h5>
                                            </td>

                                            <td>
                                                {{ $customer->name }}
                                            </td>

                                            <td>
                                                {{ $customer->phone }}
                                            </td>

                                            <td>
                                                {{ $customer->created_at->format('d-m-Y') }}
                                            </td>

                                            <td>
                                                {{ $customer->status }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end .table-responsive-->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection
@section('script')
    <!-- Plugins js-->
    <script src="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
@endsection
