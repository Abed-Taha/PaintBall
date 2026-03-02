<?php
// Define Project Root
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/PaintBall');
define('IMG_PATH', '/PaintBall/backend/storage/images/');

// Essential inclusions
require_once ROOT . "/env/host.php";

// Get URI and handle potential subfolder access
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$project_prefix = '/PaintBall';

$isVerifiedPage = (isset($_GET['v']) && ($_GET['v'] == "global/verification_sent" || $_GET['v'] == "global/reset-password"));

// Load Header
include_once ROOT . "/frontend/layouts/header.php";
?>

<main class="padding">
    <!-- Feedback Alerts -->
    <?php if (isset($_SESSION['response'])): ?>
        <div class="alert alert-<?= $_SESSION['response']['status'] ?>" id="alert" style="z-index: 999;">
            <?= htmlspecialchars($_SESSION['response']['message']) ?>
        </div>
    <?php endif; ?>

    <?php
    // Get requested view from query parameter 'v', default to 'main/main'
    $v = isset($_GET['v']) ? $_GET['v'] : 'main/main';

    // view path is based directly on query parameter; we'll validate file existence below
    $safe_view = $v; // sanitized via file_exists check

    // Construct the absolute file path
    $file_path = ROOT . "/frontend/view/" . $safe_view . ".php";

    // Handle special case for actions if needed (like verify)
    if ($v === 'verify') {
        $file_path = ROOT . "/backend/actions/verify_email.php";
    }

    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        require_once ROOT . "/frontend/view/global/notFound.php";
    }
    ?>
</main>


<?php
if (!$isVerifiedPage) {
    require_once ROOT . "/frontend/layouts/footer.php";
}
?>