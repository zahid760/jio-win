@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Partner</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Partner Create</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <form action="{{ route('partner.store') }}" method="post" id="submit-form">
                        @csrf
                        @method('POST')
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Enter name" required="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mobile" minlength="2" maxlength="10" placeholder="Enter mobile number" required="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" minlength="2" maxlength="8" placeholder="Enter password" required="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" minlength="2" maxlength="8" placeholder="Enter password" required="">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="start_date" required="">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="end_date" required="">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="amount" required="">
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="MATKA_GAME" id="matka_game" name="game_permissions[]">
                                    <label class="form-check-label" for="matka_game">Matka Game</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="SATTA_GAME" id="satta_game" name="game_permissions[]">
                                    <label class="form-check-label" for="satta_game">Satta Game</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="COLOR_GAME" id="color_game" name="game_permissions[]">
                                    <label class="form-check-label" for="color_game">Color Pridiction</label>
                                </div>
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
                        window.open(baseUrl + "/partner", '_self');
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
