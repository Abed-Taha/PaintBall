<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/backend/services/TeamService.php";


// ✅ Get ID from URL
$teamId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// ✅ Find team by ID
$selectedTeam = TeamService::getTeamById($teamId);

// ✅ If team not found
if (!$selectedTeam) {
    echo "<h2 style='text-align:center;'>Team not found</h2>";
    exit;
}
?>

<div class="relative z-1 w-75 m-center">
    <h1 class="text-center c-brown title"><?= htmlspecialchars($selectedTeam['name']) ?></h1>

    <div class="flex content-center padding flex-column bg-main rounded c-white" style="min-height: 400px; margin-bottom: 20px;">

        <img src="<?= IMG_PATH . '/' . $selectedTeam['photo'] ?>"
            class="rounded"
            alt="<?= htmlspecialchars($selectedTeam['name']) ?>"
            style="width: 100%; height: 350px; object-fit: cover;">

        <h3 class="text-center" style="margin-top: 15px;">
            Name: <?= htmlspecialchars($selectedTeam['name']) ?>
        </h3>

        <div class="members-list flex items-center content-center" style="gap: 5px; margin: 10px 0;">
            <span style="font-size: 0.9rem; margin-right: 5px;">Members:</span>

            <?php
            $limit = 5;
            $count = 0;

            foreach ($selectedTeam['members'] as $member):
                if ($count >= $limit) break;
            ?>
                <img src="<?= IMG_PATH . '/' . $member['photo'] ?>"
                    class="rounded shadow"
                    alt="<?= htmlspecialchars($member['name']) ?>"
                    title="<?= htmlspecialchars($member['name']) ?>"
                    style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; border: 1px solid var(--white);">
            <?php
                $count++;
            endforeach;
            ?>

            <?php if (count($selectedTeam['members']) > $limit): ?>
                <span style="font-size: 0.9rem; color: var(--gray-light);">
                    <a href="/members?id=<?= $selectedTeam["id"] ?>">
                        +<?= count($selectedTeam['members']) - $limit ?>
                    </a>
                </span>
            <?php endif; ?>
        </div>

        <button type="button" class="padding button w-100 modal">
            <img src="/frontend/assets/imgs/image.png" alt="">
            Register Now
        </button>

        <!-- Modal Overlay -->
        <div id="registerModal" class="modal-overlay ">
            <div class="modal-content bg-main">
                <h3>Confirm Registration</h3>
                <p>Are you sure you want to register for this team?</p>

                <div class="modal-actions">
                    <button class="modal-cancel cancelBtn">Cancel</button>
                    <form action="/backend/actions/registerToTeam.php">
                        <input type="hidden" name="id" value="<?= $teamId ?>">
                        <button id="confirmBtn" type="submit" class="modal-confirm" onclick="register()">Confirm</button>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>