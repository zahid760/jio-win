@section('title', 'Game Mode')
@include('customer.includes.header')
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('home') }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-center text-white">
                    {{ $game->name }}
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="row">
                @foreach($game_mode as $mode)
                    @if($mode->id == 1)
                        <div class="col-6 border py-2">
                            <a href="{{ route('single.digit', $game->id) }}">
                                <div class="rounded-circle px-2 w-75 mx-auto">
                                    <img src="{{ secure_asset('assets/images/game-mode/'.$mode->icon) }}" class="img-fluid rounded-circle">
                                </div>
                                <p class="text-center text-dark mt-1 mb-0">{{ $mode->name }}</p>
                            </a>
                        </div>
                    @elseif($mode->id == 2)
                        @if($current_time < $open_time)
                        <div class="col-6 border py-2">
                            <a href="{{ route('jodi', $game->id) }}">
                                <div class="rounded-circle px-2 w-75 mx-auto">
                                    <img src="{{ secure_asset('assets/images/game-mode/'.$mode->icon) }}" class="img-fluid rounded-circle">
                                </div>
                                <p class="text-center text-dark mt-1 mb-0">{{ $mode->name }}</p>
                            </a>
                        </div>
                        @endif
                    @elseif($mode->id == 3)
                        <div class="col-6 border py-2">
                            <a href="{{ route('single.pana', $game->id) }}">
                                <div class="rounded-circle px-2 w-75 mx-auto">
                                    <img src="{{ secure_asset('assets/images/game-mode/'.$mode->icon) }}" class="img-fluid rounded-circle">
                                </div>
                                <p class="text-center text-dark mt-1 mb-0">{{ $mode->name }}</p>
                            </a>
                        </div>
                    @elseif($mode->id == 4)
                        <div class="col-6 border py-2">
                            <a href="{{ route('double.pana', $game->id) }}">
                                <div class="rounded-circle px-2 w-75 mx-auto">
                                    <img src="{{ secure_asset('assets/images/game-mode/'.$mode->icon) }}" class="img-fluid rounded-circle">
                                </div>
                                <p class="text-center text-dark mt-1 mb-0">{{ $mode->name }}</p>
                            </a>
                        </div>
                    @elseif($mode->id == 5)
                        <div class="col-6 border py-2">
                            <a href="{{ route('triple.pana', $game->id) }}">
                                <div class="rounded-circle px-2 w-75 mx-auto">
                                    <img src="{{ secure_asset('assets/images/game-mode/'.$mode->icon) }}" class="img-fluid rounded-circle">
                                </div>
                                <p class="text-center text-dark mt-1 mb-0">{{ $mode->name }}</p>
                            </a>
                        </div>
                    @elseif($mode->id == 6)
                        <div class="col-6 border py-2">
                            <a href="{{ route('odd.even', $game->id) }}">
                                <div class="rounded-circle px-2 w-75 mx-auto">
                                    <img src="{{ secure_asset('assets/images/game-mode/'.$mode->icon) }}" class="img-fluid rounded-circle">
                                </div>
                                <p class="text-center text-dark mt-1 mb-0">{{ $mode->name }}</p>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

@include('customer.includes.footer')