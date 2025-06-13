@section('title', 'Single Digit')
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
                    <a href="{{ route('game.mode', $game->id) }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-center text-white text-uppercase">
                    {{ $game->name }} - Single Digit
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
                            <form action="{{ route('single.digit.store') }}" method="POST" id="single-digit-special-form">
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
                                </div>

                                <div class="row gy-2 my-2">
                                    @for ($i = 0; $i <= 9; $i++)
                                        <div class="col-6">
                                            <div class="input-group">
                                                <div class="input-group-text bg-danger text-white">{{ $i }}</div>
                                                <input type="number" class="form-control" name="game_no[]">
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-danger w-100 btnsave">Submit</button>
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
        $("#single-digit-special-form").on('submit', function(event){
            event.preventDefault();

            let wallet = '{{ $wallet }}';
            let totalpoints = 0;
            let totalBids = 0;
            let type = $("select[name='game_type']").val();
            let html = '';

            // Iterate through all inputs with the name "game_no[]".
            $("input[name='game_no[]']").each(function (index) {
                // console.log(index);
                const value = $(this).val();
                if (value >= 5) {
                    // console.log(index);
                    html +=`<div class="card mb-1">
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-4 text-center">${index}</div>
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
            let url = $("#single-digit-special-form").attr('action');
            let data = new FormData($("#single-digit-special-form")[0]);
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