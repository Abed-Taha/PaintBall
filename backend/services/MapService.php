<?php


class MapService
{
    public static function getMapById(?int $mapId = null)
    {
        if ($mapId === null) {
            return null;
        }

        $map = \DB::table("maps")
            ->where("id", $mapId)
            ->first() ?? null;

        if ($map === null) {
            return null;
        }

        return $map;
    }
}
