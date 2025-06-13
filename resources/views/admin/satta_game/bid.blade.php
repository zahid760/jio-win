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
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Bet List</h4>                      
                        </div>
                        <div class="col-auto"> 
                            <form action="{{route('satta.game.bid', $game_id)}}" method="get">
                                <div class="d-flex">
                                    <input type="date" name="date-filter" class="form-control" id="date-filter" value="{{date('Y-m-d', strtotime($date_filter))}}">
                                    <button type="submit" class="btn btn-primary ms-2">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>                              
                </div>

                <div class="card-body pt-0">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#open" role="tab" aria-selected="true">Open</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane py-1 active show" id="open" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table  mb-0 table-centered table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            @foreach($game_mode as $row)
                                                <th class="p-1">{{$row->name}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach($game_mode as $row)
                                                <td class="p-1 align-top">
                                                    <table class="table mb-0 table-centered table-bordered">
                                                        <tr>
                                                            <td class="p-1 text-danger">Users :
                                                                @foreach($totalusersByGame as $keyid => $user)
                                                                    @if($row->id === $keyid)
                                                                        {{$user ?? 0}}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td class="p-1 text-success">Profit :
                                                                @foreach($totalpointsByGame as $keyid => $point)
                                                                    @if($row->id === $keyid)
                                                                        {{$point ?? 0}}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        <tr class="table-light">
                                                            <td class="p-1">Game No.</td>
                                                            <td class="p-1">Point</td>
                                                        </tr>
                                                        @foreach($bid_no as $keyid => $bid)
                                                            @if($row->id === $keyid)
                                                                @foreach($bid as $keyno => $bidpoint)
                                                                <tr>
                                                                    <td class="p-1">{{$bidpoint['game_number']}}</td>
                                                                    <td class="p-1">{{$bidpoint['total_points']}}</td>
                                                                </tr>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </table>
                                                </td>
                                            @endforeach
                                        </tr>
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
@endsection