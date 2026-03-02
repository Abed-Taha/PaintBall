<?php
require_once ROOT . "/env/host.php";
require_once ROOT . "/backend/services/UserService.php";

$filter = isset($_GET["filter"]) ? htmlspecialchars($_GET["filter"]) : 'all';
$search = isset($_GET["search"]) ? trim(htmlspecialchars($_GET["search"])) : '';

$users = UserService::getUsersForAdmin($filter, $search, $_SESSION["user"]['id'] ?? null);
?>

<div>
    <div class="bg-main m-center flex w-75 flex-column rounded padding">
        <form action=""  class="flex gap-2 content-around items-center">
            <input type="hidden" name="v" value="admin/managePlayers">

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

            <button type="submit" class="padding button z-3 w-25"><img src="/PaintBall/frontend/assets/imgs/image.png"
                    alt="not-found">Search</button>
        </form>

        <ul>

            <?php if (!empty($users)):
                foreach ($users as $u): ?>

                    <li class="flex items-center content-between" style=" padding: 10px; border-bottom: 1px solid #ddd;padding-left:20px;">

                        <!-- Left side: User info -->
                        <div class="grid items-center" style="grid-template-columns: auto 1fr; gap: 5px;">
                            <!-- Pic + Name -->
                            <img src="/PaintBall/backend/storage/images/<?= $u["photo"] ?>" alt="not-found" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                            <p style="padding-left:20px;margin: 0; font-weight: bold;" class="c-white"><?= $u["name"] ?></p>

                            <!-- Email below, spanning both columns -->
                            <div style="grid-column: span 2; margin-left: 0;">
                                <p style="margin: 0; font-size: 14px;" class="c-white">Email: <?= $u["email"] ?></p>
                            </div>
                        </div>

                        <!-- Right side: Button -->
                        <div>
                            <form action="/PaintBall/backend/actions/userAction.php" method="post">
                                <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                <?php if (is_null($u['deleted_at'])): ?>
                                    <button type="submit" name="delete" class="padding button w-100" style="width: 100%; background: #c19066; color: #c19066; min-width: 250px;"><img style="transform:translateY(-5px);" class="w-100" src="/PaintBall/frontend/assets/imgs/image.png"
                                            alt="button-delete">Delete</button>
                                <?php else: ?>
                                    <button type="submit" name="restore" class="padding button w-100" style="width: 100%; background: #c19066; color: #c19066; min-width: 250px;"><img style="transform:translateY(-5px);" class="w-100" src="/PaintBall/frontend/assets/imgs/image.png"
                                            alt="button-restore">restore</button>
                                <?php endif; ?>
                            </form>
                        </div>

                    </li>



                <?php
                endforeach;
            else: ?>
                <li class="user text-center ">There is no user available with this selection</li>
            <?php endif; ?>
        </ul>
    </div>
</div>