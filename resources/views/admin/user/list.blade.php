@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">User</h4>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">User List</h4>                      
                        </div>
                        <div class="col-auto"> 
                            <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Add New User
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
                                    <th>Mobile</th>
                                    <th>Wallet Amount</th>
                                    <th>Bonus</th>
                                    <th>Winning Amount</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                    <tr id="listrow{{$row->id}}">
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->mobile }}</td>
                                        <td>
                                            {{ $row->deposite_wallet }}
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addTransaction{{$row->id}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Transaction"><i class="fas fa-plus-circle"></i></a>
                                            <div class="modal fade" id="addTransaction{{$row->id}}" tabindex="-1" aria-labelledby="addTransactionLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addTransactionLabel">{{ $row->name }} Transaction</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('user.manual.payment') }}" method="post" class="transaction-form">
                                                            @csrf
                                                            @method('POST')
                                                            <div class="modal-body">                                                            
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="mb-2">
                                                                            <label>Transaction Id</label> 
                                                                            <input type="text" name="transaction_id" class="form-control" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="mb-2">
                                                                            <label>Amount</label> 
                                                                            <input type="number" name="amount" class="form-control" required>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="userid" value="{{ $row->id }}">
                                                                </div>           
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary w-100 btnsave">Add Transaction</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $row->bonus_wallet }}</td>
                                        <td>{{ $row->winning_wallet }}</td>
                                        <td>{{ $row->createdBy->name ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('user.history', $row->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Bid History"><i class="las la-gavel text-secondary fs-18"></i></a>
                                            <a href="{{ route('user.edit', $row->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="las la-pen text-secondary fs-18"></i></a>
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete" onclick="delete_func('{{ route('user.destroy', $row->id) }}')"><i class="las la-trash-alt text-secondary fs-18"></i></a>
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
        $(document).on('submit', '.transaction-form', function(event){
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
                            window.open(baseUrl+"/user", '_self');
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