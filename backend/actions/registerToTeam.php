<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/backend/services/UserService.php";
$id = isset($_GET["id"]) ? $_GET["id"] : null;
UserService::registerToTeam($id);
header("Location:" . $_SERVER["HTTP_REFERER"]);
