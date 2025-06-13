@section('title', 'Withdraw Fund')
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
                    Withdraw Fund
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-1">
                    <form action="{{route('withdraw.fund.store')}}" method="post" id="payment-form">
                        @csrf
                        @method('POST')
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="iconoir-wallet-solid fs-30 text-danger"></i>
                                    <div class="ms-1">
                                        <p class="text-danger mb-0"><i class="fas fa-indian-rupee-sign"></i> {{Auth::user()->winning_wallet}}</p>
                                        <p class="mb-0 fw-normal fs-12">Winning Balance</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="number" class="form-control" name="amount" placeholder="Amount" required="">
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-danger btnsave">Submit Request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@section('pagescript')
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
                            let errorMessages = "";
                            console.error('Validation errors:', response.errors); 
                            $.each(response.errors, function(key, value) {
                                $.each(value, function(index, item) {
                                    errorMessages += `<li class="text-danger fs-10">${item}</li>`;
                                });
                            }); 
                            
                            Swal.fire({
                                title: "Validation Errors",
                                html: '<ul>'+errorMessages+'</ul>', // Use 'html' to render the formatted errors
                                icon: "error",
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                },
                                buttonsStyling: false
                            });
                        } else {
                            console.error('Error message:', response.message);
                            Swal.fire({
                                title: "Validation Errors",
                                html: '<ul>'+response.message+'</ul>', // Use 'html' to render the formatted errors
                                icon: "error",
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                },
                                buttonsStyling: false
                            });
                        }
                    } catch(e) {
                        console.error('Error parsing JSON response');
                    }
                }
            }
        });
    });
</script>
@endsection
@include('customer.includes.footer')