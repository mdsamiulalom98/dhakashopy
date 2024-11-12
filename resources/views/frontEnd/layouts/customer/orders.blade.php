@extends('frontEnd.layouts.master')
@section('title', 'Customer Account')
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
                        <h5 class="account-title">My Order</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Discount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->created_at->format('d-m-y') }}</td>
                                            <td>৳{{ $value->amount }}</td>
                                            <td>৳{{ $value->discount }}</td>
                                            <td>{{ $value->status ? $value->status->name : '' }}</td>
                                            <td><a href="{{ route('customer.invoice', ['id' => $value->id]) }}"
                                                    class="invoice_btn"><i class="fa-solid fa-eye"></i></a>

                                                @if ($value->admin_note)
                                                    <a href="{{ route('customer.order_note', ['id' => $value->id]) }}"
                                                        class="invoice_btn bg-primary"><i
                                                            class="fa-solid fa-pencil"></i></a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @foreach ($orders as $key => $value)
        <div class="modal fade" id="gift_card{{ $value->id }}" tabindex="-1"
            aria-labelledby="gift_card{{ $value->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Card Information</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body text-center">
                                @if ($value->card)
                                    <h5>Your Card No: {{ chunk_split($value->card->card_number, 4, ' ') }}</h5>
                                    <h5 class="my-2">Card Amount : {{ $value->card->amount }} Tk</h5>
                                    <h5>Card Balance : {{ $value->card->balance }} Tk</h5>
                                @else
                                    <h5>Your card request pending</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
