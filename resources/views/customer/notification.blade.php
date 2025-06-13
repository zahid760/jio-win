@section('title', 'Funds')
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
                <div class="col-lg-12">
                    <a href="https://wa.me/91{{$data->whatsapp_no}}" class="btn btn-success w-100" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp fs-14 me-1"></i> WhatsApp</a>
                    <a href="https://wa.me/91{{$data->whatsapp_no}}" class="btn btn-primary w-100 mt-2" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-telegram fs-14 me-1"></i> Telegram</a>
                    <a href="https://wa.me/91{{$data->whatsapp_no}}" class="btn btn-danger w-100 mt-2" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram fs-14 me-1"></i> Instagram</a>
                    <a href="https://wa.me/91{{$data->whatsapp_no}}" class="btn btn-dark w-100 mt-2" target="_blank" rel="noopener noreferrer"><i class="fa fa-phone fs-14 me-1"></i> Call</a>
                </div>
            </div>
        </div>
    </section>
@include('customer.includes.footer')