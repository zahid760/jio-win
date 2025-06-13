@section('title', 'Triple Pana')
@include('customer.includes.header')
<style>
    .input-group-text{
        width: 33%;
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
                    {{ $game->name }} - Triple Pana
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
                    <form action="{{ route('triple.pana.store') }}" method="POST" id="bid-form">
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

                        <div class="row gy-1 my-1">
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text bg-danger text-white">000</div>
                                    <input type="number" class="form-control game_no" name="game_no[000]">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text bg-danger text-white">111</div>
                                    <input type="number" class="form-control game_no" name="game_no[111]">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text bg-danger text-white">222</div>
                                    <input type="number" class="form-control game_no" name="game_no[222]">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text bg-danger text-white">333</div>
                                    <input type="number" class="form-control game_no" name="game_no[333]">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text bg-danger text-white">444</div>
                                    <input type="number" class="form-control game_no" name="game_no[444]">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text bg-danger text-white">555</div>
                                    <input type="number" class="form-control game_no" name="game_no[555]">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text bg-danger text-white">666</div>
                                    <input type="number" class="form-control game_no" name="game_no[666]">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text bg-danger text-white">777</div>
                                    <input type="number" class="form-control game_no" name="game_no[777]">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text bg-danger text-white">888</div>
                                    <input type="number" class="form-control game_no" name="game_no[888]">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text bg-danger text-white">999</div>
                                    <input type="number" class="form-control game_no" name="game_no[999]">
                                </div>
                            </div>
                        </div>

                        <div class="row sticky-bottom">
                            <div class="col-12">
                                <button type="submit" class="btn btn-danger w-100 btnsave">Submit</button>
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
        $("#bid-form").on('submit', function(event){
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
                // console.log(key);
                const value = $(this).val();
                if (value >= 5) {
                    rowhtml +=`<div class="card mb-1">
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
                    // console.log(response);
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