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