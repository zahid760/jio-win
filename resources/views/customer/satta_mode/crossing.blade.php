@section('title', 'Jodi')
@include('customer.includes.header')
<style>
    .nav-pills .nav-link {
        background-color: var(--bs-danger);
        color:#fff;
    }
    .nav-pills .nav-link.active {
        background-color: var(--bs-dark);
    }
</style>
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('satta.game.mode', $game->id) }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-center text-white text-uppercase">
                    {{ $game->name }} - Crossing
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
                    <ul class="nav nav-pills nav-justified gap-3" role="tablist">
                        <li class="nav-item waves-effect waves-light" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#easy-mode" role="tab" aria-selected="true">Easy Mode</a>
                        </li>
                        <li class="nav-item waves-effect waves-light" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#special-mode" role="tab" aria-selected="false" tabindex="-1">Special Mode</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane p-3" id="easy-mode" role="tabpanel">
                            <p class="text-muted mb-0">
                                Commingsoon
                            </p>
                        </div>
                        <div class="tab-pane p-3 active show" id="special-mode" role="tabpanel">
                            <form action="{{ route('satta.jodi.store') }}" method="POST" id="jodi-special-form">
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
                                        <select name="game_type" class="form-select d-none">
                                            <option value="open">Open</option>
                                        </select>

                                        <select name="game_mode" class="form-select">
                                            <option value="19">Crossing</option>
                                            <option value="20">Cut Crossing</option>
                                        </select>
                                    </div>
                                    
                                </div>

                                <div class="d-flex justify-content-evenly my-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jodi_maker" id="0" value="0">
                                        <label class="form-check-label" for="0">0</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jodi_maker" id="1" value="1">
                                        <label class="form-check-label" for="1">1</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jodi_maker" id="2" value="2">
                                        <label class="form-check-label" for="2">2</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jodi_maker" id="3" value="3">
                                        <label class="form-check-label" for="3">3</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jodi_maker" id="4" value="4">
                                        <label class="form-check-label" for="4">4</label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-evenly my-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jodi_maker" id="5" value="5">
                                        <label class="form-check-label" for="5">5</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jodi_maker" id="6" value="6">
                                        <label class="form-check-label" for="6">6</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jodi_maker" id="7" value="7">
                                        <label class="form-check-label" for="7">7</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jodi_maker" id="8" value="8">
                                        <label class="form-check-label" for="8">8</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jodi_maker" id="9" value="9">
                                        <label class="form-check-label" for="9">9</label>
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
                                            <div class="col-4 text-center">Ank</div>
                                            <div class="col-4 text-center">Point</div>
                                            <div class="col-4 text-center">Delete</div>
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
                        <div class="col-6 text-center">Digit</div>
                        <div class="col-6 text-center">Point</div>
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
            let gameMode = $("select[name='game_mode']").val();
            let point = $('#point').val();
            let selectedNumbers = $('input[name="jodi_maker"]:checked').map(function() {
                return $(this).val();
            }).get();

            let html = '';
            let totalBid = 0; 
            let totalPoints = 0; 

            if (point >= 1) {
                let jodiPairs = [];

                // Generate jodi pairs (including self-pairing)
                for (let i = 0; i < selectedNumbers.length; i++) {
                    for (let j = 0; j < selectedNumbers.length; j++) {
                        if (gameMode == 20 && selectedNumbers[i] == selectedNumbers[j]) {
                            // Skip self-pairing when gameMode is 20
                            continue;
                        }
                        jodiPairs.push(selectedNumbers[i] + selectedNumbers[j]); // Create two-digit pair
                    }
                }

                jodiPairs.forEach(jodi => {
                    totalBid++; 
                    totalPoints += parseInt(point, 10);

                    html += `<div class="card mb-1">
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-4 text-center">${jodi}</div>
                                        <div class="col-4 text-center">${point}</div>
                                        <div class="col-4 text-center text-danger"><i class="iconoir-trash trash-btn"></i></div>
                                    </div>
                                </div>
                                <input type="hidden" class="game_no" name="game_no[${jodi}]" value="${point}">
                            </div>`;
                });

                $('#total-bid').text(totalBid);
                $('#total-points').text(totalPoints);
                $('#bid-point').html(html);
            } else {
                Swal.fire({
                    title: "Please select at least one number with min 1 point",
                    icon: "warning",
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    },
                    buttonsStyling: false
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

        $("#jodi-special-form").on('submit', function(event){
            event.preventDefault();

            let wallet = '{{ $wallet }}';
            let totalpoints = 0;
            let totalBids = 0;
            let type = $("select[name='game_type']").val();
            let html = '';
            let rowhtml = '';

            // Iterate through all inputs with the name "game_no[]".
            $(".game_no").map(function (index) {
                const nameAttr = $(this).attr("name"); // Get the name attribute
                const keyMatch = nameAttr.match(/\[([^\]]+)\]/); // Extract the key inside square brackets
                const key = keyMatch ? keyMatch[1] : null; // Get the key or null if not found

                const value = $(this).val();
                if (value >= 1) {
                    rowhtml +=`<div class="card mb-1">
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-6 text-center">${key.toString().padStart(2, '0')}</div>
                                        <div class="col-6 text-center">${value}</div>
                                    </div>
                                </div>
                            </div>`;
                    totalpoints += parseInt(value);
                    totalBids++;
                }
            });

            html += `<div class="bidrow">${rowhtml}</div>`;

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
                        title: "Please select at least one number min 1 point",
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
            let url = $("#jodi-special-form").attr('action');
            let data = new FormData($("#jodi-special-form")[0]);
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
                        // toastr.success(response.message);
                        // setTimeout(function(){
                            // window.open(baseUrl+"/matka_game", '_self');
                        // }, 1000);
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