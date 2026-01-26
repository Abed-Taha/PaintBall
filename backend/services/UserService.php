<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/env/host.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/env/DTO.php";

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
}
