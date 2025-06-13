@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Account Details</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Bank Information</h5>
                    <form action="{{route('account.detail.store')}}" class="account-form" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="accountNumber" class="form-label">Account Number</label>
                                <input type="text" class="form-control" name="account_number" placeholder="Enter Account Number" value="{{$data->account_number ?? ''}}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="accountHolderBank" class="form-label">Account Holder Name</label>
                                <input type="text" class="form-control" name="account_holder" placeholder="Enter Account Holder Name" value="{{$data->account_holder ?? ''}}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bankNameBank" class="form-label">Bank Name</label>
                                <input type="text" class="form-control" name="bank_name" placeholder="Enter Bank Name" value="{{$data->bank_name ?? ''}}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ifscCode" class="form-label">IFSC Code</label>
                                <input type="text" class="form-control" name="ifsc" placeholder="Enter IFSC Code" value="{{$data->ifsc ?? ''}}" required>
                            </div>
                            <input type="hidden" name="account_id" value="{{$data->id ?? ''}}">
                            <div class="submit-btn-container">
                                <button type="submit" class="btn btn-primary btnsave">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5>Add UPI ID</h5>
                    <form action="{{route('account.detail.store')}}" class="account-form" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-12">
                                <label for="logoUpload" class="form-label">UPI Id</label>
                                <input type="text" class="form-control" name="upi" placeholder="Enter UPI Id" value="{{$data->upi ?? ''}}" required>

                                <label for="accountHolder" class="form-label mt-3">Account Holder Name</label>
                                <input type="text" class="form-control" name="upi_account_holder" placeholder="Enter Account Holder Name" value="{{$data->upi_account_holder ?? ''}}" required>
                                
                                <label for="bankName" class="form-label mt-3">Bank Name</label>
                                <input type="text" class="form-control" name="upi_bank_name" placeholder="Enter Bank Name" value="{{$data->upi_bank_name ?? ''}}" required>
                                <input type="hidden" name="account_id" value="{{$data->id ?? ''}}">
                                <div class="submit-btn-container mt-3">
                                    <button type="submit" class="btn btn-primary btnsave">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5>Add QR Image</h5>
                    <form action="{{route('account.detail.store')}}" class="account-form" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-8">
                                <label for="qrUpload" class="form-label">QR Image</label>
                                <input type="file" class="form-control" name="qr_photo" accept="image/*" required> 
                            </div>
                            <div class="col-md-4">
                                @if(!empty($data->qr_image))
                                    <img src="{{secure_asset($data->qr_image)}}" width="100">
                                @endif
                            </div>
                            <div class="col-md-12">
                                <label for="bankName" class="form-label mt-3">QR UPI Id</label>
                                <input type="text" class="form-control" name="qr_upi" placeholder="Enter QR UPI Id" value="{{$data->qr_upi ?? ''}}" required>
                                
                                <input type="hidden" name="account_id" value="{{$data->id ?? ''}}">
                                <div class="submit-btn-container mt-3">
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagescript')
<script>
    $(".account-form").on('submit', function (event) {
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
            beforeSend: function () {
                // $('#loader').show();
                $('.btnsave').prop('disabled', true);
            },
            success: function (response) {
                // $('#loader').hide();
                $('.btnsave').prop('disabled', false);

                if (response.status == 'success') {
                    toastr.success(response.message);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loader').hide();
                $('.btnsave').prop('disabled', false);

                console.error('AJAX error:', textStatus, 'Error thrown:', errorThrown);
                console.error('Server response:', jqXHR.responseText);

                // Optionally parse and display the error messages sent by the server
                if (jqXHR.responseText) {
                    try {
                        var response = JSON.parse(jqXHR.responseText);
                        if (response.errors) {
                            console.error('Validation errors:', response.errors);
                            $.each(response.errors, function (key, value) {
                                $.each(value, function (index, item) {
                                    toastr.error(item);
                                });
                            });
                        } else {
                            console.error('Error message:', response.message);
                        }
                    } catch (e) {
                        console.error('Error parsing JSON response');
                    }
                }
            }
        });
    });
</script>
@endsection
