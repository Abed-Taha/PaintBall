<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/backend/services/GamesService.php";
$reservation = GamesService::getGamesReservationById(1);
// Assuming IMG_PATH is defined somewhere, like in a config or header
if (!defined('IMG_PATH')) {
    define('IMG_PATH', '/frontend/assets/images');
}
?>

<div class="card-container">
    <div class="card-item rounded bg-main">
        <div class="flex items-center title-section">
            <h1 style="flex-grow: 2;">Reservation Details</h1>
            <h3>Status: <?= htmlspecialchars($reservation["status"]) ?></h3>
        </div>

        <div class="reservation-info">
            <div class="info-row"><strong>Reservation ID:</strong> <span><?= htmlspecialchars($reservation["id"]) ?></span></div>
            <div class="info-row"><strong>Date:</strong> <span><?= htmlspecialchars($reservation["date"]) ?></span></div>
            <div class="info-row"><strong>Payment Price:</strong> <span>$<?= htmlspecialchars($reservation["payment_price"]) ?></span></div>
        </div>

        <div class="game-details">
            <h2>Game Details</h2>
            <p><strong>Duration:</strong> <?= htmlspecialchars($reservation["games"]["game_duration"]) ?> minutes</p>
            <img src="<?= IMG_PATH . '/' . htmlspecialchars($reservation["games"]["photo"]) ?>" alt="Game Photo" class="card-photo" style="width: 200px; height: 200px; object-fit: cover; border-radius: 4px;">

            <div class="teams">
                <div class="team">
                    <h3>Team</h3>
                    <p><strong>Name:</strong> <?= htmlspecialchars($reservation["games"]["team"]["name"]) ?></p>
                    <p><strong>Max Players:</strong> <?= htmlspecialchars($reservation["games"]["team"]["max_number"]) ?></p>
                    <img src="<?= IMG_PATH . '/' . htmlspecialchars($reservation["games"]["team"]["photo"]) ?>" alt="Team Photo" style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px;">
                </div>
                <div class="opponent">
                    <h3>Opponent</h3>
                    <p><strong>Name:</strong> <?= htmlspecialchars($reservation["games"]["opponent"]["name"]) ?></p>
                    <p><strong>Max Players:</strong> <?= htmlspecialchars($reservation["games"]["opponent"]["max_number"]) ?></p>
                    <img src="<?= IMG_PATH . '/' . htmlspecialchars($reservation["games"]["opponent"]["photo"]) ?>" alt="Opponent Photo" style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px;">
                </div>
            </div>

            <div class="instructor">
                <h3 style="border-bottom: 2px solid var(--yellow-primary);">Instructor</h3>
                <div class="user-info">
                    <img src="<?= IMG_PATH . '/' . htmlspecialchars($reservation["games"]["instructor"]["user"]["photo"]) ?>" alt="Instructor Photo" class="instructor-photo">
                    <div class="user-details">
                        <p><strong>Name:</strong> <?= htmlspecialchars($reservation["games"]["instructor"]["user"]["name"]) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($reservation["games"]["instructor"]["user"]["email"]) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($reservation["games"]["instructor"]["user"]["phone"]) ?></p>
                        <p><strong>Age:</strong> <?= htmlspecialchars($reservation["games"]["instructor"]["user"]["age"]) ?></p>
                    </div>
                </div>
            </div>

            <div class="bundle">
                <h3 style="border-bottom: 2px solid var(--yellow-primary);">Bundle</h3>
                <p><strong>Name:</strong> <?= htmlspecialchars($reservation["games"]["bundel"]["name"]) ?></p>
                <h4>Guns:</h4>
                <ul>
                    <?php foreach ($reservation["games"]["bundel"]["guns"] as $gun): ?>
                        <li><?= htmlspecialchars($gun["name"]) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>



        <div class="map-info flex-column ">
            <h2 class="w-100">Map</h2>
            <div class="flex content-between w-100">
                <p><strong>Name:</strong> <?= htmlspecialchars($reservation["map"]["name"]) ?></p>
                <img src="<?= IMG_PATH . '/' . htmlspecialchars($reservation["map"]["photo"]) ?>" alt="Map Photo" style="width: 100%;align-self:flex-end; max-width:300px;height: 150px; object-fit: cover; border-radius: 4px;">
            </div>
        </div>
    </div>
</div>