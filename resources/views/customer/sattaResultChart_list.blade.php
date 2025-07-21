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
    $grouped = collect($result_chart)->groupBy(function($item) {
        return Carbon::parse($item->result_date)->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
    });
@endphp

<table class="table table-bordered mt-3 text-center" style="border: 1px dotted #000;">
    <thead>
        <tr class="bg-danger text-center">
            <th style="color: aliceblue;">Date</th>
            <th style="color: aliceblue;">Mon</th>
            <th style="color: aliceblue;">Tue</th>
            <th style="color: aliceblue;">Wed</th>
            <th style="color: aliceblue;">Thu</th>
            <th style="color: aliceblue;">Fri</th>
            <th style="color: aliceblue;">Sat</th>
            <th style="color: aliceblue;">Sun</th>
        </tr>
    </thead>
    <tbody style="background-color: #fc9;">
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
                        <td class="" style="border: 1px dotted #000;">{{ $data->open ?? '**' }}</td>
                    @else
                        <td style="border: 1px dotted #000;">**</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>