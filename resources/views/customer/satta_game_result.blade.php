@section('title', 'Game Result')
@include('customer.includes.header')
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('my.bids') }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-white text-uppercase">
                    Game Result
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <div>
                    <p class="mb-0">Select Date</p>
                </div>
                <div>
                    <input type="date" class="form-control" id="date-input" data-url="{{route('get.satta.game.result')}}" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                </div>
            </div>
            
            <div id="game-result-list">
                <div class="card mb-1 shadow-lg">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Not Found</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@section('pagescript')
    <script>
        $(document).ready(function(){
            get_result();
        });

        $(document).on('change', '#date-input', function(){
            get_result();
        });

        function get_result(){
            let url = $("#date-input").attr('data-url');
            let date = $("#date-input").val();
            let html = '';
            $.ajax({
                url: url, // Set the URL to your server endpoint
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    date:date
                },
                beforeSend: function() {
                    // $('#loader').show();
                    $('.btnsave').prop('disabled', true);
                },                
                success: function(response) {
                    console.log(response);
                    // $('#loader').hide();
                    $('.btnsave').prop('disabled', false);

                    if(response.status == 'success'){
                        if(response.data.length > 0){
                            response.data.map((data) => {
                                    html +=`<div class="card mb-1 shadow-lg">
                                                <div class="card-body p-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-0">${data.name}</p>
                                                        <p class="mb-0">${data.game_result_history && data.game_result_history.open ? data.game_result_history.open : '**'}</p>
                                                    </div>
                                                </div>
                                            </div>`;
                            });
                            $('#game-result-list').html(html);
                        }
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
        }
    </script>
@endsection
@include('customer.includes.footer')