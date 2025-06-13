@section('title', 'Game Rate')
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
                    Game Rate
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="card mb-1 shadow-lg bg-danger text-white">
                <div class="card-body p-1">
                    <p class="mb-0 text-center">Game Win Ratio for Matka Bids</p>
                </div>
            </div>
            @foreach($game_rate as $row)
                @if($row->category == 'matka')
                    <div class="card mb-1 shadow-lg">
                        <div class="card-body p-1">
                            <p class="mb-0 text-center">{{$row->game_mode->name}}: <i class="fas fa-indian-rupee-sign"></i> {{$row->bidding_rate}} Ka <i class="fas fa-indian-rupee-sign"></i> {{$row->winning_rate}}</p>
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="card mb-1 shadow-lg bg-danger text-white">
                <div class="card-body p-1">
                    <p class="mb-0 text-center">Game Win Ratio for Satta Bids</p>
                </div>
            </div>
            @foreach($game_rate as $row)
                @if($row->category == 'satta')
                    <div class="card mb-1 shadow-lg">
                        <div class="card-body p-1">
                            <p class="mb-0 text-center">{{$row->game_mode->name}}: <i class="fas fa-indian-rupee-sign"></i> {{$row->bidding_rate}} Ka <i class="fas fa-indian-rupee-sign"></i> {{$row->winning_rate}}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@include('customer.includes.footer')