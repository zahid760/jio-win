@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Satta Game</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Game Create</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <form action="{{ route('satta_game.store') }}" method="post" id="satta-game-form" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row g-2">
                            <input type="hidden" name="category" value="satta">
                            <div class="col-md-4">
                                <label>Game Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Game Name" required>
                            </div>
                        
                            <div class="col-md-4">
                                <label>Priority <span class="text-danger">*</span></label>
                                <select name="priority" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="primary">Primary</option>
                                    <option value="secondary">Secondary</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Open Time <span class="text-danger">*</span></label>
                                <input type="time" name="open_time" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label>Make Special Game</label>
                                <select name="spl" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="1">Special</option>
                                </select>
                            </div>
                        
                            <div class="col-md-12">
                                <label class="form-label permission-label">Closing Days:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="closing_days[]" id="Sunday" value="Sunday">
                                    <label class="form-check-label" for="Sunday">Sunday</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="closing_days[]" id="Monday" value="Monday">
                                    <label class="form-check-label" for="Monday">Monday</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="closing_days[]" id="Tuesday" value="Tuesday">
                                    <label class="form-check-label" for="Tuesday">Tuesday</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="closing_days[]" id="Wednesday" value="Wednesday">
                                    <label class="form-check-label" for="Wednesday">Wednesday</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="closing_days[]" id="Thursday" value="Thursday">
                                    <label class="form-check-label" for="Thursday">Thursday</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="closing_days[]" id="Friday" value="Friday">
                                    <label class="form-check-label" for="Friday">Friday</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="closing_days[]" id="Saturday" value="Saturday">
                                    <label class="form-check-label" for="Saturday">Saturday</label>
                                </div>
                            </div>

                            <div class="col-lg-12">
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
        $("#satta-game-form").on('submit', function(event){
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
                beforeSend: function() {
                    $('#loader').show();
                    $('.btnsave').prop('disabled', true);
                },                
                success: function(response) {
                    $('#loader').hide();
                    $('.btnsave').prop('disabled', false);

                    if(response.status == 'success'){
                        toastr.success(response.message);
                        setTimeout(function(){
                            window.open(baseUrl+"/satta_game", '_self');
                        }, 1000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#loader').hide();
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