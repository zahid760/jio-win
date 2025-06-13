@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Jodi Chart</h4>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">{{$game->name}}</h4>                      
                        </div>
                        <div class="col-auto"> 
                            
                        </div>
                    </div>                              
                </div>

                <div class="card-body pt-0">
                    @php
                        use Carbon\Carbon;

                        $startDate = Carbon::create(2024, 12, 23)->startOfWeek(Carbon::MONDAY);
                        $endDate = Carbon::now()->endOfWeek(Carbon::SUNDAY);

                        $weeks = [];

                        // Generate week ranges
                        while ($startDate->lte($endDate)) {
                            $weeks[] = [
                                'start' => $startDate->copy(),
                                'end' => $startDate->copy()->endOfWeek(Carbon::SUNDAY),
                            ];
                            $startDate->addWeek();
                        }

                        // Group your existing $panel_chart data by week start
                        $grouped = collect($jodi_chart)->groupBy(function($item) {
                            return Carbon::parse($item->result_date)->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
                        });
                    @endphp

                    <table class="table table-bordered mt-3 text-center">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                                <th>Sun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($weeks as $week)
                                @php
                                    $weekStart = $week['start']->format('Y-m-d');
                                    $startFormatted = $week['start']->format('d-m-Y');
                                    $endFormatted = $week['end']->format('d-m-Y');

                                    $days = $grouped->get($weekStart, collect());

                                    // Map the day name to its data (lowercase)
                                    $dayMap = $days->keyBy(function($item) {
                                        return strtolower(Carbon::parse($item->result_date)->format('D')); // mon, tue, etc.
                                    });
                                @endphp
                                <tr>
                                    <td class="text-nowrap text-center">{{ $startFormatted }}<br>To<br>{{ $endFormatted }}</td>

                                    @foreach(['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'] as $day)
                                        @php
                                            $data = $dayMap->get($day);
                                        @endphp
                                        @if($data)
                                            <td>{{ $data->jodi ?? '**' }}</td>
                                        @else
                                            <td>**</td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

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