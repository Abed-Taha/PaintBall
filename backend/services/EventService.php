<?php

require_once  __DIR__ . "/../../env/host.php";
require_once  __DIR__ . "/../../env/host.php";
require_once __DIR__ . "/MapService.php";


class EventService
{

    public static function getEventById(?int $eventId = null)
    {
        if ($eventId === null) {
            return null;
        }

        $event = \DB::table("events")
            ->where("id", $eventId)
            ->first();

        if ($event === null) {
            return null;
        }

        $event["map"] = MapService::getMapById($event["map_id"]);

        $event["status"] = $event["start_date"] > date("Y-m-d")
            ? "<u>upcoming on:</u> " . $event["start_date"]
            : "<u>ongoing on:</u> " . $event["start_date"];

        return $event;
    }
}
