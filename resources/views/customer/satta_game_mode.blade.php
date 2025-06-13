@section('title', 'Game Mode')
@include('customer.includes.header')
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('satta.home') }}">
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
                    @if($mode->id == 16)
                        <div class="col-6 border py-2">
                            <a href="{{ route('satta.jodi', [$game->id, 16]) }}">
                                <div class="rounded-circle px-2 w-75 mx-auto">
                                    <img src="{{ secure_asset('assets/images/game-mode/'.$mode->icon) }}" class="img-fluid rounded-circle">
                                </div>
                                <p class="text-center text-dark mt-1 mb-0">{{ $mode->name }}</p>
                            </a>
                        </div>
                    @elseif($mode->id == 17)
                        <div class="col-6 border py-2">
                            <a href="{{ route('satta.baharharuf', [$game->id, 17]) }}">
                                <div class="rounded-circle px-2 w-75 mx-auto">
                                    <img src="{{ secure_asset('assets/images/game-mode/'.$mode->icon) }}" class="img-fluid rounded-circle">
                                </div>
                                <p class="text-center text-dark mt-1 mb-0">Haruf</p>
                            </a>
                        </div>
                    <!-- @elseif($mode->id == 18)
                        <div class="col-6 border py-2">
                            <a href="{{ route('satta.andarharuf', [$game->id, 18]) }}">
                                <div class="rounded-circle px-2 w-75 mx-auto">
                                    <img src="{{ secure_asset('assets/images/game-mode/'.$mode->icon) }}" class="img-fluid rounded-circle">
                                </div>
                                <p class="text-center text-dark mt-1 mb-0">{{ $mode->name }}</p>
                            </a>
                        </div> -->
                    @elseif($mode->id == 19)
                        <div class="col-6 border py-2">
                            <a href="{{ route('satta.crossing', [$game->id, 19]) }}">
                                <div class="rounded-circle px-2 w-75 mx-auto">
                                    <img src="{{ secure_asset('assets/images/game-mode/'.$mode->icon) }}" class="img-fluid rounded-circle">
                                </div>
                                <p class="text-center text-dark mt-1 mb-0">{{ $mode->name }}</p>
                            </a>
                        </div>
                    <!-- @elseif($mode->id == 20)
                        <div class="col-6 border py-2">
                            <a href="{{ route('satta.cut.crossing', [$game->id, 20]) }}">
                                <div class="rounded-circle px-2 w-75 mx-auto">
                                    <img src="{{ secure_asset('assets/images/game-mode/'.$mode->icon) }}" class="img-fluid rounded-circle">
                                </div>
                                <p class="text-center text-dark mt-1 mb-0">{{ $mode->name }}</p>
                            </a>
                        </div> -->
                    @endif
                @endforeach
            </div>
        </div>
    </section>

@include('customer.includes.footer')