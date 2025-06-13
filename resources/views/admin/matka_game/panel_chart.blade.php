@extends('admin.main')
@section('title', 'Jio Win')
@section('pagecontent')
<style>
    tbody tr td:nth-child(2), tbody tr td:nth-child(5), tbody tr td:nth-child(8), tbody tr td:nth-child(11), tbody tr td:nth-child(14), tbody tr td:nth-child(17), tbody tr td:nth-child(20), tbody tr td:nth-child(23) {
        border-right-width: 0px;
        font-size: 13px;
    }
    tbody tr td:nth-child(3), tbody tr td:nth-child(6), tbody tr td:nth-child(9), tbody tr td:nth-child(12), tbody tr td:nth-child(15), tbody tr td:nth-child(18), tbody tr td:nth-child(21), tbody tr td:nth-child(24), tbody tr td:nth-child(27) {
        border-left-width: 0px;
        border-right-width: 0px;
        font-size: 23px;
    }
    tbody tr td:nth-child(4), tbody tr td:nth-child(7), tbody tr td:nth-child(10), tbody tr td:nth-child(13), tbody tr td:nth-child(16), tbody tr td:nth-child(19), tbody tr td:nth-child(22), tbody tr td:nth-child(25), tbody tr td:nth-child(28) {
        border-left-width: 0px;
        font-size: 13px;
    }
    .vertical-text {
        writing-mode: vertical-rl; /* Rotate text vertically */
        transform: rotate(180deg); /* Optional: make it upright instead of upside down */
        text-align: center;
        white-space: nowrap;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Panel Chart</h4>
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
                        $grouped = collect($panel_chart)->groupBy(function($item) {
                            return Carbon::parse($item->result_date)->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
                        });
                    @endphp

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th colspan="3">Mon</th>
                                <th colspan="3">Tue</th>
                                <th colspan="3">Wed</th>
                                <th colspan="3">Thu</th>
                                <th colspan="3">Fri</th>
                                <th colspan="3">Sat</th>
                                <th colspan="3">Sun</th>
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
                                            <td>{!! isset($data->open) ? nl2br(implode("\n", str_split($data->open))) : '***' !!}</td>
                                            <td>{{ $data->jodi ?? '**' }}</td>
                                            <td>{!! isset($data->close) ? nl2br(implode("\n", str_split($data->close))) : '***' !!}</td>
                                        @else
                                            <td class="vertical-text">***</td><td>**</td><td class="vertical-text">***</td>
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