<?php
require_once __DIR__ .  "/../../../security/blockRoutes.php";
block(basename(__FILE__));
?>
<div class="not-found">
    <h1>404</h1>
    <p>Oops! The page you're looking for doesn't exist.</p>
    <a href="/" class="home-btn">Go Back Home</a>
</div>