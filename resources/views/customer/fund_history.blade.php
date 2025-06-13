@section('title', 'Add Fund History')
@include('customer.includes.header')
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('funds') }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-white text-uppercase">
                    Add Fund History
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            @foreach($payment_request as $row)
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-1">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <p class="mb-0 text-start fs-12">{{ $row->created_at->format('d-m-Y h:i A') }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-0 text-end fs-11 fw-normal">
                                    @if($row->status === 0)
                                    <span class="badge rounded-pill bg-warning-subtle text-warning">Pending</span>
                                    @elseif($row->status === 1)
                                    <span class="badge rounded-pill bg-success-subtle text-success">Success</span>
                                    @else
                                    <span class="badge rounded-pill bg-danger-subtle text-danger">Reject</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-6">
                                <p class="mb-0 fs-12"><i class="fas fa-indian-rupee-sign"></i> {{$row->amount}}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-0 text-center fs-12">Transaction id</p>
                                <p class="mb-0 text-center fs-11 fw-normal">{{$row->transaction_id}}</p>
                            </div>
                        </div>
                        
                        <div class="row align-items-center border-top my-1">
                            <div class="col-6">
                                <p class="mb-0 text-center fs-12">Request Type</p>
                                <p class="mb-0 text-center fs-11 fw-normal">Credit</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-0 text-center fs-12">Deposite Mode</p>
                                <p class="mb-0 text-center fs-11 fw-normal">UPI / Bank</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@include('customer.includes.footer')