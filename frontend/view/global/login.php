<?php
require_once __DIR__ . "/../../../security/blockRoutes.php";
block(basename(__FILE__));

$old = $_SESSION['response']['data'] ?? [];
?>
<div class=" h-100 flex items-center flex-wrap padding">
    <form action="/backend/actions/login.php" method="post"
        class=" login-div flex flex-column w-100  content-around bg-main padding" style="height: 250px;">
        <h2 style="margin : 0 auto; color:  var(--white);">Login</h2>
        <fieldset class="input">
            <input required type="text" id="email" name="email"
value="<?= htmlspecialchars($old["email"] ?? '') ?>" />
            <label for="email">Email</label>
        </fieldset>
        <fieldset class=" input">
            <input required id="pass" type="password" name="password" />
            <label for="pass">Password</label>
        </fieldset>
        <button type="submit" class="padding button w-100"><img src="/frontend/assets/imgs/image.png" alt="">Login</button>
    </form>
</div>