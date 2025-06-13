@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Matka Game</h4>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Game List</h4>                      
                        </div>
                        <div class="col-auto"> 
                            <a href="{{ route('matka_game.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Add New Game
                            </a>
                        </div>
                    </div>                              
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table datatable" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Priority</th>
                                    <th data-type="time" data-format="HH:mm">Open Time</th>
                                    <th data-type="time" data-format="HH:mm">Close Time</th>
                                    <th>Result</th>
                                    <th>Closing Days</th>
                                    <th>Game Type</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $current_time = \Carbon\Carbon::now();
                                    $close_time_spl = \Carbon\Carbon::parse('00:00:00');
                                @endphp
                                @foreach($data as $row)
                                    @php
                                        $close_time_spl_game = \Carbon\Carbon::parse($row->close_time)->addHour();
                                    @endphp 
                                    <tr id="listrow{{$row->id}}">
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->priority }}</td>
                                        <td>{{ formatTime($row->open_time) }}</td>
                                        <td>{{ formatTime($row->close_time) }}</td>
                                        <td>
                                            @if($row->spl == 1 && $current_time > $close_time_spl && $current_time < $close_time_spl_game)
                                                {{ $row->result_spl->open ?? '***' }}-{{ strlen($row->result_spl->jodi ?? '') === 1 ? $row->result_spl->jodi . '*' : ($row->result_spl->jodi ?? '**') }}-{{ $row->result_spl->close ?? '***' }}
                                            @else
                                                {{ $row->result->open ?? '***' }}-{{ strlen($row->result->jodi ?? '') === 1 ? $row->result->jodi . '*' : ($row->result->jodi ?? '**') }}-{{ $row->result->close ?? '***' }}
                                            @endif
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addResult{{$row->id}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Result"><i class="fas fa-plus-circle"></i></a>
                                            <div class="modal fade" id="addResult{{$row->id}}" tabindex="-1" aria-labelledby="addResultLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addResultLabel">{{ $row->name }} Result</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('game_result.store') }}" method="post" class="game-result-form">
                                                            @csrf
                                                            @method('POST')
                                                            <div class="modal-body">                                                            
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="mb-2">
                                                                            <label>Date</label> 
                                                                            <input type="date" name="result_date" class="form-control result_date" data-gameid="{{ $row->id }}" value="{{ date('Y-m-d') }}" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="mb-2">
                                                                            <label>Open</label> 
                                                                            <input type="number" name="open" class="form-control" value="{{ $row->result->open ?? '' }}" max="999" maxlength="3" oninput="validateDigitsOpen(this)" {{ !empty($row->result->open) ? 'readonly' : '' }} required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="mb-2">
                                                                            <label>Jodi</label> 
                                                                            <input type="text" name="jodi" class="form-control jodi" value="{{ $row->result->jodi ?? '' }}" readonly required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="mb-2">
                                                                            <label>Close</label> 
                                                                            <input type="number" name="close" class="form-control" value="{{ $row->result->close ?? '' }}" max="999" maxlength="3" oninput="validateDigitsClose(this)" {{ !empty($row->result->open) ? '' : 'readonly' }}>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="game_id" value="{{ $row->id }}">
                                                                    <input type="hidden" name="result_id" value="{{ $row->result->id ?? '' }}">
                                                                </div>           
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary w-100 btnsave">Add Result</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ !empty($row->closing_days) ? (is_array($decodedDays = json_decode($row->closing_days, true)) ? implode(', ', $decodedDays) : '') : '' }}</td>
                                        <td>{{ $row->spl == 1 ? 'Special' : '' }}</td>
                                        <td>{{ $row->user->name }}</td>
                                        <td>
                                            <a href="{{ route('matka.game.panel.chart', $row->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Panel Chart"><i class="las la-chart-line text-secondary fs-18"></i></a>
                                            <a href="{{ route('matka.game.jodi.chart', $row->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Jodi Chart"><i class="las la-chart-bar text-secondary fs-18"></i></a>
                                            <a href="{{ route('matka.game.bid', $row->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Bid History"><i class="las la-gavel text-secondary fs-18"></i></a>
                                            <a href="{{ route('matka_game.edit', $row->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="las la-pen text-secondary fs-18"></i></a>
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete" onclick="delete_func('{{ route('matka_game.destroy', $row->id) }}')"><i class="las la-trash-alt text-secondary fs-18"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                $(input).closest('form').find('.jodi').val((first_value+second_value+third_value) % 10);
            }
            // Remove any characters beyond 3 digits
            if (input.value.length > 3) {
                input.value = input.value.slice(0, 3);
            }
            // Ensure the number is between 100 and 999
            if (input.value > 999) {
                input.setCustomValidity("Please enter a 3-digit number between 0 and 999.");
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
                let open_jodi = $(input).closest('form').find('.jodi').val();
                if (open_jodi) {
                    open_jodi = open_jodi.toString().slice(0, 1); // Convert to string and get the first character
                }
                $(input).closest('form').find('.jodi').val(open_jodi + (first_value+second_value+third_value) % 10);
            }
            // Remove any characters beyond 3 digits
            if (input.value.length > 3) {
                input.value = input.value.slice(0, 3);
            }
            // Ensure the number is between 100 and 999
            if (input.value > 999) {
                input.setCustomValidity("Please enter a 3-digit number between 0 and 999.");
            } else {
                input.setCustomValidity(""); // Clear error message
            }
        }

        $(document).on('change', '.result_date', function(){
            const self = $(this);
            let result_date = self.val();
            let game_id = self.attr('data-gameid');
            // console.log(game_id);
            $.ajax({
                url: baseUrl+'/game_result_by_date', // Set the URL to your server endpoint
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery("meta[name='csrf-token']").attr('content')
                },
                data:{
                    result_date:result_date,
                    game_id:game_id,
                },
                beforeSend: function() {
                    $('#loader').show();
                    $('.btnsave').prop('disabled', true);
                },                
                success: function(response) {
                    $('#loader').hide();
                    $('.btnsave').prop('disabled', false);

                    if(response.status == 'success'){
                        self.closest('.row').find('[name="open"]').val(response.open);
                        self.closest('.row').find('[name="jodi"]').val(response.jodi);
                        let closeInput = self.closest('.row').find('[name="close"]');
                        closeInput.val(response.close);
                        if (response.open !== '') {
                            closeInput.removeAttr('readonly'); // Remove readonly if open has a value
                            self.closest('.row').find('[name="result_id"]').val(response.result_id);
                        } else {
                            closeInput.attr('readonly', true); // Add readonly if open is empty
                        }
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

        $(document).on('submit', '.game-result-form', function(event){
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