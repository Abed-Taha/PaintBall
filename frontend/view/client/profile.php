<?php
if (!isset($_SESSION["user"])) {
    header("Location:/login");
    exit;
}
$user_id = $_GET["id"] ?? '';
if (!empty($user_id)) {
    $user = DB::select("users")->where("id", $user_id)->get();
    if (empty($user)) {
        $user = $_SESSION["user"];
    } else {
        $user = $user[0];
    }
} else {
    $user = $_SESSION["user"];
}

?>
<div class="flowY-scroll  grid form-gap">
    <div class="profile-container flex flex-column w-50 m-center items-center bg-main rounded padding">
        <div class="profile-img ">
            <img src="/backend/storage/images/<?= $user["photo"] ?>" alt="">
        </div>
        <div class="padding grid profile-items w-100 hover-brown">
            <p><span>Name : </span><?= $user["name"] ?></p>
            <p><span>Email : </span> <?= $user["email"] ?></p>
            <p><span>Phone : </span> <?= $user["phone"] ?> </p>
            <p><span>Age : </span> <?= $user["age"] ?> </p>
            <?php if ($user['role'] === 'instructor'): 
                $instructorData = DB::select('instructors')->where('user_id', $user['id'])->get();
                $instructor = !empty($instructorData) ? $instructorData[0] : null;
            ?>
                <?php if ($instructor): ?>
                    <p><span>Skills : </span> <?= htmlspecialchars($instructor["skills"]) ?> </p>
                    <p><span>Experience : </span> <?= htmlspecialchars($instructor["experience_years"]) ?> Years </p>
                    <p><span>Price/Hour : </span> $<?= htmlspecialchars($instructor["price"]) ?> </p>
                    <p><span>Available : </span> <?= $instructor["available"] ? "Yes" : "No" ?> </p>
                <?php else: ?>
                    <p><span>Instructor Info : </span> Not set yet. </p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <?php if ($_SESSION["user"]["id"] === $user["id"]): ?>
            <div class="w-100 flex content-center mt-10">
                <a href="/edit_profile" class="button padding w-75" style="display:flex; align-items:center; justify-content:center; text-decoration:none;">
                    <img src="/frontend/assets/imgs/image.png" alt="" >
                    Edit Profile
                </a>
                
            </div>
        <?php endif; ?>
    </div>



    <div class="flex felx-wrap bg-main content-around rounded">
        <div>
            <h1>Solo Carrer </h1>
        </div>
        <div>
            <h1>Team Carrer </h1>
        </div>

    </div>
</div>