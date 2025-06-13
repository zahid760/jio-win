@section('title', 'Odd Even')
@include('customer.includes.header')

    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('game.mode', $game->id) }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-center text-white text-uppercase">
                    {{ $game->name }} - Odd Even
                </div>
                <div class="col-auto">
                    <a href="{{ route('add.fund') }}">
                        <div class="d-flex align-items-center text-white">
                            <i class="iconoir-wallet fs-20"></i> <i class="fas fa-indian-rupee-sign mx-1"></i> {{ number_format($wallet, 2) }}
                        </div>
                    </a>
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('odd.even.store') }}" method="POST" id="bid-form">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn bg-white d-flex">
                                    <i class="iconoir-calendar fs-20 me-1 text-danger"></i> {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                                </button>
                            </div>
                            <div class="col-6">
                                @php $close_time = $game->spl == 1 ? \Carbon\Carbon::parse($close_time)->addDay() : $close_time;  @endphp
                                <select name="game_type" class="form-select">
                                    @if($current_time < $open_time)
                                        <option value="open">Open</option>
                                    @endif
                                    @if($current_time < $close_time)
                                        <option value="close">Close</option>
                                    @endif
                                </select>
                            </div>
                            <div class="d-flex justify-content-evenly my-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="odd_even" id="odd" value="odd" checked="">
                                    <label class="form-check-label" for="odd">
                                        Odd Digit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="odd_even" id="even" value="even">
                                    <label class="form-check-label" for="even">
                                        Even Digit
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-1 mb-2 align-items-center">
                            <div class="col-6">
                                Enter Points:
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control" id="point" placeholder="Point">
                            </div>
                            <div class="col-6"></div>
                            <div class="col-6">
                                <button type="button" class="btn btn-danger btn-sm w-100" id="add-point">Add</button>
                            </div>
                        </div>

                        <div class="card bg-danger-subtle mb-1">
                            <div class="card-body p-1">
                                <div class="row">
                                    <div class="col-3 text-center">Ank</div>
                                    <div class="col-3 text-center">Point</div>
                                    <div class="col-3 text-center">Type</div>
                                    <div class="col-3 text-center">Delete</div>
                                </div>
                            </div>
                        </div>

                        <div id="bid-point">

                        </div>

                        <div class="row fixed-bottom border-top border-danger align-items-center py-1">
                            <div class="col-4 text-center">
                                Bids: <span id="total-bid">0</span>
                            </div>
                            <div class="col-4 text-center">
                                Points: <span id="total-points">0</span>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-danger btn-sm w-100 btnsave">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-light">
                <div class="modal-header bg-danger justify-content-center py-1">
                    <h6 class="modal-title m-0 text-uppercase" id="confirmModalLabel">{{ $game->name }} Day - {{ \Carbon\Carbon::now()->format('d-m-Y') }}</h6>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div><!--end modal-header-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4 text-center">Digit</div>
                        <div class="col-4 text-center">Point</div>
                        <div class="col-4 text-center">Type</div>
                    </div>  
                    <div id="bid-details">
                    </div>
                    <div class="d-flex justify-content-evenly">
                        <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger btn-sm" id="submit-bet">Submit Bet</button>
                    </div>                                             
                </div>
            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div>
@section('pagescript')
    <script>
        $("#add-point").click(function(){
            let type = $("select[name='game_type']").val();
            let point = $('#point').val();
            let selectedValue = $('input[name="odd_even"]:checked').val();
            let html = '';
            let totalBid = 0; // Initialize total card count
            let totalPoints = 0; // Initialize total points

            if(point >= 5){
                if(selectedValue ==='odd'){
                    for (let i = 0; i <= 9; i++) {
                        if (i % 2 !== 0) { // Check if the number is odd
                            totalBid++; // Increment total card count
                            totalPoints += parseInt(point, 10); // Add the point value to total points
                            html += `<div class="card mb-1">
                                        <div class="card-body p-1">
                                            <div class="row">
                                                <div class="col-3 text-center">${i}</div>
                                                <div class="col-3 text-center">${point}</div>
                                                <div class="col-3 text-center">${type}</div>
                                                <div class="col-3 text-center text-danger"><i class="iconoir-trash trash-btn"></i></div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="game_no" name="game_no[${i}]" value="${point}">
                                    </div>`;
                        }
                    }
                }
                else
                {
                    for (let i = 0; i <= 9; i++) {
                        if (i % 2 === 0) { // Check if the number is odd
                            totalBid++; // Increment total card count
                            totalPoints += parseInt(point, 10); // Add the point value to total points
                            html += `<div class="card mb-1">
                                        <div class="card-body p-1">
                                            <div class="row">
                                                <div class="col-3 text-center">${i}</div>
                                                <div class="col-3 text-center">${point}</div>
                                                <div class="col-3 text-center">${type}</div>
                                                <div class="col-3 text-center text-danger"><i class="iconoir-trash trash-btn"></i></div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="game_no" name="game_no[${i}]" value="${point}">
                                    </div>`;
                        }
                    }
                }
                $('#total-bid').text(totalBid);
                $('#total-points').text(totalPoints);
                $('#bid-point').html(html);
            }else{
                Swal.fire({
                    title: "Please select at least one number min 5 point",
                    icon: "warning",
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-danger" // Add Bootstrap danger class
                    },
                    buttonsStyling: false // Disable SweetAlert2's default button styles
                });
            }
        });

        $(document).on('click', '.trash-btn', function(){
            let point = $(this).parents('.card').find('input').val();
            let totalBid = $('#total-bid').text() - 1;
            let totalPoints = $('#total-points').text() - point;
            // console.log(point);
            $(this).parents('.card').remove();
            $('#total-bid').text(totalBid);
            $('#total-points').text(totalPoints);
            
        });

        $(document).on('submit', "#bid-form", function(event){
            event.preventDefault();

            let wallet = '{{ $wallet }}';
            let totalpoints = 0;
            let totalBids = 0;
            let type = $("select[name='game_type']").val();
            let html = '';
            
            // Iterate through all inputs with the name "game_no[]".
            $(".game_no").each(function (index) {
                const nameAttr = $(this).attr("name"); // Get the name attribute
                const keyMatch = nameAttr.match(/\[([^\]]+)\]/); // Extract the key inside square brackets
                const key = keyMatch ? keyMatch[1] : null; // Get the key or null if not found

                const value = $(this).val();
                if (value >= 5) {
                    html +=`<div class="card mb-1">
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-4 text-center">${key}</div>
                                        <div class="col-4 text-center">${value}</div>
                                        <div class="col-4 text-center text-danger">${type}</div>
                                    </div>
                                </div>
                            </div>`;
                    totalpoints += parseInt(value);
                    totalBids++;
                }
            });
            
            html +=`<div class="row">
                        <div class="col-6 text-center">Total Bids: ${totalBids}</div>
                        <div class="col-6 text-center">Total Bid Amount: ${totalpoints}</div>
                    </div>`;
            html +=`<hr class="my-1">
                    <div class="row">
                        <div class="col-12 text-center">Wallet Balance Before Deduction: <i class="fas fa-indian-rupee-sign"></i> ${wallet}</div>
                        <div class="col-12 text-center">Wallet Balance After Deduction: <i class="fas fa-indian-rupee-sign"></i> ${(wallet - totalpoints).toFixed(2)}</div>
                        <div class="col-12 text-center text-danger my-1">*Note: Bid once played cannot be cancelled*</div>
                    </div>`;

            $('#bid-details').html(html);

            if(totalpoints <= wallet){
                if(totalBids > 0){
                    $('#confirmModal').modal('show');
                }else{
                    Swal.fire({
                        title: "Please select at least one number min 5 point",
                        icon: "warning",
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-danger" // Add Bootstrap danger class
                        },
                        buttonsStyling: false // Disable SweetAlert2's default button styles
                    });
                }
            }else{
                Swal.fire({
                    title: "You have no balance. Please recharge.",
                    icon: "error",
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-danger" // Add Bootstrap danger class
                    },
                    buttonsStyling: false // Disable SweetAlert2's default button styles
                });
            }
        });

        $('#submit-bet').click(function(){
            let url = $("#bid-form").attr('action');
            let data = new FormData($("#bid-form")[0]);
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
                                location.reload(); // Reloads the page after clicking "OK"
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