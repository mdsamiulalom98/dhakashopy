@extends('backEnd.layouts.master')
@section('title','Loss Profit Report')
@section('content')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd/')}}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
<style>
    .info-box {
        padding: 25px;
        color: #fff;
        border-radius: 5px;
    }
    span.info-box-text {
        font-size: 16px;
    }
    .progress-description {
        font-size: 16px;
    }
    .info-box .progress {
        height: 3px;
        margin: 6px 0;
    }
    span.info-box-icon {
        font-size: 22px;
    }
    .info-box-content span {
        font-size: 16px;
        font-weight: 600;
    }
    p{
        margin:0;
    }
   @page { 
        margin: 50px 0px 0px 0px;
    }
   @media print {
    td{
        font-size: 18px;
    }
    p{
        margin:0;
    }
    title {
        font-size: 25px;
    }
    header,footer,.no-print,.left-side-menu,.navbar-custom {
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
                <h4 class="page-title">Loss Profit Report</h4>
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
                               <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" value="{{request()->get('start_date')}}"  class="form-control flatdate" name="start_date">
                            </div>
                        </div>
                        <!--col-sm-3--> 
                        <div class="col-sm-3">
                            <div class="form-group">
                               <label for="end_date" class="form-label">End Date</label>
                                <input type="date" value="{{request()->get('end_date')}}" class="form-control flatdate" name="end_date">
                            </div>
                        </div>
                        <!--col-sm-3-->
                        <div class="col-sm-3">
                            <label class="form-label" style="opacity:0">Submit</label>
                            <div class="form-group mb-3">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- col end -->
                    </div>  
                </form>
                <div class="row mb-3">
                    <div class="col-sm-6 no-print">
                        
                    </div>
                    <div class="col-sm-6">
                        <div class="export-print text-end">
                            <button onclick="printFunction()"class="no-print btn btn-success"><i class="fa fa-print"></i> Print</button>
                            <button id="export-excel-button" class="no-print btn btn-info"><i class="fas fa-file-export"></i> Export</button>
                        </div>
                    </div>
                </div>
                <div id="content-to-export" class="table-responsive">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="info-box bg-blue">
                          <span class="info-box-icon"><i class="fe-shopping-cart"></i></span>
            
                          <div class="info-box-content">
                            <span class="info-box-text">Total Sales</span>
                            <span class="info-box-number">{{$total_sales}} Tk</span>
                            <div class="progress">
                              <div class="progress-bar" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">
                              Total sales summary
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                      </div>
                      <!-- col end -->
                      <div class="col-sm-4">
                        <div class="info-box bg-danger">
                          <span class="info-box-icon"><i class="fe-airplay"></i></span>
            
                          <div class="info-box-content">
                            <span class="info-box-text">Total Purchase</span>
                            <span class="info-box-number">{{$total_purchase}} Tk</span>
            
                            <div class="progress">
                              <div class="progress-bar" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">
                              Total purchase summary
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                      </div>
                      <!-- col end -->
                      <div class="col-sm-4">
                        <div class="info-box bg-success">
                          <span class="info-box-icon"><i class="fe-bar-chart-line"></i></span>
            
                          <div class="info-box-content">
                            <span class="info-box-text">Total Profit</span>
                            <span class="info-box-number">{{$total_sales-$total_purchase}} Tk</span>
            
                            <div class="progress">
                              <div class="progress-bar" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">
                              Total profit summary
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                      </div>
                      <!-- col end -->
                    </div>
                    <div class="row justify-content-center mt-3">
                      <div class="col-sm-6">
                        <div class="info-box bg-warning">
                          <span class="info-box-icon"><i class="fe-gitlab"></i></span>
            
                          <div class="info-box-content">
                            <span class="info-box-text">Total Expense</span>
                            <span class="info-box-number">{{$total_expense}} Tk</span>
            
                            <div class="progress">
                              <div class="progress-bar" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">
                              Total expense summary
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                      </div>
                      <!-- col end -->
                      <div class="col-sm-6">
                        <div class="info-box bg-info">
                          <span class="info-box-icon"><i class="fe-dollar-sign"></i></span>
            
                          <div class="info-box-content">
                            <span class="info-box-text">Net Profit</span>
                            <span class="info-box-number">{{$total_sales - ($total_purchase+$total_expense)}} Tk</span>
            
                            <div class="progress">
                              <div class="progress-bar" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">
                              Total net profit
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                      </div>
                      <!-- col end -->
                    </div>
                  </div>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>
@endsection
@section('script')
<script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
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
