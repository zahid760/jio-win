@section('title', 'Passbook')
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
                    Transaction History
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            @foreach($passbook as $bid)
                @if($bid->status == 1)
                    <div class="card mb-1 shadow-lg">
                        <div class="card-body p-1">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <p class="mb-0 text-start fs-12"><span class="text-success">Win</span> <i class="fas fa-indian-rupee-sign"></i> {{$bid->winner->win_amount}}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0 text-end fs-11 fw-normal">{{ $bid->winner->created_at->format('d-m-Y h:i A') }}</p>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Bid Play</p>
                                    <p class="mb-0 text-center fs-11 fw-normal">{{$bid->game_number}}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Game</p>
                                    <p class="mb-0 text-center fs-11 fw-normal">{{$bid->bid->game->name ?? ''}}</p>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Type</p>
                                    <p class="mb-0 text-center fs-11 fw-normal">{{$bid->bid->gamemode->name}}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Market</p>
                                    <p class="mb-0 text-center fs-11 fw-normal">{{$bid->bid->game_type}}</p>
                                </div>
                            </div>
                            <div class="row align-items-center border-top border-bottom my-1">
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Previous Balance</p>
                                    <p class="mb-0 text-center fs-11 fw-normal"><i class="fas fa-indian-rupee-sign"></i> {{$bid->prev_balance}}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Transaction Amount</p>
                                    <p class="mb-0 text-center fs-11 fw-normal text-success"><i class="fas fa-indian-rupee-sign"></i> +{{$bid->winner->win_amount}}</p>
                                </div>
                            </div>
                            <p class="text-center fs-12 mb-0 text-success">Current Balance : <i class="fas fa-indian-rupee-sign"></i> {{$bid->current_balance}}</p>
                        </div>
                    </div>
                @else
                    <div class="card mb-1 shadow-lg">
                        <div class="card-body p-1">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <p class="mb-0 text-start fs-12"><span class="text-danger">Debit</span> <i class="fas fa-indian-rupee-sign"></i> {{$bid->points}}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0 text-end fs-11 fw-normal">{{ $bid->created_at->format('d-m-Y h:i A') }}</p>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Bid Play</p>
                                    <p class="mb-0 text-center fs-11 fw-normal">{{$bid->game_number}}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Game</p>
                                    <p class="mb-0 text-center fs-11 fw-normal">{{$bid->bid->game->name ?? ''}}</p>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Type</p>
                                    <p class="mb-0 text-center fs-11 fw-normal">{{$bid->bid->gamemode->name}}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Market</p>
                                    <p class="mb-0 text-center fs-11 fw-normal">{{$bid->bid->game_type}}</p>
                                </div>
                            </div>
                            <div class="row align-items-center border-top border-bottom my-1">
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Previous Balance</p>
                                    <p class="mb-0 text-center fs-11 fw-normal"><i class="fas fa-indian-rupee-sign"></i> {{$bid->prev_balance}}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0 text-center fs-12">Transaction Amount</p>
                                    <p class="mb-0 text-center fs-11 fw-normal text-danger"><i class="fas fa-indian-rupee-sign"></i> -{{$bid->points}}</p>
                                </div>
                            </div>
                            <p class="text-center fs-12 mb-0 text-danger">Current Balance : <i class="fas fa-indian-rupee-sign"></i> {{$bid->current_balance}}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        

        </div>
    </section>
@include('customer.includes.footer')