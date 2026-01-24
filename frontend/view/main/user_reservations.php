<?php $rows = [
    [
        "date" => "2025-01-10",
        "team" => "Roiters A",
        "enemy" => "Falcons",
        "map" => "Dust Field",
        "payment" => 25,
        "id" => 1
    ],
    [
        "date" => "2025-01-11",
        "team" => "Roiters B",
        "enemy" => "Snipers",
        "map" => "Forest Arena",
        "payment" => 30,
        "id" => 2
    ],
];

?>




<div class="relative z-1 w-100 flex flex-column items-center">
    <h1 class="text-center c-brown title"> Your Reservations !</h1>

    <!-- Scroll wrapper -->
    <div class="w-100 flex content-center" id='reservations-table' style="overflow-x: auto; overflow-y: hidden;">

        <table class=" w-100 table">
            <thead>
                <tr>

                    <th>Team</th>
                    <th>Enemy</th>
                    <th>Map</th>
                    <th>Date & time</th>
                    <th>Payment $</th>
                    <th>Details</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["team"]) ?></td>
                        <td><?= htmlspecialchars($row["enemy"]) ?></td>
                        <td><?= htmlspecialchars($row["map"]) ?></td>
                        <td><?= htmlspecialchars($row["date"]) ?></td>
                        <td>$<?= htmlspecialchars($row["payment"]) ?></td>
                        <td>
                            <a href="details.php?id=<?= $row["id"] ?>" class="button" style="display:flex; justify-content:center; align-items:center;
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