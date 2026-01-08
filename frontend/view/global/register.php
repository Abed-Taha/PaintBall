<?php
require_once __DIR__ . "/../../../security/blockRoutes.php";
block(basename(__FILE__));

$old = $_SESSION['response']['data'] ?? [];
?>

<div class=" h-100 flex items-center flex-wrap padding ">
    <form action="/backend/actions/register.php" method="post" class=" login-div  bg-main  padding"
        style="height: 450px;">
        <h2 style="text-align:center ; color : var(--white)">Register</h2>
        <div class=" form-gap margin grid-cl-2">
            <div class="grid-cl-2">
                <fieldset class="input w-100">
                    <input required type="text" id="fullName" name="name"
                        value="<?= htmlspecialchars($old["name"] ?? '') ?>" />
                    <label for="fullName"> First Name</label>
                </fieldset>
                <fieldset class="input w-100">
                    <input required type="text" id="ln" name="last_name"
                        value="<?= htmlspecialchars($old["last_name"] ?? '') ?>" />
                    <label for="ln"> Last Name</label>
                </fieldset>
            </div>
            <fieldset class="input w-100">
                <input required type="number" id="Age" min="18" max="40" name="age"
                    value="<?= htmlspecialchars($old["age"] ?? '') ?>" />
                <label for="Age"> Age</label>
            </fieldset>
        </div>
        <div class="flex w-100 form-gap margin">
            <fieldset class="input w-100">
                <input required type="text" id="e" name="email"
                    value="<?= htmlspecialchars($old["email"] ?? '') ?>" />
                <label for="e">Email</label>
            </fieldset>
            <fieldset class="input w-100">
                <input required type="number" id="tel" name="phone"
                    value="<?= htmlspecialchars($old["phone"] ?? '') ?>" />
                <label for="tel"> Phone</label>
            </fieldset>
        </div>
        <div class="flex w-100 form-gap margin">
            <fieldset class="input w-100 relative">
                <input required type="password" id="pass" name="password" />
                <label for="pass"  > Password</label>
                <img src="/frontend/assets/imgs/eye-open.png" data-type="hide"  class="show-password" draggable="false">
            </fieldset>
            <fieldset class="input w-100">
                <input required type="password" id="cn-pass" name="confirm_password" />
                <label for="cn-pass"> Confirm Password</label>
            </fieldset>
        </div>
        <div class="margin flex">
            <fielset class="w-100">
                <input type="checkbox" id="terms" style="height : 15px; width: 15px;" name="terms" required>
                <a href="/Terms" class="a-link"><label> Terms and Conditions</label></a>
            </fielset>
        </div>
        <button type="submit" class="button padding w-100"> <img src="/frontend/assets/imgs/image.png"
                alt="">Register</button>

    </form>
</div>