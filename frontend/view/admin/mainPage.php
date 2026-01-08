<?php

$adminRoutes = [
    [
        "link" => "/admin/roiter",
        "title" => "Manage Roiter",
        "description" => "View all roiters, track red points, and kick players if necessary.",
        "photo" => "/frontend/assets/images/Roirters.jpeg"
    ],
    [
        "link" => "/admin/instructors",
        "title" => "Instructors Management",
        "description" => "View existing instructors and add new ones to the system.",
        "photo" => "/frontend/assets/images/InstructorM.jpeg"
    ],
    [
        "link" => "/admin/users",
        "title" => "Manage Players",
        "description" => "Disable or delete players from the platform.",
        "photo" => "/frontend/assets/images/PlayersM.jpeg"
    ],
    [
        "link" => "/admin/comments",
        "title" => "Review Comments",
        "description" => "Check comments flagged by AI for impolite or inappropriate words.",
        "photo" => "/frontend/assets/images/ReviewM.jpeg"
    ],
    [
        "link" => "/admin/events",
        "title" => "Add Paintball Events",
        "description" => "Create and manage new paintball events for players.",
        "photo" => "/frontend/assets/images/Events.jpeg"
    ],
];

$users = [
    [
        "id" => 1,
        "name" => "Abdallah Hassan",
        "photo" => "/frontend/assets/images/Events.jpeg"
    ],
    [
        "id" => 2,
        "name" => "Omar Khaled",
        "photo" => "/frontend/assets/images/Events.jpeg"

    ],
    [
        "id" => 3,
        "name" => "Sara Mahmoud",
        "photo" => "/frontend/assets/images/Events.jpeg"

    ],
    [
        "id" => 4,
        "name" => "John Doe",
        "photo" => "/frontend/assets/images/Events.jpeg"

    ],
];


?>

<div>
    <div class="w-100 grid cl-3 h-100 mt-10  c-white flex-wrap gap padding links-container">
        <?php foreach ($adminRoutes as $route): ?>

            <div class="bg-main rounded links-item relative items-center flex flex-wrap content-center">
                <img src="<?= $route["photo"] ?>" class="card-img1 absolute w-100 rounded" alt="">
                <h2 class="text-center">
                    <?= $route["title"] ?>
                </h2>
                <p class="text-center">
                    <?= $route["description"] ?>
                </p>
                <button type="submit" class="padding button w-100 flex content-center items-center">
                    <a href="<?= $route["link"] ?>" style=" text-decoration: none;" class="c-brown">
                        <img src="/frontend/assets/imgs/image.png" alt="">
                        Go
                    </a>
                </button>

            </div>
        <?php endforeach; ?>


    </div>
    <div class=" relative z-1 padding mt-10 mb-10">
        <h3 class=" text-center c-brown title">Players With Red Points !</h3>
        <div class="w-75 m-center bg-main rounded padding flex  content-around c-white  roirters-container mt-10 mb-10">
            <?php foreach ($users as $u): ?>
                <div class="item" data-id="<?= $u['id'] ?>">
                    <img src="<?= $u["photo"] ?>" alt="">
                    <p>Name : <?= $u["name"] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="padding button w-100 flex content-center items-center">
            <a href="/admin/roiter" style=" text-decoration: none;" class="c-brown">
                <img src="/frontend/assets/imgs/image.png" alt="">
                Show More Roiters
            </a>
        </button>
    </div>
</div>