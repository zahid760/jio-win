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
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Users</p>
                                    <h4 class="mt-1 mb-0 fw-medium">{{ $totalUserCount }}</h4>
                                </div>
                                <!--end col-->
                                <div class="col-3 align-self-center">
                                    <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-primary rounded mx-auto">
                                        <i class="fas fa-users fs-22 align-self-center mb-0 text-primary"></i>
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
                @role('ADMIN')
                    <div class="col-md-6 col-lg-3">
                        <div class="card bg-corner-img">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-9">
                                        <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Partner</p>
                                        <h4 class="mt-1 mb-0 fw-medium">{{ $totalPartnerCount }}</h4>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-info rounded mx-auto">
                                            <i class="fas fa-users fs-22 align-self-center mb-0 text-info"></i>
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
                @endrole
                <!--end col-->
                <div class="col-md-6 col-lg-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <!--end col-->
                                <div class="col-3 align-self-center">
                                    <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-success rounded mx-auto">
                                        <i class="fas fa-rupee-sign fs-22 align-self-center mb-0 text-success"></i>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total deposits</p>
                                    <h4 class="mt-1 mb-0 fw-medium"> {{ round($totalPaymentAmount) }}</h4>
                                </div>
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
                                <!--end col-->
                                <div class="col-3 align-self-center">
                                    <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-danger rounded mx-auto">
                                        <i class="fas fa-rupee-sign fs-22 align-self-center mb-0 text-danger"></i>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total withdrawal</p>
                                    <h4 class="mt-1 mb-0 fw-medium"> {{ $totalWithdrawAmount }}</h4>
                                </div>
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                
                <!--end col-->

                @role('PARTNER')
                    <div class="col-md-6 col-lg-3"></div>
                @endrole
                <!--end col-->

                <div class="col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body p-1">
                            <h5 class="fw-bold m-2">Share your referral link and earn rewards!</h5>
                            <div class="input-group mb-1">
                                <input type="text" class="form-control" id="shareId" value="{{ route('register') }}?ref={{ $referCode }}" aria-label="shareId" aria-describedby="shareId" readonly>
                                <button class="btn btn-secondary " type="button" id="shareId" data-clipboard-action="copy" data-clipboard-target="#shareId"><i class="far fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="{{ secure_asset('assets/libs/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/pages/clipboard.init.js') }}"></script>
@endsection
