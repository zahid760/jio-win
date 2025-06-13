@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Bid History</h4>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Bet List</h4>                      
                        </div>
                        <div class="col-auto"> 
                            
                        </div>
                    </div>                              
                </div>

                <div class="card-body pt-0">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#matka" role="tab" aria-selected="true">Matka</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#satta" role="tab" aria-selected="false" tabindex="-1">Satta</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane py-1 active show" id="matka" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table  mb-0 table-centered table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Game Name</th>
                                            <th>Game Type</th>
                                            <th>Game Mode</th>
                                            <th>Digit</th>
                                            <th>Points</th>
                                            <th>Transaction</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($matka_bids as $data)
                                            @foreach($data->bidchild as $row)
                                                <tr>
                                                    <td>{{$data->game->name}}</td>
                                                    <td>{{$data->game_type}}</td>
                                                    <td>{{$data->gamemode->name}}</td>
                                                    <td>{{$row->game_number}}</td>
                                                    <td>{{$row->points}}</td>
                                                    <td>{{$row->created_at}}</td>
                                                    <td>
                                                        @if($row->status == 0)
                                                            Best of luck
                                                        @elseif($row->status == 1)
                                                            You win
                                                        @else
                                                            Better luck next time
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane py-1 active show" id="satta" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table  mb-0 table-centered table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Game Name</th>
                                            <th>Game Type</th>
                                            <th>Game Mode</th>
                                            <th>Digit</th>
                                            <th>Points</th>
                                            <th>Transaction</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($satta_bids as $data)
                                            @foreach($data->bidchild as $row)
                                                <tr>
                                                    <td>{{$data->game->name}}</td>
                                                    <td>{{$data->game_type}}</td>
                                                    <td>{{$data->gamemode->name}}</td>
                                                    <td>{{$row->game_number}}</td>
                                                    <td>{{$row->points}}</td>
                                                    <td>{{$row->created_at}}</td>
                                                    <td>
                                                        @if($row->status == 0)
                                                            Best of luck
                                                        @elseif($row->status == 1)
                                                            You win
                                                        @else
                                                            Better luck next time
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagescript')
    <script src="{{ secure_asset('assets/libs/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ secure_asset('assets/js/pages/datatable.init.js') }}"></script>
    <script>
        function validateDigitsOpen(input) {
            let first_value = 0, second_value = 0, third_value = 0;

            // Get the current input value as a string
            const value = input.value;

            // Check the length of the value and assign values accordingly
            if (value.length >= 1) {
                first_value = parseInt(value[0], 10); // First digit
            }
            if (value.length >= 2) {
                second_value = parseInt(value[1], 10); // Second digit
                if (first_value === 0 && second_value !=0) {
                    input.value = value.slice(0, 1); // Reset to the first digit if the condition fails
                    console.log("Second digit must be greater than the first digit.");
                    return;
                }
                if (second_value !=0 && second_value < first_value) {
                    input.value = value.slice(0, 1); // Reset to the first digit if the condition fails
                    console.log("Second digit must be greater than the first digit.");
                    return;
                }                
            }
            if (value.length === 3) {
                third_value = parseInt(value[2], 10); // Third digit
                if (second_value === 0 && third_value !=0) {
                    input.value = value.slice(0, 2); // Reset to the first digit if the condition fails
                    console.log("Third digit must be greater than the second digit.");
                    return;
                }
                if (third_value !=0 && third_value < second_value) {
                    input.value = value.slice(0, 2); // Reset to the first two digits if the condition fails
                    console.log("Third digit must be greater than the second digit.");
                    return;
                }
                $('.jodi').val((first_value+second_value+third_value) % 10);
            }
            // Remove any characters beyond 3 digits
            if (input.value.length > 3) {
                input.value = input.value.slice(0, 3);
            }
            // Ensure the number is between 100 and 999
            if (input.value < 100 || input.value > 999) {
                input.setCustomValidity("Please enter a 3-digit number between 100 and 999.");
            } else {
                input.setCustomValidity(""); // Clear error message
            }
        }

        function validateDigitsClose(input) {
            let first_value = 0, second_value = 0, third_value = 0;

            // Get the current input value as a string
            const value = input.value;

            // Check the length of the value and assign values accordingly
            if (value.length >= 1) {
                first_value = parseInt(value[0], 10); // First digit
            }
            if (value.length >= 2) {
                second_value = parseInt(value[1], 10); // Second digit
                if (first_value === 0 && second_value !=0) {
                    input.value = value.slice(0, 1); // Reset to the first digit if the condition fails
                    console.log("Second digit must be greater than the first digit.");
                    return;
                }
                if (second_value !=0 && second_value < first_value) {
                    input.value = value.slice(0, 1); // Reset to the first digit if the condition fails
                    console.log("Second digit must be greater than the first digit.");
                    return;
                }                
            }
            if (value.length === 3) {
                third_value = parseInt(value[2], 10); // Third digit
                if (second_value === 0 && third_value !=0) {
                    input.value = value.slice(0, 2); // Reset to the first digit if the condition fails
                    console.log("Third digit must be greater than the second digit.");
                    return;
                }
                if (third_value !=0 && third_value < second_value) {
                    input.value = value.slice(0, 2); // Reset to the first two digits if the condition fails
                    console.log("Third digit must be greater than the second digit.");
                    return;
                }
                let open_jodi = $('.jodi').val().slice(0, 1);
                $('.jodi').val(open_jodi + (first_value+second_value+third_value) % 10);
            }
            // Remove any characters beyond 3 digits
            if (input.value.length > 3) {
                input.value = input.value.slice(0, 3);
            }
            // Ensure the number is between 100 and 999
            if (input.value < 100 || input.value > 999) {
                input.setCustomValidity("Please enter a 3-digit number between 100 and 999.");
            } else {
                input.setCustomValidity(""); // Clear error message
            }
        }

        $(".game-result-form").on('submit', function(event){
            event.preventDefault();

            let modal = $(this).siblings('.modal-header').find('.btn-close');
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
                        modal.trigger('click');
                        toastr.success(response.message);
                        setTimeout(function(){
                            window.open(baseUrl+"/matka_game", '_self');
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