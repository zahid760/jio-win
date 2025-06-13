@section('title', 'Add Fund')
@include('customer.includes.header')
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('funds') }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-white text-uppercase">
                    Add Fund
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center text-white">
                        <i class="iconoir-wallet fs-20"></i> <i class="fas fa-indian-rupee-sign mx-1"></i> {{ $wallet }}
                    </div>
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="card mb-1 shadow-lg">
                <div class="card-body p-2">
                    <div class="card mb-1 shadow-lg">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center justify-content-center p-1 bg-danger rounded-top">
                                <i class="iconoir-wallet-solid fs-30 text-white"></i>
                                <div class="ms-1">
                                    <p class="text-white mb-0"><i class="fas fa-indian-rupee-sign"></i> {{$wallet}}</p>
                                    <p class="mb-0 fw-normal fs-12 text-white">Total Balance</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between px-3 pb-3 mt-1">
                                <div>
                                    <p class="text-danger mb-0"><i class="fas fa-indian-rupee-sign"></i> {{$deposite_wallet}}</p>
                                    <p class="mb-0 fw-normal fs-12">Deposite Balance</p>
                                </div>
                                <div>
                                    <a href="{{route('add.cash')}}" target="_blank" class="btn btn-danger rounded-pill shadow-lg">Add Cash</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between px-3 pb-3">
                                <div>
                                    <p class="text-danger mb-0"><i class="fas fa-indian-rupee-sign"></i> {{$bonus_wallet}}</p>
                                    <p class="mb-0 fw-normal fs-12">Bonus Balance</p>
                                </div>
                                <div>
                                    <a href="#" class="btn btn-danger rounded-pill shadow-lg">Earn Bonus</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between px-3 pb-3">
                                <div>
                                    <p class="text-danger mb-0"><i class="fas fa-indian-rupee-sign"></i> {{$winning_wallet}}</p>
                                    <p class="mb-0 fw-normal fs-12">Winning Balance</p>
                                </div>
                                <div>
                                    <a href="{{route('withdraw.fund')}}" class="btn btn-danger rounded-pill shadow-lg">Withdrawal</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-center mb-1 mt-2">For Fund Query's Please Call Or whatsapp</p>
                    <div class="d-flex items-center" style="justify-content: space-around;">
                        <a href="https://wa.me/918957305924" class="btn btn-light rounded-pill shadow-lg">
                            <i class="fa-brands fa-whatsapp"></i> whatsapp
                        </a>
                        <a href="tel:8957305924" class="btn btn-light rounded-pill shadow-lg">
                            <i class="iconoir-phone"></i> Call
                        </a>
                    </div>
                </div>
            </div>

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