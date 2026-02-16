<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/env/host.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/env/DTO.php";

class TeamService
{

    public static function getAllTeam()
    {
        return DB::select("teams")->get();
    }
    public static function getTeamById(?int $id = null)
    {
        if ($id === null) {
            return null;
        }
        $team = \DB::select("teams")
            ->where("id", $id)
            ->first() ?? null;

        if ($team === null) {
            return null;
        }

        $team["members"] = TeamService::getTeamMembers($team["id"]);

        return $team;
    }

    public static function getTeamMembers(?int $id = null)
    {
        $query = "select u.id ,u.name , u.email , u.photo
                   from users u 
                    join user_team ut on u.id=ut.user_id
                    join teams t on t.id=ut.team_id
                    WHERE ut.team_id = $id";
        $members = DB::run($query);
        return $members;
    }
}
