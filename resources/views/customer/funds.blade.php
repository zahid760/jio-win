@section('title', 'Funds')
@include('customer.includes.header')
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('home') }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-white text-uppercase">
                    Funds
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <a href="{{ route('add.fund') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="fas fa-indian-rupee-sign fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Add Fund</h6>
                                <p class="text-muted mb-0 fs-11">You can add fund to your wallet</p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-light thumb-md rounded-circle ms-auto">
                                    <i class="iconoir-nav-arrow-right fs-26"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{ route('withdraw.fund') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-transition-down fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Withdraw Fund</h6>
                                <p class="text-muted mb-0 fs-11">You can add withdraw winnings</p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-light thumb-md rounded-circle ms-auto">
                                    <i class="iconoir-nav-arrow-right fs-26"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{ route('bank.detail') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-bank fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Bank Detail</h6>
                                <p class="text-muted mb-0 fs-11">Add your bank detail for withdrawals</p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-light thumb-md rounded-circle ms-auto">
                                    <i class="iconoir-nav-arrow-right fs-26"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{ route('fund.history') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-clock fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Add Fund History</h6>
                                <p class="text-muted mb-0 fs-11">You can check your add point history</p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-light thumb-md rounded-circle ms-auto">
                                    <i class="iconoir-nav-arrow-right fs-26"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{ route('withdraw.fund.history') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-clock-rotate-right fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Withdraw Fund History</h6>
                                <p class="text-muted mb-0 fs-11">You can check your withdraw point history</p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-light thumb-md rounded-circle ms-auto">
                                    <i class="iconoir-nav-arrow-right fs-26"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>
@include('customer.includes.footer')