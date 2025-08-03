    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ secure_asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ secure_asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/pages/sweet-alert.init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        window.addEventListener('load', function () {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.display = 'none';
            }
        });
    </script>
    @yield('pagescript')
</body>
</html>