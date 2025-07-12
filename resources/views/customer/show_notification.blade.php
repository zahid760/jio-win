@section('title', 'Show Notification')
@include('customer.includes.header')
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('notification') }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-white text-uppercase">
                    Show Notification
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                    <i class="iconoir-bell fs-20 text-white"></i>
                                </div>
                            </div>
                            <div class="ms-2 me-auto">
                                <h4 class="mb-1">{{ $Getnotification->title }}</h4>
                                <p class="text-muted mb-0 fs-11">{{ $Getnotification->description }}</p>
                            </div>
                            <div class="ms-2 me-auto">
                                @if($Getnotification->event_type == 0)
                                    <span class="badge bg-success fs-14">General</span>
                                @elseif($Getnotification->event_type == 1)
                                    <span class="badge bg-success fs-14">Deposite</span>
                                @elseif($Getnotification->event_type == 2)
                                    <span class="badge bg-success fs-14">Withdrow</span>
                                @elseif($Getnotification->event_type == 3)
                                    <span class="badge bg-success fs-14">Matka Result</span>
                                @elseif($Getnotification->event_type == 4)
                                    <span class="badge bg-success fs-14">Satta Result</span>
                                @endif
                            </div>
                            <span class="badge bg-success p-2">
                                {{ \Carbon\Carbon::parse($Getnotification->created_at)->format('d/m/Y h:s A') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('customer.includes.footer')
@section('pagescript')
