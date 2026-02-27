<?php
require_once __DIR__ . "/../../security/blockRoutes.php";
block(basename(__FILE__));
$route = $_SERVER["REQUEST_URI"];
require_once __DIR__ . "/../../env/host.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">



    <!-- icon -->
    <link rel="icon" href="/frontend/assets/imgs/mainIcon.jpeg" type="image/x-icon">
    <!-- CSS -->

    <link rel="stylesheet" href="/frontend/assets/css/index.css">
    <link rel="stylesheet" href="/frontend/assets/css/header.css">
    <link rel="stylesheet" href="/frontend/assets/css/main.css">
    <link rel="stylesheet" href="/frontend/assets/css/footer.css">
    <link rel="stylesheet" href="/frontend/assets/css/admin.css">
    <link rel="stylesheet" href="/frontend/assets/css/keyframse.css">



    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Righteous&family=Roboto:ital,wght@0,100..900;1,100..900&family=Special+Gothic&family=Special+Gothic+Expanded+One&display=swap"
        rel="stylesheet">

    <title>PaintBall</title>
</head>

<body style="overflow-x: hidden;">

    <?php if (!$isVerifiedPage): ?>

        <header class="flex content-around items-center border-fade">
            <img class="test" src="/frontend/assets/imgs/test-icon.png" draggable="false" alt="">
            <div class="main-icon">
                <a href="/" class="w-100 ">
                    <img src="/frontend/assets/imgs/main.png" style="object-fit: contain;" alt="" draggable="false">
                </a>
            </div>

            <div class="hum">
                <img src="/frontend/assets/imgs/hum.png" alt="" draggable="false">
            </div>

            <?php if (!isset($_SESSION["user"])): ?>
                <div class=" link-container nav-link">
                    <a href="login" class="<?= $route == "/login" ? "active" : "" ?>">Login</a>
                    <a href="register" class="<?= $route == "/register" ? "active" : "" ?>">Register</a>
                </div>
            <?php else: ?>
                <?php switch ($_SESSION["user"]["role"]) {
                    case "admin": ?>

                        <div class="link-container nav-link">
                            <a href="/admin" class="<?= $route == "/admin" ? "active" : "" ?>">Manage Tools</a>
                            <a href="/profile" class="<?= $route == "/profile" ? "active" : "" ?>">Profile</a>
                            <a href="/backend/actions/logout.php">Logout</a>
                        </div>

                    <?php
                        break;
                    case "instructor": ?>
                        <div class="link-container  nav-link">
                            <a href="profile" class="<?= $route == "/profile" ? "active" : "" ?>">Profile</a>
                            <a href="tasks" class="<?= $route == "/tasks" ? "active" : "" ?>">Tasks</a>
                            <a href="/battle" class="<?= $route == "/battle" ? "active" : "" ?>">Battle with Us</a>
                            <a href="/backend/actions/logout.php">Logout</a>

                        </div>
                    <?php
                        break;
                    default: ?>
                        <div class="link-container  nav-link">
                            <a href="/battle" class="<?= $route == "/battle" ? "active" : "" ?>">Battle with Us</a>
                            <a href="profile" class="<?= $route == "/profile" ? "active" : "" ?>">Profile</a>
                            <a href="/backend/actions/logout.php">Logout</a>
                        </div>
                <?php } ?>
            <?php endif; ?>







        </header>
    <?php endif; ?>