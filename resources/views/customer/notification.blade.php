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
            {{-- <div class="col-lg-12">
                    <a href="https://wa.me/91{{$data->whatsapp_no}}" class="btn btn-success w-100" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp fs-14 me-1"></i> WhatsApp</a>
                    <a href="https://wa.me/91{{$data->whatsapp_no}}" class="btn btn-primary w-100 mt-2" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-telegram fs-14 me-1"></i> Telegram</a>
                    <a href="https://wa.me/91{{$data->whatsapp_no}}" class="btn btn-danger w-100 mt-2" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram fs-14 me-1"></i> Instagram</a>
                    <a href="https://wa.me/91{{$data->whatsapp_no}}" class="btn btn-dark w-100 mt-2" target="_blank" rel="noopener noreferrer"><i class="fa fa-phone fs-14 me-1"></i> Call</a>
                </div> --}}
                
                @foreach($notificcations as $notificcation)
                    <a href="{{ route('show-notification', $notificcation->id) }}" class="text-decoration-none text-dark">
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
                                    <span class="badge bg-danger p-1">
                                        {{ \Carbon\Carbon::parse($notificcation->created_at)->format('d/m/Y h:s A') }}
                                    </span>
                                    <div>
                                        <button type="button" class="btn btn-light thumb-md rounded-circle ms-auto">
                                            <i class="iconoir-nav-arrow-right fs-26"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@include('customer.includes.footer')
