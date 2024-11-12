@extends('backEnd.layouts.master')
@section('title', 'Stock Report')
@section('content')
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <style>
        p {
            margin: 0;
        }

        @page {
            margin: 50px 0px 0px 0px;
        }

        @media print {
            td {
                font-size: 18px;
            }

            p {
                margin: 0;
            }

            title {
                font-size: 25px;
            }

            header,
            footer,
            .no-print,
            .left-side-menu,
            .navbar-custom {
                display: none !important;
            }
        }
    </style>
@endsection
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Stock Report</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="no-print">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="keyword" class="form-label">Keyword</label>
                                    <input type="text" value="{{ request()->get('keyword') }}" class="form-control"
                                        name="keyword">
                                </div>
                            </div>
                            <!--col-sm-3-->
                            <div class="col-sm-3">
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">Categories </label>
                                    <select class="form-control select2 @error('category_id') is-invalid @enderror"
                                        name="category_id" value="{{ old('category_id') }}">
                                        <option value="">Select..</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if (request()->get('category_id') == $category->id) selected @endif>{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" value="{{ request()->get('start_date') }}"
                                        class="form-control flatdate" name="start_date">
                                </div>
                            </div>
                            <!--col-sm-3-->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" value="{{ request()->get('end_date') }}"
                                        class="form-control flatdate" name="end_date">
                                </div>
                            </div>
                            <!--col-sm-3-->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                            <!-- col end -->
                        </div>
                    </form>
                    <div class="row mb-3">
                        <div class="col-sm-6 no-print">
                            {{ $products->links('pagination::bootstrap-4') }}
                        </div>
                        <div class="col-sm-6">
                            <div class="export-print text-end">
                                <button onclick="printFunction()"class="no-print btn btn-success"><i
                                        class="fa fa-print"></i> Print</button>
                                <button id="export-excel-button" class="no-print btn btn-info"><i
                                        class="fas fa-file-export"></i> Export</button>
                            </div>
                        </div>
                    </div>
                    <div id="content-to-export" class="table-responsive">
                        <table class="table nowrap w-100">
                            <thead>
                                <tr>
                                    <th style="width:5%">SL</th>
                                    <th style="width:30%">Product Name</th>
                                    <th style="width:10%">Price</th>
                                    <th style="width:10%">Stock</th>
                                    <th style="width:10%">Purchase</th>
                                    <th style="width:10%">Total</th>
                                    <th style="width:10%">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $stock = 0;
                                    $total = 0;
                                    $purchase = 0;
                                @endphp
                                @foreach ($products as $key => $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->variable ? $value->variable->new_price : $value->new_price }}
                                        </td>
                                        <td>{{ $value->variables->count() > 0 ? $value->variables->sum('stock') : $value->stock }}
                                        </td>

                                        <td>{{ $value->variable ? $value->variable->purchase_price : $value->purchase_price }}
                                        </td>


                                        @if ($value->type == 1)
                                            <td>{{ $value->stock * $value->new_price }}</td>
                                        @else
                                            <td>{{ $value->variables ? $value->variables->sum('stock') : '0' * $value->new_price }}
                                            </td>
                                        @endif

                                        <td><button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal"
                                                data-bs-target="#stockModal{{ $value->id }}">
                                                <i class="fe-eye"></i></button>
                                        </td>
                                    </tr>
                                    @php
                                        if ($value->type == 0) {
                                            $stock += $value->quantity;
                                            $total += $value->stock * $value->new_price;
                                            $purchase += $value->stock * $value->purchase_price;
                                        } else {
                                            $stock += $value->variables ? $value->variables->sum('stock') : '0';
                                            $total += $value->variables
                                                ? $value->variables->sum('stock')
                                                : '0' * $value->new_price;

                                            $purchase += $value->variables
                                                ? $value->variables->sum('stock')
                                                : '0' * $value->purchase_price;
                                        }

                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td><strong>{{ $stock }} Pcs</strong></td>
                                    <td><strong>{{ $purchase }} Tk</strong></td>
                                    <td><strong>{{ $total }} Tk</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h5><strong>Total Purchase = {{ $total_purchase }}</strong></h5>
                                        <h5><strong>Total Stock = {{ $total_stock }} Pcs</strong></h5>
                                        <h5><strong>Total Price = {{ $total_price }} Tk</strong></h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="custom-paginate">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@foreach ($products as $key => $value)
    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="stockModal{{ $value->id }}" tabindex="-1"
        aria-labelledby="stockModal{{ $value->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="stockModal{{ $value->id }}">{{ $value->name }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($value->type == 1)
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>Product</td>
                                    <td>Stock</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->stock }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>Product</td>
                                    <td>Size</td>
                                    <td>Color</td>
                                    <td>Stock</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($value->variables as $variable)
                                    <tr>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $variable->size }}</td>
                                        <td>{{ $variable->color }}</td>
                                        <td>{{ $variable->stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
@section('script')
<script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
<script src="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
        flatpickr(".flatdate", {});
    });
</script>
<script>
    function printFunction() {
        window.print();
    }
</script>
<script>
    $(document).ready(function() {
        $('#export-excel-button').on('click', function() {
            var contentToExport = $('#content-to-export').html();
            var tempElement = $('<div>');
            tempElement.html(contentToExport);
            tempElement.find('.table').table2excel({
                exclude: ".no-export",
                name: "Order Report"
            });
        });
    });
</script>
@endsection
