
<!-- Top Bar Start -->
<div class="topbar d-print-none">
    <div class="container-fluid">
        <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">                        
                <li>
                    <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                        <i class="iconoir-menu"></i>
                    </button>
                </li> 
            </ul>
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <li class="topbar-item">
                    <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                        <i class="iconoir-half-moon dark-mode"></i>
                        <i class="iconoir-sun-light light-mode"></i>
                    </a>                    
                </li>

                <li class="dropdown topbar-item">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false" data-bs-offset="0,19">
                        <img src="{{ secure_asset('assets/images/users/avatar-1.jpg') }}" alt="" class="thumb-md rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0">
                        <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                            <div class="flex-shrink-0">
                                <img src="{{ secure_asset('assets/images/users/avatar-1.jpg') }}" alt="" class="thumb-md rounded-circle">
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                <h6 class="my-0 fw-medium text-dark fs-13">{{ Auth::user()->name }}</h6>
                                <small class="text-muted mb-0">{{ Auth::user()->roles->first()->name ?? 'No role assigned' }}</small>
                            </div>
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <small class="text-muted px-2 pb-1 d-block">Account</small>
                        <a class="dropdown-item" href="pages-profile.html"><i class="las la-user fs-18 me-1 align-text-bottom"></i> Profile</a>
                                             
                        <div class="dropdown-divider mb-0"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item text-danger" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"><i class="las la-power-off fs-18 me-1 align-text-bottom"></i> Logout</a>
                        </form>
                    </div>
                </li>
            </ul><!--end topbar-nav-->
        </nav>
        <!-- end navbar-->
    </div>
</div>
<!-- Top Bar End -->
<!-- leftbar-tab-menu -->
<div class="startbar d-print-none">
    <!--start brand-->
    <div class="brand">
        <a href="{{route('dashboard')}}" class="logo">
            <span>
                <img src="{{ secure_asset('assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm">
            </span>
            <span class="">
                <img src="{{ secure_asset('assets/images/logo-light.png') }}" alt="logo-large" class="logo-lg logo-light">
                <img src="{{ secure_asset('assets/images/logo-dark.png') }}" alt="logo-large" class="logo-lg logo-dark">
            </span>
        </a>
    </div>
    <!--end brand-->
    <!--start startbar-menu-->
    <div class="startbar-menu" >
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <ul class="navbar-nav mb-auto w-100">
                    <li class="menu-label mt-2">
                        <span>Main</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('dashboard')}}">
                            <i class="iconoir-report-columns menu-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @if(auth()->user()->hasRole('ADMIN'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('partner.index')}}">
                            <i class="iconoir-community menu-icon"></i>
                            <span>Partner</span>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.index') }}">
                            <i class="iconoir-group menu-icon"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    @can('MATKA_GAME')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('matka_game.index') }}">
                            <i class="iconoir-spades menu-icon"></i>
                            <span>Matka Game</span>
                        </a>
                    </li>
                    @endcan
                    @can('SATTA_GAME')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('satta_game.index') }}">
                            <i class="iconoir-bishop menu-icon"></i>
                            <span>Stta Game</span>
                        </a>
                    </li>
                    @endcan
                    @can('COLOR_GAME')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('satta_game.index') }}">
                            <i class="iconoir-bishop menu-icon"></i>
                            <span>Color Pridiction</span>
                        </a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('payment.request.list')}}">
                            <i class="iconoir-hand-cash menu-icon"></i>
                            <span>Payment Request</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('withdraw.request.list')}}">
                            <i class="iconoir-hand-cash menu-icon"></i>
                            <span>Withdraw Request</span>
                        </a>
                    </li>                    
                    @if(auth()->user()->hasRole('ADMIN'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('notification.index')}}">
                            <i class="iconoir-bell menu-icon"></i>
                            <span>Notification</span>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarTransactions" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTransactions">
                            <i class="las la-cog menu-icon"></i>
                            <span>Settings</span>
                        </a>
                        <div class="collapse " id="sidebarTransactions">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('account.detail')}}">Bank Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('game_rate.index')}}">Game Rate</a>
                                </li>
                                @if(auth()->user()->hasRole('ADMIN'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('global_support.index')}}">Global Support</a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('support.index')}}">Support</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('bonus.index')}}">Bonus</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>   
            </div>
        </div><!--end startbar-collapse-->
    </div><!--end startbar-menu-->    
</div><!--end startbar-->
<div class="startbar-overlay d-print-none"></div>
<!-- end leftbar-tab-menu-->