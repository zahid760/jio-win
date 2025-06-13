@extends('admin.main')
@section('title', 'Aam Play')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Aam Play</a>
                        </li><!--end nav-item-->
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>                            
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div><!--end row-->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Revenue</p>
                                    <h4 class="mt-1 mb-0 fw-medium">$8365.00</h4>
                                </div>
                                <!--end col-->
                                <div class="col-3 align-self-center">
                                    <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-primary rounded mx-auto">
                                        <i class="iconoir-dollar-circle fs-22 align-self-center mb-0 text-primary"></i>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-md-6 col-lg-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">New Order</p>
                                    <h4 class="mt-1 mb-0 fw-medium">722</h4>
                                </div>
                                <!--end col-->
                                <div class="col-3 align-self-center">
                                    <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-info rounded mx-auto">
                                        <i class="iconoir-cart fs-22 align-self-center mb-0 text-info"></i>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-md-6 col-lg-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Sessions</p>
                                    <h4 class="mt-1 mb-0 fw-medium">181</h4>
                                </div>
                                <!--end col-->
                                <div class="col-3 align-self-center">
                                    <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-warning rounded mx-auto">
                                        <i class="iconoir-percentage-circle fs-22 align-self-center mb-0 text-warning"></i>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->

                <div class="col-md-6 col-lg-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Avg. Order value</p>
                                    <h4 class="mt-1 mb-0 fw-medium">$1025.50</h4>
                                </div>
                                <!--end col-->
                                <div class="col-3 align-self-center">
                                    <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-danger rounded mx-auto">
                                        <i class="iconoir-hexagon-dice fs-22 align-self-center mb-0 text-danger"></i>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div><!--end col-->        
            </div>
            <!--end row-->
        </div><!--end col-->
        
    </div><!--end row-->
</div>
@endsection

@section('pagescript')
    <script src="{{ secure_asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- <script src="../../../apexcharts.com/samples/assets/stock-prices.js"></script> -->
    <script src="{{ secure_asset('assets/js/pages/index.init.js') }}"></script>
    <script src="{{ secure_asset('assets/js/DynamicSelect.js') }}"></script>
@endsection