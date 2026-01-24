<?php
$instructors = [
    [
        "id" => 1,
        "photo" => "/backend/storage/images/Events.jpeg",
        "name" => "John Doe",
        "email" => "john.doe@example.com"
    ],
    [
        "id" => 2,
        "photo" => "/backend/storage/images/Events.jpeg",
        "name" => "Jane Smith",
        "email" => "jane.smith@example.com"
    ],
    [
        "id" => 3,
        "photo" => "/backend/storage/images/Events.jpeg",
        "name" => "Michael Lee",
        "email" => "michael.lee@example.com"
    ],
    [
        "id" => 4,
        "photo" => "/backend/storage/images/Events.jpeg",
        "name" => "Bara'a AbdelGhani",
        "email" => "michael.lee@example.com"
    ],
];
?>

<div class=" relative z-1 w-75 m-center">
    <h1 class="text-center c-brown title">Our Instructors </h1>
    <div class="events-container flex flex-wrap m-center flex-column events-scroll" data-speed="2.4"
        style="height : 400px">
        <?php foreach ($instructors as $ins): ?>
            <div class="flex content-center padding flex-column instructor-item rounded">
                <img src="<?= $ins['photo'] ?>" class="rounded" alt="">
                <p>Name : <?= $ins['name'] ?></p>
                <p>Email : <?= $ins['email'] ?></p>
                <button type="submit" class="button z-1 w-100"><a
                        style="text-decoration: none ;  color : var(--brown-dark);  " href="event/<?= $ins["id"] ?>"><img
                            src="/frontend/assets/imgs/image.png" alt="" style="height: 40px !important;">
                        More info
                    </a>
                </button>

            </div>
        <?php endforeach; ?>
    </div>
</div>