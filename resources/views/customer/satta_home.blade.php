@section('title', 'Aam Play')
@include('customer.includes.header')
    <div class="header sticky-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col d-flex align-items-center">
                    <button class="btn p-0 lh-1 " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        <i class="iconoir-menu fs-20"></i>
                    </button>
                    <h5 class="mb-0 ms-1"><strong>{{ config('app.name') }}</strong></h5>
                </div>
                <div class="col-auto d-flex">
                    <a href="{{ route('add.fund') }}" class="btn d-flex align-items-center px-0" type="button">
                        <i class="iconoir-wallet fs-20"></i> <i class="fas fa-indian-rupee-sign mx-1"></i> {{ $wallet }}
                    </a>
                    <button class="btn d-flex align-items-center px-0 ms-1" type="button">
                        <i class="iconoir-bell fs-20"></i>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <marquee behavior="scroll" direction="left" scrollamount="4">
                        <p class="text-danger mb-0">24x7 Helpline Number 8957305924. Available Languages English, Hindi, Marathi</p>
                    </marquee>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <a href="{{route('home')}}" class="btn rounded-pill btn-danger d-flex align-items-center p-1 w-100" type="button">
                        <span class="badge rounded-pill text-dark bg-light me-1 d-flex align-items-center justify-content-center" style="width:30px;height:30px;"><i class="iconoir-play-solid fs-14"></i></span> Matka
                    </a>
                </div>

                <div class="col-6">
                    <a href="{{route('satta.home')}}" class="btn rounded-pill btn-danger d-flex align-items-center p-1 w-100" type="button">
                        <span class="badge rounded-pill text-dark bg-light me-1 d-flex align-items-center justify-content-center" style="width:30px;height:30px;"><i class="iconoir-play-solid fs-14"></i></span> Satta
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <a href="tel:918957305924" class="btn d-flex align-items-center justify-content-center">
                        <i class="iconoir-phone fs-14 me-1"></i> 8957305924
                    </a>
                </div>

                <div class="col-6">
                    <a href="https://wa.me/918957305924" class="btn d-flex align-items-center justify-content-center">
                        <i class="fa-brands fa-whatsapp fs-14 me-1 text-success"></i> 8957305924
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="pb-3">
        <div class="container-fluid">
            @foreach($satta_games as $game)
                @php
                    $close_days = json_decode($game->closing_days, true) ?? [];
                    $current_day = \Carbon\Carbon::now()->format('l');
                    $current_time = \Carbon\Carbon::now();
                    $open_time = \Carbon\Carbon::parse($game->open_time)->subMinutes(5);
                    $open_time_spl_game = \Carbon\Carbon::parse($game->open_time)->addHour();
                    $open_time_spl = \Carbon\Carbon::parse('00:00:00');
                @endphp
                @if(!in_array($current_day, $close_days))
                    @if($game->spl == 1)
                        <div class="row">
                            <div class="col-12">
                                @if($current_time > $open_time_spl && $current_time < $open_time_spl_game)
                                <a href="javascript:void(0);" class="close-today-btn">
                                @else
                                <a href="{{ route('satta.game.mode', $game->id) }}">
                                @endif
                                    <div class="card mb-1 shadow-lg">
                                        <div class="card-body p-2">
                                            <div class="row">
                                                <div class="col-8">
                                                    <h5 class="mb-1">{{ $game->name }}</h5>
                                                    <p class="text-danger mb-0 "><strong>{{ $game->result->open ?? '**' }}</strong></p>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="mb-0 fs-12">Open Time:</p>
                                                            <p class="mb-0 fs-10">{{ formatTime($game->open_time) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    @if($current_time > $open_time_spl && $current_time < $open_time_spl_game)
                                                        <p class="text-danger mb-0 fs-11 text-center">Closed for today</p>
                                                        <button type="button" class="btn btn-danger thumb-lg rounded-circle mx-auto">
                                                            <i class="iconoir-xmark fs-26"></i>
                                                        </button>
                                                    @else
                                                        <p class="text-success mb-0 fs-11 text-center">Bet is Running</p>
                                                        <button type="button" class="btn btn-success thumb-lg rounded-circle mx-auto">
                                                            <i class="iconoir-play-solid fs-26"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12">
                                @if($current_time > $open_time)
                                <a href="javascript:void(0);" class="close-today-btn">
                                @else
                                <a href="{{ route('satta.game.mode', $game->id) }}">
                                @endif
                                    <div class="card mb-1 shadow-lg">
                                        <div class="card-body p-2">
                                            <div class="row">
                                                <div class="col-8">
                                                    <h5 class="mb-1">{{ $game->name }}</h5>
                                                    <p class="text-danger mb-0 "><strong>{{ $game->result->open ?? '**' }}</strong></p>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="mb-0 fs-12">Open Time:</p>
                                                            <p class="mb-0 fs-10">{{ formatTime($game->open_time) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    @if($current_time > $open_time)
                                                        <p class="text-danger mb-0 fs-11 text-center">Closed for today</p>
                                                        <button type="button" class="btn btn-danger thumb-lg rounded-circle mx-auto">
                                                            <i class="iconoir-xmark fs-26"></i>
                                                        </button>
                                                    @else
                                                        <p class="text-success mb-0 fs-11 text-center">Bet is Running</p>
                                                        <button type="button" class="btn btn-success thumb-lg rounded-circle mx-auto">
                                                            <i class="iconoir-play-solid fs-26"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </section>

    <section class="pb-5">
        <div class="container-fluid">
            <div class="ratio ratio-16x9" style="width: 100%; height: 90%; border: 0;">
                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video" allowfullscreen>
                </iframe>
            </div>
        </div>
    </section>

    <section class="bottom-nav fixed-bottom bg-white py-1">
        <div class="container-fluid">
            <div class="row gx-2 flex-nowrap">
                <div class="col text-center">
                    <a href="{{ route('my.bids') }}" class="btn p-0">
                        <i class="fas fa-gavel fs-18"></i><br>
                        <p class="mb-0 fs-12">My Bids</p>
                    </a>
                </div>

                <div class="col text-center">
                    <a href="{{route('passbook')}}" class="btn p-0">
                        <i class="iconoir-open-book fs-18"></i><br>
                        <p class="mb-0 fs-12">Passbook</p>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('home') }}" class="btn btn-danger thumb-md rounded-circle mx-auto">
                        <i class="iconoir-home fs-14"></i>
                    </a>
                </div>

                <div class="col text-center">
                    <a href="{{route('funds')}}" class="btn p-0">
                        <i class="iconoir-bank fs-18"></i><br>
                        <p class="mb-0 fs-12">Funds</p>
                    </a>
                </div>

                <div class="col text-center">
                    <a href="https://wa.me/918957305924" target="_blank" class="btn p-0">
                        <i class="iconoir-chat-bubble fs-18"></i><br>
                        <p class="mb-0 fs-12">Support</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('customer.includes.sidebar')
    
@section('pagescript')
    <script>
        $('.close-today-btn').click(function(){
            Swal.fire({
                icon: "error",
                title: "Sorry !",
                html: "<p class='fs-6 text-dark mb-0'>Betting is closed for today.<br>Please come next day to play.</p>",
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-danger" // Add Bootstrap danger class
                },
                buttonsStyling: false // Disable SweetAlert2's default button styles
            });
        });
    </script>
@endsection
@include('customer.includes.footer')
