<?php
$teams = [
    [
        "id" => 1,
        "name" => "Red Dragons",
        "photo" => "/backend/storage/images/Events.jpeg",
        "number_of_members" => 8
    ],
    [
        "id" => 2,
        "name" => "Blue Tigers",
        "photo" => "/backend/storage/images/Events.jpeg",

        "number_of_members" => 10
    ],
    [
        "id" => 3,
        "name" => "Green Wolves",
        "photo" => "/backend/storage/images/Events.jpeg",

        "number_of_members" => 6
    ],
    [
        "id" => 4,
        "name" => "Yellow Hawks",
        "photo" => "/backend/storage/images/Events.jpeg",
        "number_of_members" => 12
    ]
];



?>



<div class=" relative z-1 w-75 m-center">
    <h1 class="text-center c-brown title">Our Teams </h1>
    <div class="events-container  flex flex-wrap m-center flex-column events-scroll" data-speed="2.1"
        style="height : 400px">
        <?php foreach ($teams as $t): ?>
            <div class="flex content-center padding flex-column instructor-item rounded">
                <img src="<?= $t['photo'] ?>" class="rounded" alt="">
                <p>Name : <?= $t['name'] ?></p>
                <p>Numbers of Members : <?= $t['number_of_members'] ?></p>
                <button type="submit" class="button z-1 w-100"><a
                        style="text-decoration: none ;  color : var(--brown-dark);  " href="event/<?= $t["id"] ?>"><img
                            src="/frontend/assets/imgs/image.png" alt="" style="height: 40px !important;">
                        More info
                    </a>
                </button>

            </div>
        <?php endforeach; ?>
    </div>
</div>