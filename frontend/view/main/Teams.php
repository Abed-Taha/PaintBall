<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/backend/services/TeamService.php";

$teams = TeamService::getAllTeam();



?>



<div class=" relative z-1 w-75 m-center">
    <h1 class="text-center c-brown title">Our Teams </h1>
    <div class="events-container  flex flex-wrap m-center flex-column events-scroll" data-speed="2.1"
        style="height : 400px">
        <?php foreach ($teams as $t): ?>
            <div class="flex content-center padding flex-column instructor-item rounded">
                <img src="<?= IMG_PATH . '/' . $t['photo'] ?>" class="rounded" style="height:150px" alt="">
                <p>Name : <?= $t['name'] ?></p>
                <p>Numbers of Members : <?= $t['max_number'] ?></p>
                <button type="submit" class="button z-1 w-100"><a
                        style="text-decoration: none ;  color : var(--brown-dark);  " href="team?id=<?= $t["id"] ?>"><img
                            src="/frontend/assets/imgs/image.png" alt="" style="height: 40px !important;">
                        More info
                    </a>
                </button>

            </div>
        <?php endforeach; ?>
    </div>
</div>