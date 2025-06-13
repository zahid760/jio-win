@section('title', 'My Bids')
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
                    My Bids
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <a href="{{ route('bid.history') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-calendar fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Matka Bid History</h6>
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

            <a href="{{ route('game.result') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-clock-rotate-right fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Matka Game Results</h6>
                                <p class="text-muted mb-0 fs-11">You can view your market result history</p>
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

            <a href="{{ route('satta.bid.history') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-calendar fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Satta Bid History</h6>
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

            <a href="{{ route('satta.game.result') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-clock-rotate-right fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Satta Game Results</h6>
                                <p class="text-muted mb-0 fs-11">You can view your market result history</p>
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