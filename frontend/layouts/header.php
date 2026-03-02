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
    <link rel="icon" href="/PaintBall/frontend/assets/imgs/mainIcon.jpeg" type="image/x-icon">
    <!-- CSS -->

    <link rel="stylesheet" href="/PaintBall/frontend/assets/css/index.css">
    <link rel="stylesheet" href="/PaintBall/frontend/assets/css/header.css">
    <link rel="stylesheet" href="/PaintBall/frontend/assets/css/main.css">
    <link rel="stylesheet" href="/PaintBall/frontend/assets/css/footer.css">
    <link rel="stylesheet" href="/PaintBall/frontend/assets/css/admin.css">
    <link rel="stylesheet" href="/PaintBall/frontend/assets/css/keyframse.css">



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
            <img class="test" src="/PaintBall/frontend/assets/imgs/test-icon.png" draggable="false" alt="">
            <div class="main-icon">
                <a href="/PaintBall/" class="w-100 ">
                    <img src="/PaintBall/frontend/assets/imgs/main.png" style="object-fit: contain;" alt="" draggable="false">
                </a>
            </div>

            <div class="hum">
                <img src="/PaintBall/frontend/assets/imgs/hum.png" alt="" draggable="false">
            </div>

            <?php if (!isset($_SESSION["user"])): ?>
                <div class=" link-container nav-link">
                    <a href="/PaintBall/index.php?v=global/login" class="<?= isset($_GET['v']) && $_GET['v'] == "global/login" ? "active" : "" ?>">Login</a>
                    <a href="/PaintBall/index.php?v=global/register" class="<?= isset($_GET['v']) && $_GET['v'] == "global/register" ? "active" : "" ?>">Register</a>
                </div>
            <?php else: ?>
                <?php switch ($_SESSION["user"]["role"]) {
                    case "admin": ?>

                        <div class="link-container nav-link">
                            <a href="/PaintBall/index.php?v=admin/mainPage" class="<?= isset($_GET['v']) && $_GET['v'] == "admin/mainPage" ? "active" : "" ?>">Manage Tools</a>
                            <a href="/PaintBall/index.php?v=client/profile" class="<?= isset($_GET['v']) && $_GET['v'] == "client/profile" ? "active" : "" ?>">Profile</a>
                            <a href="/PaintBall/backend/actions/logout.php">Logout</a>
                        </div>

                    <?php
                        break;
                    case "instructor": ?>
                        <div class="link-container  nav-link">
                            <a href="/PaintBall/index.php?v=client/profile" class="<?= isset($_GET['v']) && $_GET['v'] == "client/profile" ? "active" : "" ?>">Profile</a>
                            <a href="/PaintBall/index.php?v=main/tasks" class="<?= isset($_GET['v']) && $_GET['v'] == "main/tasks" ? "active" : "" ?>">Tasks</a>
                            <a href="/PaintBall/index.php?v=main/reservation" class="<?= isset($_GET['v']) && $_GET['v'] == "main/reservation" ? "active" : "" ?>">Battle with Us</a>
                            <a href="/PaintBall/backend/actions/logout.php">Logout</a>
                        </div>
                    <?php
                        break;
                    default: ?>
                        <div class="link-container  nav-link">
                            <a href="/PaintBall/index.php?v=main/reservation" class="<?= isset($_GET['v']) && $_GET['v'] == "main/reservation" ? "active" : "" ?>">Battle with Us</a>
                            <a href="/PaintBall/index.php?v=client/profile" class="<?= isset($_GET['v']) && $_GET['v'] == "client/profile" ? "active" : "" ?>">Profile</a>
                            <a href="/PaintBall/backend/actions/logout.php">Logout</a>
                        </div>
                <?php } ?>
            <?php endif; ?>







        </header>
    <?php endif; ?>