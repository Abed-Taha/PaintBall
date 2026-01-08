<?php
require_once __DIR__ . "/../../../env/host.php";

$filter = isset($_GET["filter"]) ? htmlspecialchars($_GET["filter"]) : 'all';
$search = isset($_GET["search"]) ? trim(htmlspecialchars($_GET["search"])) : '';

$query = DB::select('users')
    ->where('id', '!=', (int) $_SESSION["user"]['id']);


switch ($filter) {
    case "deleted":
        $query->whereNotNull("deleted_at");
        break;
    case "active":
        $query->whereNull("deleted_at");
        break;
    case "all":
}


if (!empty($search)) {
    $query->where('name', 'LIKE', "%$search%");
}

$users = $query->get();
?>

<div>
    <div class="bg-main m-center flex w-75 flex-column rounded padding">
        <form action="" method="get" class="flex gap-2 content-around items-center">

            <!-- Filter Dropdown -->
            <select name="filter" class="text-center" onchange="this.form.submit()">
                <option value="all" <?= $filter === "all" ? "selected" : "" ?>>All Users</option>
                <option value="active" <?= $filter === "active" ? "selected" : "" ?>>Active Users</option>
                <option value="deleted" <?= $filter === "deleted" ? "selected" : "" ?>>Deleted Users</option>
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

                    <li class="flex user items-center content-between padding">
                        <img src="/backend/storage/images/<?= $u["photo"] ?>" alt="not-found">
                        <p>Name : <?= $u["name"] ?></p>
                        <p>Email : <?= $u["email"] ?></p>
                        <div>
                            <form action="/backend/actions/userAction.php">
                                <input type="text" name="id" hidden value="<?= $u['id'] ?>">
                                <?php if (is_null($u['deleted_at'])): ?>
                                    <button type="submit" name="delete" class="padding button z-3"><img
                                            src="/frontend/assets/imgs/image.png" alt=""
                                            style="transform: translateY(-15px);">Delete</button>
                                <?php else: ?>
                                    <button type="submit" name="restore" class="padding button z-3"><img
                                            src="/frontend/assets/imgs/image.png" alt=""
                                            style="transform: translateY(-15px);">Restore</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </li>
                </ul>
                <?php
                endforeach;
            else: ?>
            <li class="user text-center ">There is no user available with this selection</li>
        <?php endif; ?>
    </div>
</div>