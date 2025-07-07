<div class="offcanvas offcanvas-start w-75" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header justify-content-between">
        <div class="row">
            <div class="col">
                <div class="bg-danger thumb-xl rounded-circle">
                    <i class="iconoir-user-circle fs-30 text-white"></i>
                </div>
            </div>
            <div class="col-auto">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{ Auth::user()->name }}</h5>
                <p class="mb-0">{{ Auth::user()->mobile }}</p>
                <p class="mb-0">Since {{ Auth::user()->created_at->format('d/m/Y') }}</p>
            </div>
            
        </div>
        <div class="position-absolute top-0 end-0 mt-2 me-2">
            <button type="button" class="btn-close fs-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-home fs-18 text-white"></i></span> 
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('add.fund') }}">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-card-wallet fs-18 text-white"></i></span>
                    Add Money
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="las la-receipt fs-18 text-white"></i></span>
                    Withdraw Money
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('my.bids') }}">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-clock-rotate-right fs-18 text-white"></i></span>
                    My Bid
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('passbook')}}">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-open-book fs-18 text-white"></i></span>
                    Passbook
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('funds')}}">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-bank fs-18 text-white"></i></span>
                    Funds
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-bell-notification fs-18 text-white"></i></span>
                    Notification
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('game-chart')}}">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-candlestick-chart fs-18 text-white"></i></span>
                    Game Chart
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('game.rate')}}">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-dollar-circle fs-18 text-white"></i></span>
                    Game Rate
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-settings fs-18 text-white"></i></span>
                    Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-play-solid fs-18 text-white"></i></span>
                    Video
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-key fs-18 text-white"></i></span>
                    Change Password
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('share') }}">
                    <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-share-android fs-18 text-white"></i></span>
                    Share
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="nav-link" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <span class="bg-danger thumb-md rounded-circle me-1"><i class="iconoir-log-out fs-18 text-white"></i></span>
                        Logout
                    </a>
                </form>
            </li>
        </ul>
    </div>
</div>
