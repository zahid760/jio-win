@section('title', 'Add Cash')
@include('customer.includes.header')
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('add.fund') }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-white text-uppercase">
                    Add Cash
                </div>
                <div class="col-auto">
                    <a href="{{ route('add.fund') }}">
                        <div class="d-flex align-items-center text-white">
                            <i class="iconoir-wallet fs-20"></i> <i class="fas fa-indian-rupee-sign mx-1"></i> {{ $wallet }}
                        </div>
                    </a>
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-1">
                    <div class="nav-tabs-custom text-center">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-center active" data-bs-toggle="tab" href="#cu_home" role="tab" aria-selected="true" tabindex="-1"><i class="la la-money-bill d-block"></i>UPI Id</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-center" data-bs-toggle="tab" href="#cu_profile" role="tab" aria-selected="false" tabindex="-1"><i class="la la-qrcode d-block"></i>Scanner</a>
                            </li>                                                
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-center" data-bs-toggle="tab" href="#cu_settings" role="tab" aria-selected="false"><i class="las la-university d-block"></i>Bank</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane py-1 active show" id="cu_home" role="tabpanel">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control" id="upiid" value="{{$account_details->upi ?? ''}}" aria-label="upiid" aria-describedby="upiid" readonly>
                                <button class="btn btn-secondary " type="button" id="upiid" data-clipboard-action="copy" data-clipboard-target="#upiid"><i class="far fa-copy"></i></button>
                            </div>
                            <div class="input-group mb-1">
                                <input type="text" class="form-control" id="upi_account_holder" value="{{$account_details->upi_account_holder ?? ''}}" aria-label="upi_account_holder" aria-describedby="upi_account_holder" readonly>
                                <button class="btn btn-secondary " type="button" id="upi_account_holder" data-clipboard-action="copy" data-clipboard-target="#upi_account_holder"><i class="far fa-copy"></i></button>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" id="upi_bank_name" value="{{$account_details->upi_bank_name ?? ''}}" aria-label="upi_bank_name" aria-describedby="upi_bank_name" readonly>
                                <button class="btn btn-secondary " type="button" id="upi_bank_name" data-clipboard-action="copy" data-clipboard-target="#upi_bank_name"><i class="far fa-copy"></i></button>
                            </div>
                        </div>
                        <div class="tab-pane py-1" id="cu_profile" role="tabpanel">
                            @if(isset($account_details->qr_image))
                            <div class="text-center mb-1">
                                <img src="{{secure_asset($account_details->qr_image)}}" class="img-fluid border rounded" width="150">
                            </div>
                            @endif
                            <div class="input-group">
                                <input type="text" class="form-control" id="qr_upi" value="{{$account_details->qr_upi ?? ''}}" aria-label="qr_upi" aria-describedby="qr_upi" readonly>
                                <button class="btn btn-secondary " type="button" id="qr_upi" data-clipboard-action="copy" data-clipboard-target="#qr_upi"><i class="far fa-copy"></i></button>
                            </div>
                        </div>                                                
                        <div class="tab-pane py-1" id="cu_settings" role="tabpanel">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control" id="account_number" value="{{$account_details->account_number ?? ''}}" aria-label="account_number" aria-describedby="account_number" readonly>
                                <button class="btn btn-secondary " type="button" id="account_number" data-clipboard-action="copy" data-clipboard-target="#account_number"><i class="far fa-copy"></i></button>
                            </div>
                            <div class="input-group mb-1">
                                <input type="text" class="form-control" id="account_holder" value="{{$account_details->account_holder ?? ''}}" aria-label="account_holder" aria-describedby="account_holder" readonly>
                                <button class="btn btn-secondary " type="button" id="account_holder" data-clipboard-action="copy" data-clipboard-target="#account_holder"><i class="far fa-copy"></i></button>
                            </div>
                            <div class="input-group mb-1">
                                <input type="text" class="form-control" id="bank_name" value="{{$account_details->bank_name ?? ''}}" aria-label="bank_name" aria-describedby="bank_name" readonly>
                                <button class="btn btn-secondary " type="button" id="bank_name" data-clipboard-action="copy" data-clipboard-target="#bank_name"><i class="far fa-copy"></i></button>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" id="ifsc" value="{{$account_details->ifsc ?? ''}}" aria-label="ifsc" aria-describedby="ifsc" readonly>
                                <button class="btn btn-secondary " type="button" id="ifsc" data-clipboard-action="copy" data-clipboard-target="#ifsc"><i class="far fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-1">
                    <form action="{{route('payment.request.store')}}" method="post" enctype="multipart/form-data" id="payment-form">
                        @csrf
                        @method('POST')
                        <div class="row g-2">
                            <div class="col-12">
                                <h5 class="mb-0 text-center">Payment Request</h5>
                                <hr class="my-1">
                            </div>
                            <div class="col-12">
                                <input type="file" class="form-control" name="screenshot" accept="image/*" required="">
                                <small id="emailHelp" class="form-text text-danger fs-10">Please upload your payment receipt or screenshot here.</small>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" name="transaction_id" placeholder="Transaction ID" required="">
                            </div>
                            <div class="col-12">
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount" required="">
                            </div>
                            <div class="col-12">
                                <button type="button" onclick="setAmount(300)" class="btn btn-danger btn-sm">300</button>
                                <button type="button" onclick="setAmount(500)" class="btn btn-danger btn-sm">500</button>
                                <button type="button" onclick="setAmount(1000)" class="btn btn-danger btn-sm">1000</button>
                                <button type="button" onclick="setAmount(2000)" class="btn btn-danger btn-sm">2000</button>
                                <button type="button" onclick="setAmount(5000)" class="btn btn-danger btn-sm">5000</button>
                                <button type="button" onclick="setAmount(10000)" class="btn btn-danger btn-sm">10000</button>
                                <button type="button" onclick="setAmount(25000)" class="btn btn-danger btn-sm">25000</button>
                                <button type="button" onclick="setAmount(50000)" class="btn btn-danger btn-sm">50000</button>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" name="comment" placeholder="Comment If Any" required="">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-danger btnsave">Submit Request</button>
                            </div>
                        </div>
                    </form>

                    <div class="row g-2 mt-2">
                        <div class="col-12">
                            <a href="https://wa.me/918957305924" class="btn btn-success w-100"><i class="fa-brands fa-whatsapp fs-14 me-1"></i> For Payment Related Issue Click Here</a>
                            <p class="mt-2 mb-0 text-danger fw-semibold">Note:</p>
                            <ul class="fs-9 ps-2">
                                <li>जमा करने के बाद, स्लिप अपलोड करें और अपनी जमा राशि लिखें।</li>
                                <li>स्लिप की कॉपी करें और 12-अंकीय यूटीआर नंबर दर्ज करें।</li>
                                <li>सबमिट बटन पर क्लिक करें और तुरंत पॉइंट्स और बोनस प्राप्त करें।</li>
                                <li>एनईएफटी/यूपीआई का प्राप्ति समय 40 मिनट से 1 घंटे तक हो सकता है।</li>
                                <li>पुराने, निष्क्रिय, या बंद खातों में जमा की गई राशि के लिए साइट जिम्मेदार नहीं है।</li>
                                <li>सत्यापन के बाद 24 घंटों के भीतर पॉइंट्स स्वचालित रूप से आपके वॉलेट में जोड़ दिए जाएंगे।</li>
                                <li>24x7 सहायता उपलब्ध है।</li>
                            </ul>

                        </div>
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

