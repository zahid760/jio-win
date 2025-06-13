@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Withdraw Request List</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatable" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Name</th>
                                    <th>A/c No.</th>
                                    <th>IFSC</th>
                                    <th>Bank</th>
                                    <th>UPI ID</th>
                                    <th>Transaction Id</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                    <tr id="listrow{{$row->id}}">
                                        <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $row->amount }}</td>
                                        <td>{{ $row->bankDetails->name ?? '' }}</td>
                                        <td>{{ $row->bankDetails->account_number ?? '' }}</td>
                                        <td>{{ $row->bankDetails->ifsc ?? '' }}</td>
                                        <td>{{ $row->bankDetails->bank_name ?? '' }}</td>
                                        <td>{{ $row->bankDetails->upi_id ?? '' }}</td>
                                        <td>{{ $row->transaction_id ?? '' }}</td>
                                        <td>
                                            @if($row->status === 0)
                                            <span class="badge rounded-pill bg-warning-subtle text-warning">Pending</span>
                                            @elseif($row->status === 1)
                                            <span class="badge rounded-pill bg-success-subtle text-success">Approved</span>
                                            @else
                                            <span class="badge rounded-pill bg-danger-subtle text-danger">Reject</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown d-inline-block">
                                                <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                    <i class="las la-ellipsis-v fs-20 text-muted"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                                    @if($row->status == 0)
                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addResult{{$row->id}}" role="button">Approved</a>
                                                    <form action="{{ route('withdraw.status') }}" method="post" class="withdraw-status-form">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="2">
                                                        <input type="hidden" name="id" value="{{$row->id}}">
                                                        <button type="submit" class="dropdown-item status-btn" role="button">Reject</button>
                                                    </form>
                                                    @else
                                                    <a class="dropdown-item">Already Updated</a>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="modal fade" id="addResult{{$row->id}}" tabindex="-1" aria-labelledby="addResultLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addResultLabel">Add Transaction Id</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('withdraw.status') }}" method="post" class="withdraw-status-form">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="status" value="1">
                                                            <input type="hidden" name="id" value="{{$row->id}}">
                                                            <div class="modal-body">                                                            
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="">
                                                                            <input type="text" name="transaction_id" class="form-control" placeholder="Transaction Id" required>
                                                                        </div>
                                                                    </div>
                                                                </div>           
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary w-100 btnsave">Approved Withdrawl</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
    $(".withdraw-status-form").on('submit', function (event) {
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
                $('.btnsave').prop('disabled', true);
            }, 
            success: function (response) {
                $('.btnsave').prop('disabled', false);

                if (response.status == 'success') {
                    toastr.success(response.message);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
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
