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
                            <h4 class="card-title">Rate List</h4>                      
                        </div>
                        <div class="col-auto"> 
                            <a href="{{ route('game_rate.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Add New Rate
                            </a>
                        </div>
                    </div>                              
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table datatable" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>Category</th>
                                    <th>Game Mode</th>
                                    <th>Bidding Rate</th>
                                    <th>Winning Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                    <tr id="listrow{{$row->id}}">
                                        <td>{{ $row->category }}</td>
                                        <td>{{ $row->game_mode->name }}</td>
                                        <td>{{ $row->bidding_rate }}</td>
                                        <td>{{ $row->winning_rate }}</td>
                                        <td>
                                            <a href="{{ route('game_rate.edit', $row->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="las la-pen text-secondary fs-18"></i></a>
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete" onclick="delete_func('{{ route('game_rate.destroy', $row->id) }}')"><i class="las la-trash-alt text-secondary fs-18"></i></a>
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
