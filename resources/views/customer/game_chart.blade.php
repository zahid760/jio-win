@section('title', 'Game Chart')
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
                    Game Chart
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <a href="{{ route('matka_panel_chart') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-spades fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Matka Panel Chart</h6>
                                <p class="text-muted mb-0 fs-11">View Matka Panel Chart</p>
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

            <a href="{{ route('matka_panel_jodi_chart') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-spades fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Matka Jodi Chart</h6>
                                <p class="text-muted mb-0 fs-11">View Matka Jodi Chart</p>
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

            <a href="{{ route('satta_result_chart') }}">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-bishop fs-20 fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h6 class="mb-1">Satta Result Chart</h6>
                                <p class="text-muted mb-0 fs-11">View Satta Result Chart</p>
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