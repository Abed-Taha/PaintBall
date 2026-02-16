<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/env/host.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/env/DTO.php";
require_once $_SERVER["DOCUMENT_ROOT"] .  "/backend/services/TeamService.php";

class UserService
{
    public static function getUserById(?int $userId = null)
    {
        if ($userId === null) {
            return null;
        }

        $user = \DB::table("users")
            ->where("id", $userId)
            ->first();

        if ($user === null) {
            return null;
        }

        return $user;
    }

    public static function deleteUser(?int $userId = null)
    {
        if ($userId === null) {
            return false;
        }

        try {
            \DB::table("users")
                ->where("id", $userId)
                ->update(['deleted_at' => date('Y-m-d H:i:s')]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function restoreUser(?int $userId = null)
    {
        if ($userId === null) {
            return false;
        }

        try {
            \DB::table("users")
                ->where("id", $userId)
                ->update(['deleted_at' => null]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getInstInfo(?int $id = null)
    {
        if ($id === null) {
            return null;
        }

        $inst = \DB::table("instructors")
            ->where("id", $id)
            ->first();

        if ($inst === null) {
            return null;
        }
        $inst["user"] = self::getUserById($inst["user_id"]);

        return $inst;
    }

    public static function getInstructors(?int $limit = null)
    {
        if ($limit === null) {
            $instructors = \DB::table("instructors")
                ->get();
        } else {
            $instructors = \DB::table("instructors")
                ->limit($limit)
                ->get();
        }
        foreach ($instructors as &$inst) {
            $inst["user"] = self::getUserById($inst["user_id"]);
        }

        return $instructors;
    }

    public static function registerToTeam(?int $id = null)
    {
        if ($id == null) {
            DTO::session_error("Team id not found");
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit;
        }
        $user = $_SESSION["user"];

        $team = TeamService::getTeamById($id);
        $members = TeamService::getTeamMembers($id);
        foreach ($members as $m) {
            if ($m["email"] == $user["email"]) {
                DTO::session_error("you are already in the team");
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                exit;
            }
        }
        if (count($members) >= $team["max_number"]) {
            DTO::session_error("Jareb 7azak maratan 2ou5ra");
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit;
        }

        $u = DB::table("user_team")
            ->insert([
                "user_id" => $user["id"],
                "team_id" => $id,
            ]);
        DTO::session_success("you are now member of the team : " . $team["name"]);
    }
}
