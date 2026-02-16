<?php
require_once __DIR__ . "/../../../security/blockRoutes.php";
block(basename(__FILE__));

require_once __DIR__ . "/../../../env/host.php";

// Fetch maps from database
$maps = DB::table('maps')->get();

$old = $_SESSION['response']['data'] ?? [];
?>

<div class="h-100 flex items-center flex-wrap padding">
    <form action="/backend/actions/create_event.php" method="post" enctype="multipart/form-data"
        class="login-div bg-main padding" style="height: auto; max-width: 800px; margin: 0 auto;">
        <h2 style="text-align:center; color: var(--white)">Create Event</h2>

        <div class="form-gap margin grid-cl-2">
            <!-- Name -->
            <fieldset class="input w-100">
                <input required type="text" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" />
                <label for="name">Name</label>
            </fieldset>

            <!-- Start Date -->
            <fieldset class="input w-100">
                <input required type="datetime-local" id="start_date" name="start_date"
                    value="<?= htmlspecialchars($old['start_date'] ?? '') ?>" />
                <label for="start_date">Start Date</label>
            </fieldset>
        </div>

        <div class="form-gap margin grid-cl-2">
            <!-- Payment Price -->
            <fieldset class="input w-100">
                <input required type="number" step="0.01" id="payment_price" name="payment_price"
                    value="<?= htmlspecialchars($old['payment_price'] ?? '') ?>" />
                <label for="payment_price">Payment Price</label>
            </fieldset>

            <!-- Payment Date -->
            <fieldset class="input w-100">
                <input required type="datetime-local" id="payment_date" name="payment_date"
                    value="<?= htmlspecialchars($old['payment_date'] ?? '') ?>" />
                <label for="payment_date">Payment Date</label>
            </fieldset>
        </div>

        <div class="form-gap margin flex">

            <!-- Map ID (Dropdown from DB) -->
            <fieldset class="input w-100">
                <fieldset class="input w-100 relative" style="height: max-content;">
                    <input required type="file" id="photo" name="photo" accept="image/*" style="padding-top: 10px;" />
                    <label for="photo">Photo</label>
                </fieldset>
                <select required id="map_id" name="map_id"
                    style="width: 100%; padding: 10px; background: transparent; border: 1px solid var(--white); color: var(--white); border-radius: 5px;">
                    <option value="" disabled <?= empty($old['map_id']) ? 'selected' : '' ?>>Select Map</option>
                    <?php foreach ($maps as $map): ?>
                        <option value="<?= htmlspecialchars($map['id']) ?>" <?= ($old['map_id'] ?? '') == $map['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($map['name'] ?? 'Map #' . $map['id']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </fieldset>
        </div>

        <div class="margin flex">
            <div class="input w-100">
                <textarea id="desc" name="description" rows="3" class="w-100 rounded padding" placeholder="description"
                    style="border: 2px solid var(--white); background: transparent;"><?= htmlspecialchars($old['description'] ?? '') ?> </textarea>
            </div>
        </div>

        <!-- Hidden ID field if needed for update, usually not for create but requested -->
        <input type="hidden" name="id" value="">

        <button type="submit" class="padding button w-100"><img src="/frontend/assets/imgs/image.png" alt="">Create
            Event</button>

    </form>
</div>