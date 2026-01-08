<?php
require_once __DIR__ . "/../../env/host.php";
try {
    $columns = DB::select("users")->first();
    print_r(array_keys($columns));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
