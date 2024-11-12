@extends('backEnd.layouts.master')
@section('title', 'Coupon Code Create')
@section('css')
    <style>
        .increment_btn,
        .remove_btn {
            margin-top: -17px;
            margin-bottom: 10px;
        }
    </style>
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endsection
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('couponcodes.index') }}" class="btn btn-primary rounded-pill">Manage</a>
                    </div>
                    <h4 class="page-title">Coupon Code Create</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('couponcodes.store') }}" method="POST" class="row"
                            data-parsley-validate="" enctype="multipart/form-data">
                            @csrf
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="coupon_code" class="form-label">Coupon Code *</label>
                                    <input type="text" class="form-control @error('coupon_code') is-invalid @enderror"
                                        name="coupon_code" value="{{ old('coupon_code') }}" id="coupon_code" required="">
                                    @error('coupon_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="offer_type" class="form-label">Offer Type *</label>
                                    <select class="form-control select2-multiple @error('offer_type') is-invalid @enderror"
                                        name="offer_type" id="offer_type" value="{{ old('offer_type') }}"
                                        data-toggle="select2" data-placeholder="Choose ..."required>
                                        <option value="">Select..</option>
                                        <option value="1">Percentage</option>
                                        <option value="2">Fixed</option>
                                    </select>
                                    @error('offer_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="expiry_date" class="form-label">Date *</label>
                                    <input type="text"
                                        class="mydate form-control @error('expiry_date') is-invalid @enderror"
                                        name="expiry_date" value="{{ old('expiry_date') }}" id="expiry_date" required="">
                                    @error('expiry_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="amount" class="form-label">Amount </label>
                                    <input type="text" class="form-control @error('amount') is-invalid @enderror"
                                        name="amount" value="{{ old('amount') }}" id="amount">
                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="buy_amount" class="form-label">Minimum Buy Amount</label>
                                    <input type="text" class="form-control @error('buy_amount') is-invalid @enderror"
                                        name="buy_amount" value="{{ old('buy_amount') }}" id="buy_amount">
                                    @error('buy_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image *</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror "
                                        name="image" value="{{ old('image') }}" id="image" required="">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-3 mb-3">
                                <div class="form-group">
                                    <label for="status" class="d-block">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="status" checked>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->

                            <div>
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>

                        </form>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('public/backEnd/') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr(".mydate", {
            dateFormat: "Y-m-d",
        });
    </script>
    <!-- Plugins js -->
    <script src="{{ asset('public/backEnd/') }}/assets/libs//summernote/summernote-lite.min.js"></script>
    <script>
        $(".summernote").summernote({
            placeholder: "Enter Your Text Here",
        });
    </script>


@endsection
