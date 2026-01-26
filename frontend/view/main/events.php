<?php
// request the event for data base 
// code ... 
$events = DB::select(table: 'events')
    ->where('start_date', '>=', date('Y-m-d'))
    ->orderBy('start_date')
    ->limit(5)
    ->get();

foreach ($events as &$event) {
    // truncate description to 100 characters
    if (strlen($event['description']) > 100) {
        $event['description'] = substr($event['description'], 0, 100) . '...';
    }
    unset($event);
}
?>



<div class="relative z-1 w-100">
    <h1 class="text-center c-brown title">Events Soon ! </h1>
    <?php if (empty($events)): ?>
        <div class="events-container flex flex-wrap  m-center events ">
            <h2 class="text-center ">No upcoming events available.</h2>
        </div>
    <?php else: ?>
        <div class="events-container flex flex-wrap  m-center <?= count($events) > 2 ? "events-scroll" : "" ?>" data-speed="1.3">
            <?php foreach ($events as $event): ?>
                <div class="events-item">
                    <div>
                        <div>
                            <h3><?= $event["name"] ?></h3>
                            <p>description : <?= substr($event["description"], 0, 100) ?></p>
                        </div>
                        <div><img src="/backend/storage/images/<?= $event["photo"] ?>" alt=""></div>
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
    <?php endif; ?>
</div>