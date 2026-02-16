<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/env/host.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/env/DTO.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/backend/services/MapService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/backend/services/TeamService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/backend/services/UserService.php";



class GamesService
{

    public static function getGamesReservationById(?int $id = null)
    {
        if ($id === null) {
            return null;
        }
        $game = \DB::select("game_reservations")
            ->where("id", $id)
            ->first() ?? null;

        if ($game === null) {
            return null;
        }
        $game["games"] = self::getGamesById($game["game_id"]);
        unset($game["game_id"]);
        $game["map"] = MapService::getMapById($game["map_id"]);
        unset($game["map_id"]);
        $game["team"] = TeamService::getTeamById($game["team_id"]);
        unset($game["team_id"]);


        return $game;
    }
    public static function getGamesById(?int $id = null)
    {
        if ($id === null) {
            return null;
        }
        $game = \DB::table("games")
            ->where("id", $id)
            ->first() ?? null;

        if ($game === null) {
            return null;
        }
        $game["team"] = TeamService::getTeamById($game["team_id"]);
        unset($game["team_id"]);
        $game["opponent"] = TeamService::getTeamById($game["opponent_id"]);
        unset($game["opponent_id"]);
        $game["instructor"] = UserService::getInstInfo($game["instructor_id"]);
        unset($game["instructor_id"]);
        $game["bundel"] = self::getBundelId($game["bundel_id"]);
        unset($game["bundel_id"]);
        return $game;
    }

    public static function getBundelId(?int $id = null)
    {


        if ($id === null) {
            return null;
        }

        $bundel = \DB::select("bundels")
            ->where("id", $id)
            ->first();

        if ($bundel === null) {
            return null;
        }
        $guns_id = \DB::select("bundel_gun")
            ->where("bundel_id", $id)
            ->get();
        $bundel["guns"] = array();
        foreach ($guns_id as $i) {
            array_push($bundel["guns"],  self::getGunById($i["gun_id"]));
        }

        return $bundel;
    }
    public static function getGunById(?int $id = null)
    {
        $gun = \DB::select("guns")
            ->where("id", $id)
            ->first();

        if ($gun === null) {
            return null;
        }

        return $gun;
    }

    public static function getReservations(?int $limit = null)
    {
        if ($limit === null) {
            return null;
        }
        $reservations = \DB::select("game_reservations")
            ->limit($limit)
            ->get() ?? null;

        if ($reservations === null) {
            return null;
        }
        $result = array();
        foreach ($reservations as $reservation) {
            array_push($result, self::getGamesReservationById($reservation["id"]));
        }

        return $result;
    }
}
