<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/backend/services/UserService.php";
$instructors = UserService::getInstructors(4);
?>

<div class=" relative z-1 w-75 m-center">
    <h1 class="text-center c-brown title">Our Instructors </h1>
    <div class="events-container flex flex-wrap m-center flex-column events-scroll" data-speed="2.4"
        style="height : 400px">
        <?php foreach ($instructors as $ins): ?>
            <div class="flex items-center content-center padding flex-column instructor-item rounded" style="width: 300px; min-height: 450px;">
                <img src="/backend/storage/images/<?= $ins['user']['photo'] ?>" class="rounded" alt="" style="width: 200px; height: 200px; object-fit: cover;">
                <p style="text-align: center;">Name : <?= $ins['user']['name'] ?></p>
                <p style="text-align: center;">Email : <?= $ins['user']['email'] ?></p>
                <button type="submit" class="button z-1 w-100"><a
                        style="text-decoration: none ;  color : var(--brown-dark);  " href="/profile?id=<?= $ins["id"] ?>"><img
                            src="/frontend/assets/imgs/image.png" alt="" style="height: 40px !important;">
                        More info
                    </a>
                </button>

            </div>
        <?php endforeach; ?>
    </div>
</div>