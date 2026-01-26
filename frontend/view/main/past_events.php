<?php
// request the event for data base 
// code ... 
$events = DB::select(table: 'events')
    ->where('start_date', '<=', date('Y-m-d'))
    ->orderBy('start_date')
    ->limit(5)
    ->get();

foreach ($events as &$event) {
    // truncate description to 100 characters
    if (strlen($event['description']) > 100) {
        $event['description'] = substr($event['description'], 0, 100) . '...';
    }
    $event['map'] = DB::select('maps')->where('id', $event['map_id'])->get()[0];
}
?>

<div class="relative z-1 w-100">
    <h1 class="text-center c-brown title">Past Events! </h1>
    <div class="events-container flex flex-wrap  m-center events-scroll" data-speed="1.9">
        <?php foreach ($events as $event): ?>
            <div class="events-item ">
                <div>
                    <div>
                        <h3><?= $event["name"] ?></h3>
                        <p>description : <?= substr($event["description"], 0, 100) ?></p>
                    </div>
                    <div><img src="/backend/storage/images/<?= $event["map"]['photo'] ?>" alt=""></div>
                </div>
                <div>
                    <p>Start-date : <?= $event["start_date"] ?></p>
                    <button type="submit" class="button z-1" style="width: 200px;"><a
                            style="text-decoration: none ;  color : var(--brown-dark); "
                            href="event?id=<?= $event["id"] ?>"><img src="/frontend/assets/imgs/image.png" alt=""
                                style="height: 40px !important;">
                            Go
                        </a>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>