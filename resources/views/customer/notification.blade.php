@section('title', 'Notification')
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
                    Notification
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="row">                
                <div class="col-12">                
                    @foreach($notificcations as $notificcation)
                        <div class="card mb-1 shadow-lg">
                            <div class="card-body p-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="bg-danger rounded-circle thumb-md shadow-lg">
                                            <i class="iconoir-bell fs-20 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="ms-2 me-auto">
                                        <h6 class="mb-1">{{ $notificcation->title }}</h6>
                                        <p class="text-muted mb-0 fs-11">{{ $notificcation->description }}</p>
                                    </div>
                                    <span>
                                        {{ $notificcation->result_date ? \Carbon\Carbon::parse($notificcation->result_date)->format('d-m-Y') : \Carbon\Carbon::parse($notificcation->created_at)->format('d-m-Y') }}
                                    </span>                                
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@include('customer.includes.footer')
