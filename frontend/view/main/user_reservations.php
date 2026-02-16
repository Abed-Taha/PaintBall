<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/backend/services/GamesService.php";
$reservations = GamesService::getReservations(3);
?>

<div class="relative z-1 w-100 flex flex-column items-center">
    <h1 class="text-center c-brown title"> Your Reservations !</h1>

    <!-- Scroll wrapper -->
    <div class="w-100 flex content-center" id='reservations-table' style="overflow-x: auto; overflow-y: hidden;">

        <table class=" w-100 table">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Team</th>
                    <th>Opponent</th>
                    <th>Map</th>
                    <th>Payment</th>
                    <th>Details</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($reservations as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["date"]) ?></td>
                        <td><?= htmlspecialchars($row["status"]) ?></td>
                        <td><?= htmlspecialchars($row["team"]["name"]) ?></td>
                        <td><?= htmlspecialchars($row["games"]["opponent"]["name"]) ?></td>
                        <td><?= htmlspecialchars($row["map"]["name"]) ?></td>
                        <td>$<?= htmlspecialchars($row["payment_price"]) ?></td>
                        <td>
                            <a href="detail?id=<?= $row["id"] ?>" class="button" style="display:flex; justify-content:center; align-items:center;
                                      text-decoration:none; color: var(--brown-light);">
                                <img src="/frontend/assets/imgs/image.png" alt="Go"
                                    style="height:60px; transform:translateY(-15px); margin-right:5px;">
                                <span class="z-2">Go</span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>