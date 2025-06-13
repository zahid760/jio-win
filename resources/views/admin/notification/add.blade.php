@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Notification</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Notification Create</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <form action="{{ route('notification.store') }}" method="post" id="submit-form">
                        @csrf
                        @method('POST')
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" placeholder="Enter title" required="">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="description" placeholder="Enter description" required="">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btnsave">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="loader" style="display:none;">
                    <div class="spinner-grow text-primary m-1" role="status" style="width:10rem; height:10rem;">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagescript')
<script>
    $("#submit-form").on('submit', function (event) {
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
                $('#loader').show();
                $('.btnsave').prop('disabled', true);
            },
            success: function (response) {
                $('#loader').hide();
                $('.btnsave').prop('disabled', false);

                if (response.status == 'success') {
                    toastr.success(response.message);
                    setTimeout(function () {
                        window.open(baseUrl + "/notification", '_self');
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
