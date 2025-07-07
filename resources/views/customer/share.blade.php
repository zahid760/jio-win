@section('title', 'Share')
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
                    Share
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-1">
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="shareId" value="{{ route('share') }}" aria-label="shareId" aria-describedby="shareId" readonly>
                        <button class="btn btn-secondary " type="button" id="shareId" data-clipboard-action="copy" data-clipboard-target="#shareId"><i class="far fa-copy"></i></button>
                    </div>
                </div>
            </div>
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

@include('customer.includes.footer')
