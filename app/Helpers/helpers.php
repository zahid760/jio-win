<?php

use Carbon\Carbon;

if (!function_exists('formatTime')) {
    function formatTime($time)
    {
        return date('h:i A', strtotime($time));
    }
}
