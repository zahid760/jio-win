@section('title', 'Bid History')
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
                    Bid History
                </div>
                <div class="col-auto">
                    <a href="javascript:void(0);" class="text-white d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#filterModal">
                        Filter By <i class="iconoir-filter-solid"></i>
                    </a>
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid container-bid">
            
        </div>
    </section>

    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-light">
                <div class="modal-header bg-danger justify-content-center py-1">
                    <h6 class="modal-title m-0" id="filterModalLabel">Filter Type</h6>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div><!--end modal-header-->
                <div class="modal-body">
                    <form action="{{route('bid.history.filter')}}" method="POST" id="filter-form">
                        @csrf
                        @method('POST')
                        <p class="mb-0">By Game Type</p>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input border-dark" type="checkbox" name="game_type[]" value="open" id="open">
                                    <label class="form-check-label" for="open">Open</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input border-dark" type="checkbox" name="game_type[]" value="close" id="close">
                                    <label class="form-check-label" for="close">Close</label>
                                </div>
                            </div>
                        </div>
                        <hr class="my-1">
                        <p class="mb-0">By Winning Status</p>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input border-dark" type="checkbox" name="winning_status[]" value="1" id="win">
                                    <label class="form-check-label" for="win">Win</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input border-dark" type="checkbox" name="winning_status[]" value="2" id="loose">
                                    <label class="form-check-label" for="loose">Loose</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input border-dark" type="checkbox" name="winning_status[]" value="0" id="pending">
                                    <label class="form-check-label" for="pending">Pending</label>
                                </div>
                            </div>
                        </div> 
                        <hr class="my-1">
                        <p class="mb-0">By Games</p>
                        <div class="bidrow">
                            @foreach($matka_games as $game)
                            <div class="card mb-1">
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input border-dark" type="checkbox" name="by_game[]" value="{{$game->id}}" id="{{$game->name}}">
                                                <label class="form-check-label" for="{{$game->name}}">{{$game->name}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-evenly">
                            <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger btn-sm btnsave" id="submit-filter">Filter</button>
                        </div>  
                    </form>                                           
                </div>
            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div>
@section('pagescript')
    <script>
        $(document).ready(function(){
            filter_form();
        });

        $(document).on('click', '#submit-filter', function(){
            filter_form();
            $('#filterModal').modal('hide');
        });

        function filter_form(){
            let url = $("#filter-form").attr('action');
            let data = new FormData($("#filter-form")[0]);
            let html = '';
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
                        if(response.data.length > 0){
                            response.data.map((data) => {
                                data.bidchild.map((ele, index) => {
                                    const dateStr = ele.created_at;
                                    const date = new Date(dateStr);
                                    const options = { hour: '2-digit', minute: '2-digit', hour12: true };
                                    const formattedDate = date.toLocaleDateString('en-GB'); // Format as DD-MM-YYYY
                                    const formattedTime = date.toLocaleTimeString('en-US', options); // Format as 08:44 PM

                                    html +=`<div class="card mb-1 shadow-lg">
                                                <div class="card-header text-uppercase p-1 bg-danger text-center text-white">${data.game.name} (${data.game_type})</div>
                                                <div class="card-body p-1">
                                                    <div class="row align-items-center">
                                                        <div class="col-4">
                                                            <p class="mb-0 text-center fs-12">Game Type</p>
                                                            <p class="mb-0 text-center fs-11 fw-normal">${data.gamemode.name}</p>
                                                        </div>
                                                        <div class="col-4">
                                                            <p class="mb-0 text-center fs-12">Digit</p>
                                                            <p class="mb-0 text-center fs-11 fw-normal">${ele.game_number}</p>
                                                        </div>
                                                        <div class="col-4">
                                                            <p class="mb-0 text-center fs-12">Points</p>
                                                            <p class="mb-0 text-center fs-11 fw-normal">${ele.points}</p>
                                                        </div>
                                                    </div>
                                                    <p class="text-center border-top border-bottom fs-12 my-1">Transaction: ${formattedDate} ${formattedTime}</p>`;
                                                    if(ele.status == 1){
                                                        html += `<p class="text-center fs-12 mb-0 text-success">You win <i class="las la-trophy"></i></p>`;
                                                    }else if(ele.status == 0){
                                                        html += `<p class="text-center fs-12 mb-0 text-warning">Best of luck <i class="iconoir-timer"></i></p>`;

                                                    }else{
                                                        html += `<p class="text-center fs-12 mb-0 text-danger">Better luck next time <i class="iconoir-thumbs-down"></i></p>`;
                                                    }
                                        html += `</div>
                                            </div>`;
                                });
                            });
                            $('.container-bid').html(html);
                        }else{
                            $('.container-bid').html('<p class="text-center">No Bid Found</p>');
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