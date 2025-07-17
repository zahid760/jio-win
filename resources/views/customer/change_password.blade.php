@section('title', 'Change Password')
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
                    Change Password
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container">
            <div class="card">
                <div class="card-body p-1">
                    <div class="tab-pane p-3 active show" id="special-mode" role="tabpanel">
                        <form action="{{ route('update-password') }}" method="POST" id="change-password-form">
                            @csrf
                            @method('POST')
                            <div class="mb-3 row">
                                <label for="current_password" class="col-2 col-form-label text-end">Current Password</label>
                                <div class="col-9">
                                    <div class="input-group input-group-sm">
                                        <input type="password" class="form-control" name="current_password" placeholder="Enter current password" id="current_password" required autocomplete="current-password">
                                        <span class="input-group-text bg-danger text-white">
                                            <i class="fa fa-eye" style="cursor:pointer;" onclick="togglePasswordVisibility('current_password')"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="new_password" class="col-2 col-form-label text-end">New Password</label>
                                <div class="col-9">
                                    <div class="input-group input-group-sm">
                                        <input type="password" class="form-control form-control-sm" id="new_password" name="new_password" required autocomplete="new-password" placeholder="Enter new password">
                                        <span class="input-group-text bg-danger text-white">
                                            <i class="fa fa-eye" style="cursor:pointer;" onclick="togglePasswordVisibility('new_password')"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="new_password_confirmation" class="col-2 col-form-label text-end">Confirm Password</label>
                                <div class="col-9">
                                    <div class="input-group input-group-sm">
                                        <input type="password" class="form-control form-control-sm" id="new_password_confirmation" name="new_password_confirmation" required autocomplete="new-password" placeholder="Confirm new password">
                                        <span class="input-group-text bg-danger text-white">
                                            <i class="fa fa-eye" style="cursor:pointer;" onclick="togglePasswordVisibility('new_password_confirmation')"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row sticky-bottom">
                                <div class="col-2 offset-2">
                                    <button type="submit" class="btn btn-danger w-100 btnsave">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="card">
                <div class="card-body p-1">
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="shareId" value="{{ route('login') }}" aria-label="shareId" aria-describedby="shareId" readonly>
                        <button class="btn btn-secondary " type="button" id="shareId" data-clipboard-action="copy" data-clipboard-target="#shareId"><i class="far fa-copy"></i></button>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>

    {{-- <section class="pb-5">
        <div class="container-fluid">
            <div class="ratio ratio-16x9" style="width: 100%; height: 90%; border: 0;">
                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video" allowfullscreen>
                </iframe>
            </div>
        </div>
    </section> --}}

@include('customer.includes.footer')

@section('pagescript')
<script src="{{ secure_asset('assets/libs/clipboard/clipboard.min.js') }}"></script>
<script src="{{ secure_asset('assets/js/pages/clipboard.init.js') }}"></script>
<script>
    function togglePasswordVisibility(inputId)
    {
        const input = document.getElementById(inputId);
        const icon = input.parentElement.querySelector('i');
        const isPassword = input.getAttribute('type') === 'password';
        input.setAttribute('type', isPassword ? 'text' : 'password');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }


    $('#change-password-form').on('submit', function(event)
    {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
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
                    // alert(response.message);
                    // window.location.href = "{{ route('home') }}";
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
