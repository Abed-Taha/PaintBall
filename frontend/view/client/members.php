<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/backend/services/TeamService.php";
$members = TeamService::getTeamMembers($_GET["id"]);
?>
<style>
    .members-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .member-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px;
        border-radius: 12px;
        text-decoration: none;
        color: inherit;
        transition: 0.2s ease;
    }

    .member-card:hover {
        transform: translateY(-2px);
    }

    .member-photo img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    .member-info h4 {
        margin: 0;
        font-size: 16px;
    }

    .member-info p {
        margin: 3px 0 0;
        font-size: 14px;
        color: gray;
    }
</style>

<div class="members-container">
    <?php foreach ($members as $member): ?>
        <a href="/profile?id=<?= $member['id'] ?>" class="member-card bg-main ">

            <div class="member-photo ">
                <img src="<?= IMG_PATH . '/default-profile.png' ?>"
                    alt="<?= htmlspecialchars($member['name']) ?>">
            </div>

            <div class="member-info">
                <h4 class="c-white"><?= htmlspecialchars($member['name']) ?></h4>
                <p class="c-white"><?= htmlspecialchars($member['email']) ?></p>
            </div>

        </a>
    <?php endforeach; ?>
</div>