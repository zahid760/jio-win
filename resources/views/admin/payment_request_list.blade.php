@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Payment Request List</h4>
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
                                    <th>Name</th>
                                    <th>Transaction Id</th>
                                    <th>Amount</th>
                                    <th>Comment</th>
                                    <th>screenshot</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                    <tr id="listrow{{$row->id}}">
                                        <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $row->user->name }}</td>
                                        <td>{{ $row->transaction_id }}</td>
                                        <td>{{ $row->amount }}</td>
                                        <td>{{ $row->comment }}</td>
                                        <td>
                                            <img src="{{secure_asset($row->reciept_photo)}}" width="100" alt="">
                                        </td>
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
                                                    <a class="dropdown-item status-btn" data-status="1" data-id="{{$row->id}}" data-url="{{route('payment.status')}}" role="button">Approved</a>
                                                    <a class="dropdown-item status-btn" data-status="2" data-id="{{$row->id}}" data-url="{{route('payment.status')}}" role="button">Reject</a>
                                                    @else
                                                    <a class="dropdown-item">Already Updated</a>
                                                    @endif
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
    $(".status-btn").on('click', function (event) {
        event.preventDefault();

        let url = jQuery(this).attr('data-url');
        let status = jQuery(this).attr('data-status');
        let id = jQuery(this).attr('data-id');

        $.ajax({
            url: url, // Set the URL to your server endpoint
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Use meta tag for CSRF
            },
            data: {
                status:status,
                id:id
            },
            success: function (response) {

                if (response.status == 'success') {
                    toastr.success(response.message);
                    setTimeout(function () {
                        location.reload();
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
