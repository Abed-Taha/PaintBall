<?php
require_once __DIR__ . "/../../../env/host.php";

$filter = isset($_GET["filter"]) ? htmlspecialchars($_GET["filter"]) : 'all';
$search = isset($_GET["search"]) ? trim(htmlspecialchars($_GET["search"])) : '';

$query = DB::select('users')
    ->where('id', '!=', (int) $_SESSION["user"]['id']);

switch ($filter) {
    case "instructor":
        $query->where("role", "instructor");
        break;
    case "user":
        $query->where("role", "user");
        break;
    case "all":
        $query->whereIn("role", ["user", "instructor"]);
        break;
}

if (!empty($search)) {
    $query->where('name', 'LIKE', "%$search%");
}

// Ensure we only get active users (not soft deleted) - strictly speaking requirement didn't specify, but good practice
// checking host.php diff, strict whereNotNull('deleted_at') vs whereNull
$query->whereNull("deleted_at");

$users = $query->get();
?>

<div>
    <div class="bg-main m-center flex w-75 flex-column rounded padding">
        <form action="" method="get" class="flex gap-2 content-around items-center">

            <!-- Filter Dropdown -->
            <select name="filter" class="text-center" onchange="this.form.submit()">
                <option value="all" <?= $filter === "all" ? "selected" : "" ?>>All Users & Instructors</option>
                <option value="instructor" <?= $filter === "instructor" ? "selected" : "" ?>>Instructors Only</option>
                <option value="user" <?= $filter === "user" ? "selected" : "" ?>>Users Only</option>
            </select>

            <fieldset class=" input">
                <input id="pass" type="text" name="search" value="<?= htmlspecialchars($search) ?>" />
                <label for="pass">Name</label>
            </fieldset>

            <button type="submit" class="padding button z-3 w-25"><img src="/frontend/assets/imgs/image.png"
                    alt="not-found">Search</button>
        </form>

        <ul>

            <?php if (!empty($users)):
                foreach ($users as $u): ?>

                    <li class="flex items-center content-between" style=" padding: 10px; border-bottom: 1px solid #ddd;padding-left:20px;">

                        <!-- Left side: User info -->
                        <div class="grid items-center" style="grid-template-columns: auto 1fr; gap: 5px;">
                            <!-- Pic + Name -->
                            <img src="/backend/storage/images/<?= $u["photo"] ?>" alt="not-found" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                            <p style="padding-left:20px;margin: 0; font-weight: bold;" class="c-white"><?= $u["name"] ?></p>

                            <!-- Role below, spanning both columns -->
                            <div style="grid-column: span 2; margin-left: 0;">
                                <p style="margin: 0; font-size: 14px;" class="c-white">Role: <?= $u["role"] ?></p>
                            </div>
                        </div>

                        <!-- Right side: Button -->
                        <div>
                            <form action="/backend/actions/instructorManage.php" class="flex content-center " method="POST">
                                <input type="text" name="user_id" hidden value="<?= $u['id'] ?>">
                                <?php if ($u['role'] === 'user'): ?>
                                    <input type="hidden" name="action" value="promote">
                                    <button type="submit" class="padding button z-3 w-75" style="width: 100%; background: #c19066; color: #c19066; min-width: 250px;"><img style="transform:translateY(-5px);" class="w-100" src="/frontend/assets/imgs/image.png"
                                            alt="not-found">Make Instructor</button>
                                <?php elseif ($u['role'] === 'instructor'): ?>
                                    <input type="hidden" name="action" value="demote">
                                    <button type="submit" class="padding button z-3 w-75" style="width: 100%; background: #c19066; color: #c19066; min-width: 250px;"><img style="transform:translateY(-5px);" class="w-100" src="/frontend/assets/imgs/image.png"
                                            alt="not-found">Remove Instructor</button>
                                <?php endif; ?>
                            </form>
                        </div>

                    </li>



                <?php
                endforeach;
            else: ?>
                <li class="user text-center ">No users found.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>