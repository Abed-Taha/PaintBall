<?php
// request the event for data base 
// code ... 
$events = [
    [
        "id" => 1,
        "title" => "Paintball Championship",
        "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae reprehenderit quod mollitia fuga accusamus velit repudiandae.",
        "img" => "Events.jpeg",
        "start_date" => "12-10-2025"
    ],
    [
        "id" => 2,
        "title" => "Night Battle Event",
        "description" => "This event happens at night under LED lights for an amazing experience. Full protective gear is provided.",
        "img" => "Events.jpeg",
        "start_date" => "22-11-2025"
    ],
    [
        "id" => 3,
        "title" => "Training Session with Pro",
        "description" => "A professional instructor will guide new players through advanced tactical paintball strategies.",
        "img" => "Events.jpeg",
        "start_date" => "05-12-2025"
    ],
    [
        "id" => 4,
        "title" => "Roiters Team Battle",
        "description" => "Compete with other roiters and gain points. Top players will be featured on the leaderboard!",
        "img" => "Events.jpeg",
        "start_date" => "30-12-2025"
    ],
];


?>

<div class="relative z-1 w-100">
    <h3 class="text-center c-brown title">Events Soon ! </h3>
    <div class="events-container flex flex-wrap  m-center events-scroll" data-speed="1.9">
        <?php foreach ($events as $event): ?>
            <div class="events-item ">
                <div>
                    <div>
                        <h3><?= $event["title"] ?></h3>
                        <p>description : <?= substr($event["description"], 0, 100) ?></p>
                    </div>
                    <div><img src="/backend/storage/images/<?= $event["img"] ?>" alt=""></div>
                </div>
                <div>
                    <p>Start-date : <?= $event["start_date"] ?></p>
                    <button type="submit" class="button z-1" style="width: 200px;"><a
                            style="text-decoration: none ;  color : var(--brown-dark); "
                            href="event/<?= $event["id"] ?>"><img src="/frontend/assets/imgs/image.png" alt=""
                                style="height: 40px !important;">
                            Go
                        </a>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>