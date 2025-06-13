@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Game Rate</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Game Rate Create</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <form action="{{ route('game_rate.store') }}" method="post" id="game-form">
                        @csrf
                        @method('POST')
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label for="gameCategory" class="form-label">Select Game Categories <span class="text-danger">*</span></label>
                                <select name="category" class="form-select" id="gameCategory" required="">
                                    <option value="">Select a category</option>
                                    <option value="matka">Matka</option>
                                    <option value="satta">Satta</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="gameMode" class="form-label">Select Game Mode <span class="text-danger">*</span></label>
                                <select name="gamemode" class="form-select" id="gameMode" required="">
                                    <option value="">-- Select --</option>
                                    @foreach($game_mode as $row)
                                    <option value="{{$row->id}}">{{$row->name}} - ({{$row->category}})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="bidingRate" class="form-label">Biding Rate <span class="text-danger">*</span></label>
                                <input type="text" name="bidding_rate" class="form-control" id="bidingRate" placeholder="Enter Biding Rate" required="">
                            </div>
                            <div class="col-md-6">
                                <label for="winningRate" class="form-label">Winning Rate <span class="text-danger">*</span></label>
                                <input type="text" name="winning_rate" class="form-control" id="winningRate" placeholder="Enter Winning Rate" required="">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btnsave">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="loader" style="display:none;">
                    <div class="spinner-grow text-primary m-1" role="status" style="width:10rem; height:10rem;">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagescript')
<script>
    $("#game-form").on('submit', function (event) {
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
            success: function (response) {
                $('#loader').hide();
                $('.btnsave').prop('disabled', false);

                if (response.status == 'success') {
                    toastr.success(response.message);
                    setTimeout(function () {
                        window.open(baseUrl + "/game_rate", '_self');
                    }, 1000);
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
@endsection
