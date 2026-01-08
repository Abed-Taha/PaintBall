<?php
if (!isset($_SESSION["user"])) {
    header("Location:/login");
    exit;
}
$user = $_SESSION["user"];
$instructor = null;
if ($user['role'] === 'instructor') {
    $instructorData = DB::select('instructors')->where('user_id', $user['id'])->get();
    if (!empty($instructorData)) {
        $instructor = $instructorData[0];
    }
}
?>

<div class="m-center w-50 bg-main rounded padding">
    <h2 class="text-center c-brown">Edit Profile</h2>
    <form action="/backend/actions/update_profile.php" method="POST" enctype="multipart/form-data" class="flex flex-column form-gap">
        
        <!-- Profile Photo Section -->
        <div class="flex content-center mb-20">
            <div class="relative profile-img " style="width: 120px; height: 120px; cursor: pointer;" onclick="document.getElementById('photoInput').click()">
                <?php 
                    $photoPath ='/backend/storage/images/' . $user["photo"];
                ?>
                <img id="photoPreview" src="<?= htmlspecialchars($photoPath) ?>" alt="Profile Photo" class="rounded" 
                     style="width: 100%; height: 100%; obejct-fit : cover ; border: 3px solid var(--brown-primary); ">
                
                <div class="absolute flex content-center items-center" 
                     style="bottom: 0; right: 0; background: var(--brown-primary); width: 35px; border-radius: 50%; height: 35px;  border: 2px solid white;">
                    <img src="/frontend/assets/imgs/edit.png" alt="Edit" style="width: 40px; border-radius: 50%; filter: invert(1);"> 
                  
                </div>
            </div>
            <input type="file" id="photoInput" name="photo" style="display: none;" accept="image/*" onchange="previewPhoto(this)" >
        </div>

        <fieldset class="input">
            <input id="name" type="text" name="name" value="<?= htmlspecialchars($user['name'])  ?>" oninput="showPasswordSection()" required />
            <label for="name">Name</label>
        </fieldset>

        <fieldset class="input">
            <input id="email" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" oninput="showPasswordSection()" required />
            <label for="email">Email</label>
        </fieldset>

        <fieldset class="input">
            <input id="phone" type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" oninput="showPasswordSection()" required />
            <label for="phone">Phone</label>
        </fieldset>

        <fieldset class="input">
            <input id="age" type="number" name="age" value="<?= htmlspecialchars($user['age']) ?>" oninput="showPasswordSection()" required />
            <label for="age">Age</label>
        </fieldset>

        <?php if ($user['role'] === 'instructor'): ?>
            <div class="input">
                <label for="skills" class="c-brown" style="font-size: 14px; margin-bottom: 5px; display: block;">Skills</label>
                <textarea oninput="showPasswordSection()" id="skills" name="skills" rows="3" class="w-100 rounded padding" style="border: 2px solid var(--brown-primary); background: transparent;"><?= htmlspecialchars($instructor['skills'] ?? '') ?> </textarea>
            </div>

            <fieldset class="input mt-10">
                <input oninput="showPasswordSection()" id="experience_years" type="number" name="experience_years" value="<?= htmlspecialchars($instructor['experience_years'] ?? '') ?>" />
                <label for="experience_years">Experience Years</label>
            </fieldset>

            <fieldset class="input">
                <input oninput="showPasswordSection()" id="price" type="number" step="0.01" name="price" value="<?= htmlspecialchars($instructor['price'] ?? '') ?>" />
                <label for="price">Price / Hour</label>
            </fieldset>

            <div class="input flex items-center gap-10">
                <input oninput="showPasswordSection()" id="available" type="checkbox" name="available" style="width: 20px; height: 20px;" <?= isset($instructor['available']) && $instructor['available'] ? 'checked' : '' ?> />
                <label for="available" style="position: static; transform: none; color: var(--brown-primary);">Available for sessions</label>
            </div>
        <?php endif; ?>

        <div class="mt-10">
        <div class="mt-10">
            <h3 class="c-brown mb-10" style="font-size: 1.1em;">Security Verification</h3>
            <p class="c-brown mb-10" style="font-size: 0.9em;">Please enter your current password to save changes.</p>
            
            <div id="password-section" class="mt-10">
                <fieldset class="input relative">
                    <input id="current_password" type="password" name="current_password" class="input-password" required />
                    <label for="current_password">Current Password (Required)</label>
                    <img src="/frontend/assets/imgs/eye-open.png" class="show-password" data-type="hide" alt="">
                </fieldset>

                <fieldset class="input relative mt-10">
                    <input id="new_password" type="password" name="new_password" class="input-password"/>
                    <label for="new_password">New Password (Optional)</label>
                    <img src="/frontend/assets/imgs/eye-open.png" class="show-password" data-type="hide" alt="">
                </fieldset>
            </div>
        </div>
        </div>

        <div class="flex content-center gap-10 mt-10">
            <button type="submit" class="button padding">
                <img src="/frontend/assets/imgs/image.png" alt="" class="w-100">
                Save Changes
            </button>
            <a href="/profile" class="button padding" style="display:flex; align-items:center; justify-content:center; text-decoration:none;">Cancel <img src="/frontend/assets/imgs/image.png" alt=""></a>
        </div>

    </form>
</div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreview').src = e.target.result;
            showPasswordSection(); // Trigger secure check visibility
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
