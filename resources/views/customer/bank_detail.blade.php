@section('title', 'Bank Detail')
@include('customer.includes.header')
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('funds') }}">
                        <i class="iconoir-dot-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-white text-uppercase">
                    Update Bank Detail
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <form action="{{route('bank.detail.store')}}" method="post" enctype="multipart/form-data" id="bank-form">
                @csrf
                @method('POST')
                <div class="row g-2">
                    <div class="col-12">
                        <input type="text" class="form-control shadow-lg" name="name" placeholder="Enter name" value="{{$bank_detail->name ?? ''}}" required="">
                    </div>
                    <div class="col-12">
                        <input type="number" class="form-control shadow-lg" name="account_number" placeholder="Enter account number" value="{{$bank_detail->account_number ?? ''}}" required="">
                    </div>
                    <div class="col-12">
                        <input type="text" class="form-control shadow-lg" name="ifsc" placeholder="Enter IFSC" value="{{$bank_detail->ifsc ?? ''}}" required="">
                    </div>
                    <div class="col-12">
                        <input type="text" class="form-control shadow-lg" name="bank_name" placeholder="Enter bank name" value="{{$bank_detail->bank_name ?? ''}}" required="">
                    </div>
                    <div class="col-12">
                        <input type="text" class="form-control shadow-lg" name="upi_id" placeholder="Enter UPI Id" value="{{$bank_detail->upi_id ?? ''}}" required="">
                    </div>
                    <div class="col-12 text-center">
                        <input type="hidden" name="id" value="{{$bank_detail->id ?? ''}}">
                        <button type="submit" class="btn btn-danger btnsave">Save Detail</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@section('pagescript')
<script>
    $('#bank-form').on('submit',function(event){
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
</script>
@endsection
@include('customer.includes.footer')