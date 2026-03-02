<div>

    <?php
    $files = [
        "events.php",
        "past_events.php",
        "tasks.php",
        "instructor.php",
        "Teams.php"
    ];

    foreach ($files as $file) {
        require_once ROOT . "/frontend/view/main/" . $file;
    }
    ?>
</div>