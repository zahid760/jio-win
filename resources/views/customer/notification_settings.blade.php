@section('title', 'Notifications Settings')
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
                    Notifications Settings
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('update_settings') }}" method="POST" id="submit-form">
                                @csrf
                                @method('POST')
                                <div class="row mb-3">
                                    <div class="col-8 d-flex align-items-center">
                                        <label class="form-label mb-0" for="matka_game">Matka Notification</label>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check form-switch form-switch-success">
                                            <input class="form-check-input" type="checkbox" id="matka_game" name="matka_game" {{ old('matka_game', $settings->matka_game ?? false) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-8 d-flex align-items-center">
                                        <label class="form-label mb-0" for="satta_game">Satta Notification</label>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check form-switch form-switch-success">
                                            <input class="form-check-input" type="checkbox" id="satta_game" name="satta_game" {{ old('satta_game', $settings->satta_game ?? false) ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    <div id="loader" style="display:none; text-align: center; margin-top: 20px;">
                                        <div class="spinner-grow text-primary m-1" role="status" style="width:10rem; height:10rem;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('customer.includes.footer')
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
            success: function(response)
            {
                if(response.status === 'success')
                {
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