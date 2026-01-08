<?php
require_once "./host.php";

$user = DB::select("users")->where("id", 11)
    ->with(
        "admin_info",
        fn($user) =>
        DB::select("admins")
            ->where("user_id", $user->id)
            ->get()[0]
    )
    ->get()[0];



echo "<pre>", print_r($user), "</pre>";

