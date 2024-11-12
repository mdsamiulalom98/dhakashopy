@extends('backEnd.layouts.master')
@section('title', 'Expense Edit')
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('expense.index') }}" class="btn btn-primary rounded-pill">Manage</a>
                    </div>
                    <h4 class="page-title">Expense Edit</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('expense.update') }}" method="POST" class="row" data-parsley-validate=""
                            name="editForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $edit_data->id }}" name="id">


                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="expense_cat_id" class="form-label">Category *</label>
                                    <select
                                        class="form-control select2-multiple @error('expense_cat_id') is-invalid @enderror"
                                        id="expense_cat_id" name="expense_cat_id" value="{{ old('expense_cat_id') }}"
                                        data-placeholder="Choose ..."required>
                                        <optgroup>
                                            <option value="">Choose..</option>
                                            @foreach ($categories as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    @if ($value->id == $edit_data->expense_cat_id) selected @endif>{{ $value->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    @error('expense_cat_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name *</label>
                                    <input type="text" id="name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $edit_data->name }}" id="name" required="">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="text" class="form-control @error('amount') is-invalid @enderror"
                                        name="amount" value="{{ $edit_data->amount }}" id="amount">
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
                                    <label for="date" class="form-label">date</label>
                                    <input type="date" class="form-control mydate @error('date') is-invalid @enderror"
                                        name="date" value="{{ $edit_data->date }}" id="date">
                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea class="form-control @error('note')  is-invalid @enderror" name="note" rows="6" id="note">{!! $edit_data->note !!}</textarea>
                                    @error('note')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col mb-3">
                                <div class="form-group">
                                    <label for="status" class="d-block">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="status"
                                            @if ($edit_data->status == 1) checked @endif>
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
    <script src="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs//summernote/summernote-lite.min.js"></script>
    <script>
        $(".summernote").summernote({
            placeholder: "Enter Your Text Here",
        });

        $(".mydate").flatpickr({
            dateFormat: "Y-m-d",
        })
    </script>

    <script type="text/javascript">
        document.forms["editForm"].elements["subcategorytype"].value = "{{ $edit_data->subcategorytype }}";
        document.forms["editForm"].elements["category_id"].value = "{{ $edit_data->category_id }}";
    </script>
    <!-- /.content -->
@endsection
