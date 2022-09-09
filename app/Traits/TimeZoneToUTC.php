<?php

namespace App\Traits;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

trait TimeZoneToUTC
{
    public function  TimeZoneToUTC($dateTune, $zone){
        $dateTime = $dateTune;
        $tz_from = $zone;
        $newDateTime = new DateTime($dateTime, new DateTimeZone($tz_from));
        $newDateTime->setTimezone(new DateTimeZone("UTC"));
        $dateTimeUTC = $newDateTime->format("Y-m-d H:i:s");
        return $dateTimeUTC;
    }
    public function  TimeZoneToLocal($dateTune, $zone){
        $dateTime = $dateTune;
        $tz_from = 'UTC';
        $newDateTime = new DateTime($dateTime, new DateTimeZone($tz_from));
        $newDateTime->setTimezone(new DateTimeZone($zone));
        $dateTimeUTC = $newDateTime->format("Y-m-d H:i:s");
        return $dateTimeUTC;
    }
}
