<?php

require_once BASE_PATH . '/backend/services/EventService.php';

$eventId = isset($_GET['id']) ? intval($_GET['id']) : null;
$event = EventService::getEventById($eventId);

if ($event === null): ?>
    <h2>Event not found.</h2>
<?php else: ?>
    <div class="card-container">
        <div class="card-item  rounded bg-main">
            <img src="<?= IMG_PATH . '/' . $event["photo"] ?>" alt="<?= $event["photo"] ?>" class="card-photo">
            <div class="flex items-center title-section">
                <h1 style="flex-grow: 2;">
                    <?= $event["name"] ?>
                </h1>
                <h3>
                    <?= $event["status"] ?>

                </h3>
            </div>
            <p class="font-size description ">
                <?= nl2br(htmlspecialchars($event["description"])) ?>
            </p>

            <div class="flex content-between items-center">
                <!-- Price on the left -->
                <p style="margin: 0; font-weight: bold;">Price: <?= $event["payment_price"] ?> $</p>

                <!-- Map info on the right -->
                <div class="flex flex-column items-center" style=" gap: 4px; ">
                    <p class="m-0 font-size text-center c-white"><u>In Map: </u><?= $event["map"]["name"] ?></p>
                    <img src="<?= IMG_PATH . '/' . $event["map"]["photo"] ?>"
                        alt="<?= $event["map"]["name"] ?>"
                        style="width: 150px; height: 150px; object-fit: cover; border-radius: 4px;">
                </div>
            </div>

        </div>
    </div>
<?php endif; ?>