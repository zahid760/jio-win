<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ secure_asset('assets/images/favicon.ico') }}">
    
    <link href="{{ secure_asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ secure_asset('assets/libs/animate.css/animate.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ secure_asset('assets/libs/simple-datatables/style.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ secure_asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ secure_asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" type="text/css" />
    <link href="{{ secure_asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ secure_asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <script>
        var baseUrl = "{{ config('app.url') }}";
    </script>
</head>

<body>

    @include('admin.includes.header')

    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            @yield('pagecontent')
            <!--Start Rightbar-->
            <!--Start Rightbar/offcanvas-->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="Appearance" aria-labelledby="AppearanceLabel">
                <div class="offcanvas-header border-bottom justify-content-between">
                  <h5 class="m-0 font-14" id="AppearanceLabel">Appearance</h5>
                  <button type="button" class="btn-close text-reset p-0 m-0 align-self-center" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">  
                    <h6>Account Settings</h6>
                    <div class="p-2 text-start mt-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="settings-switch1">
                            <label class="form-check-label" for="settings-switch1">Auto updates</label>
                        </div><!--end form-switch-->
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="settings-switch2" checked>
                            <label class="form-check-label" for="settings-switch2">Location Permission</label>
                        </div><!--end form-switch-->
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="settings-switch3">
                            <label class="form-check-label" for="settings-switch3">Show offline Contacts</label>
                        </div><!--end form-switch-->
                    </div><!--end /div-->
                    <h6>General Settings</h6>
                    <div class="p-2 text-start mt-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="settings-switch4">
                            <label class="form-check-label" for="settings-switch4">Show me Online</label>
                        </div><!--end form-switch-->
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="settings-switch5" checked>
                            <label class="form-check-label" for="settings-switch5">Status visible to all</label>
                        </div><!--end form-switch-->
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="settings-switch6">
                            <label class="form-check-label" for="settings-switch6">Notifications Popup</label>
                        </div><!--end form-switch-->
                    </div><!--end /div-->               
                </div><!--end offcanvas-body-->
            </div>
            <!--end Rightbar/offcanvas-->
            <!--end Rightbar-->
            @include('admin.includes.footer')
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    <!-- Javascript  -->
    <!-- vendor js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ secure_asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ secure_asset('assets/libs/simplebar/simplebar.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ secure_asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/pages/sweet-alert.init.js') }}"></script>

    @yield('pagescript')

    <script src="{{ secure_asset('assets/js/app.js') }}"></script>
    <script>
        function delete_func(routeurl) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    // Perform AJAX request to delete
                    $.ajax({
                        type: 'DELETE',
                        url: routeurl,
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        },
                        success: (response) => {
                            if (response.status === 'success') {
                                // toastr.success(response.message);
                                Swal.fire("Deleted!", response.message, "success");
                                $('#listrow' + getLastElementOfUrl(routeurl)).remove();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function () {
                            alert('Something went wrong');
                        }
                    });
                }
            });
        }


        function getLastElementOfUrl(url) {
            var segments = url.split('/');

            // The ID is the last segment, but because the last segment might be an empty string (due to trailing slash), you can use filter to remove empty strings and then get the last segment
            const id = segments[segments.length - 1];
            return id;
        }
    </script>
</body>
</html>