<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/PaintBall/env/host.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/PaintBall/env/DTO.php";

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

    public static function createTeam($name, $maxPlayers, $photoPath = null)
    {
        $teamData = [
            'name' => $name,
            'max_number' => $maxPlayers,
            'points' => 0 // Initialize points
        ];

        if ($photoPath !== null) {
            $teamData['photo'] = $photoPath;
        }

        return DB::table('teams')->insert($teamData);
    }

    public static function joinTeam($userId, $teamId)
    {
        return DB::table('user_team')->insert([
            'user_id' => $userId,
            'team_id' => $teamId
        ]);
    }

    public static function searchTeams($query = null, $limit = 10)
    {
        $db = DB::select("teams");
        if (!empty($query)) {
            $db->where("name", "LIKE", "%" . $query . "%");
        } else {
            $db->orderBy("RAND()");
        }
        $teams = $db->limit($limit)->get();
        
        // Count members for each team to display availability
        foreach ($teams as &$team) {
            $members = self::getTeamMembers($team['id']);
            $team['current_members'] = count($members);
        }
        return $teams;
    }

    public static function isUserInTeam($userId, $teamId)
    {
        $res = DB::select("user_team")
            ->where("user_id", $userId)
            ->where("team_id", $teamId)
            ->first();
        return !empty($res);
    }

    public static function hasAnyTeam($userId)
    {
        $res = DB::select("user_team")
            ->where("user_id", $userId)
            ->first();
        return !empty($res);
    }
}
