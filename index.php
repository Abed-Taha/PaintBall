<?php
define('BASE_PATH', ".");
define("ENV_PATH", BASE_PATH . "/env");
define("SERVICE_PATH", BASE_PATH . "/backend/services");
define('IMG_PATH', BASE_PATH . '/backend/storage/images');

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$isVerifiedPage = (($uri == "/verification_sent") || ($uri == "/reset-password"));
require_once "./env/host.php";


include_once BASE_PATH . "/frontend/layouts/header.php";


?>


<main class="padding">
    <!-- Alert Div  -->
    <?php if (isset($_SESSION['response'])): ?>
        <div class="alert alert-<?= $_SESSION['response']['status'] ?>" id="alert" style="z-index: 999;">
            <?= htmlspecialchars($_SESSION['response']['message']) ?>

        </div>
    <?php endif; ?>

    <?php
    switch ($uri) {
        //static pages 
        case "/":
            require_once __DIR__ . "/frontend/view/main/main.php";
            break;
        case "/contact":
            require_once __DIR__ . "/frontend/view/global/contact.php";
            break;
        case "/profile":
            require_once __DIR__ . "/frontend/view/client/profile.php";
            break;
        case "/edit_profile":
            require_once __DIR__ . "/frontend/view/client/edit_profile.php";
            break;
        case "/events":
            require_once __DIR__ . "/frontend/view/main/events.php";
            break;
        case "/user_reservations":
            require_once __DIR__ . "/frontend/view/main/user_reservations.php";
            break;
        // admin pages 
        case "/admin":
            require_once __DIR__ . "/frontend/view/admin/mainPage.php";
            break;

        case "/admin/users":
            require_once __DIR__ . "/frontend/view/admin/managePlayers.php";
            break;
        case "/admin/events":
            require_once __DIR__ . "/frontend/view/admin/create_event.php";
            break;
        case "/admin/instructors":
            require_once __DIR__ . "/frontend/view/admin/manageInstructors.php";
            break;

        // Guest Links 
        case "/login":
            require_once __DIR__ . "/frontend/view/global/login.php";
            break;
        case "/register":
            require_once __DIR__ . "/frontend/view/global/register.php";
            break;
        case "/reset-password":
            require_once __DIR__ . "/frontend/view/global/reset-password.php";
            break;


        // verification  routes 
        case "/verification_sent":
            require_once __DIR__ . "/frontend/view/global/verification_sent.php";
            break;
        case "/verify":
            require_once __DIR__ . "/backend/actions/verify_email.php";
            break;

        case "/event":
            require_once __DIR__ . "/frontend/view/client/eventView.php";
            break;

        case "/battle":
            require_once __DIR__ . "/frontend/view/main/reservation.php";
            break;

        case "/detail":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/frontend/view/global/detail.php";
            break;
        case "/team":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/frontend/view/main/team_display.php";
            break;
        case "/members":
            require_once $_SERVER["DOCUMENT_ROOT"] . "/frontend/view/client/members.php";
        // 404 routes 
        default:
            require_once __DIR__ . "/frontend/view/global/notFound.php";
    }

    ?>
</main>
<div id="mouse-cursor" class="absolute"></div>

<?php
if (!$isVerifiedPage) {
    require_once __DIR__ . "/frontend/layouts/footer.php";
}
?>