<?php $feedbacks = [
    [
        "from" => "Alice",
        "to" => "John",
        "in_map" => "Arena 1",
        "date_time" => "2025-12-01 14:30:00"
    ],
    [
        "from" => "Bob",
        "to" => "Jane",
        "in_map" => "Arena 2",
        "date_time" => "2025-12-01 15:00:00"
    ],
    [
        "from" => "Charlie",
        "to" => "Michael",
        "in_map" => "Arena 3",
        "date_time" => "2025-12-01 16:15:00"
    ],
];


?>




<div class="relative z-1 w-100 flex flex-column items-center">
    <h3 class="text-center c-brown title">Some Random Feedbacks !</h3>

    <!-- Scroll wrapper -->
    <div class="w-100 flex content-center" id='reservations-table' style="overflow-x: auto; overflow-y: hidden;">

        <table class="table  ">
            <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Map</th>
                    <th>Date & Time</th>
                    <th>Details</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($feedbacks as $fb): ?>
                    <tr>
                        <td><?= htmlspecialchars($fb["from"]) ?></td>
                        <td><?= htmlspecialchars($fb["to"]) ?></td>
                        <td><?= htmlspecialchars($fb["in_map"]) ?></td>
                        <td><?= htmlspecialchars($fb["date_time"]) ?></td>
                        <td>
                            <a href="details.php?from=<?= urlencode($fb['from']) ?>&to=<?= urlencode($fb['to']) ?>"
                                class="button"
                                style="display:flex; justify-content:center; align-items:center; text-decoration:none; color: var(--brown-light);">
                                <span class="z-2"> Go</span>
                                <img src="/frontend/assets/imgs/image.png" alt="Go"
                                    style="height:60px; transform:translateY(-15px); margin-right:5px;">

                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>