@section('pagescript')
<script src="{{ secure_asset('assets/libs/clipboard/clipboard.min.js') }}"></script>
<script src="{{ secure_asset('assets/js/pages/clipboard.init.js') }}"></script>
<script>
    $('#payment-form').on('submit',function(event){
        event.preventDefault();

        let url = jQuery(this).attr('action');
        let data = new FormData(this);

        $.ajax({
            url: url, // Set the URL to your server endpoint
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': jQuery("input[name='_token']").val()
            },
            data: data,
            processData: !1,
            contentType: !1,
            beforeSend: function() {
                // $('#loader').show();
                $('.btnsave').prop('disabled', true);
            },                
            success: function(response) {
                console.log(response);
                // $('#loader').hide();
                $('.btnsave').prop('disabled', false);

                if(response.status == 'success'){
                    Swal.fire({
                        title: response.message,
                        icon: "success",
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-success"
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                    // toastr.success(response.message);
                    // setTimeout(function(){
                        // window.open(baseUrl+"/matka_game", '_self');
                    // }, 1000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // $('#loader').hide();
                $('.btnsave').prop('disabled', false);

                console.error('AJAX error:', textStatus, 'Error thrown:', errorThrown);
                console.error('Server response:', jqXHR.responseText);
        
                // Optionally parse and display the error messages sent by the server
                if(jqXHR.responseText) {
                    try {
                        var response = JSON.parse(jqXHR.responseText);
                        if(response.errors) {
                            console.error('Validation errors:', response.errors); 
                            $.each(response.errors, function(key, value) {
                                $.each(value, function(index, item) {
                                    toastr.error(item);
                                });
                            });                                
                        } else {
                            console.error('Error message:', response.message);
                        }
                    } catch(e) {
                        console.error('Error parsing JSON response');
                    }
                }
            }
        });
    });

    function setAmount(value) {
        document.getElementById('amount').value = value;
    }
</script>
@endsection
@include('customer.includes.footer')
