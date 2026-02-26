<?php
require_once __DIR__ . "/../../../security/blockRoutes.php";
block(basename(__FILE__));

require_once __DIR__ . "/../../../env/host.php";
require_once __DIR__ . "/../../../backend/services/TeamService.php";
require_once __DIR__ . "/../../../backend/services/UserService.php";

// Fetch maps, teams, instructors, and bundles from database
$maps = DB::table('maps')->get();
$teams = TeamService::getAllTeam();
$instructors = UserService::getInstructors(null, true);
$bundles = DB::table('bundels')->get();
?>

<div class="reservation-container padding flex flex-column items-center ">
    <h1 class=" bold text-center margin " style="font-family: cursive; text-decoration: underline wavy;color:var(--brown-dark);">Choose Your Battle Mode</h1>

    <div class="toggle-container flex  gap-10 margin content-between">
        <div class="option-wrapper" id="booking-game-wrapper" style="overflow: hidden;">
            <input type="radio" name="battle-mode" id="booking-game" class="hidden-radio hidden-all" value="booking-game">
            <label for="booking-game" class="padding button flex items-center content-center bold" style="color:var(--brown-dark);">
                <img src="/frontend/assets/imgs/image.png" style="width:190%;left:unset;">
                Booking a Game
            </label>
        </div>

        <div class="option-wrapper" id="instructor-wrapper" style="overflow: hidden;">
            <input type="radio" name="battle-mode" id="instructor" class="hidden-radio hidden-all" value="instructor">
            <label for="instructor" class="padding button flex items-center content-center bold" style="color:var(--brown-dark);">
                <img src="/frontend/assets/imgs/image.png" alt="" style="width:190%; left:unset;">
                Instructor
            </label>
        </div>
    </div>

    <!-- Content Sections -->
    <div id="booking-content" class="w-100 flex flex-column items-center" style="display: none;">
        <h2 class="c-yellow margin">Game Booking Form</h2>
        
        <form action="/backend/actions/create_reservation.php" method="post" enctype="multipart/form-data" class="login-div bg-main padding w-100" style="height: auto; max-width: 800px;">
            <input type="hidden" name="type" value="game">
            
            <div class="form-gap margin grid-cl-2">
                <!-- Map Selection -->
                <fieldset class="input w-100 relative">
                    <select required id="map_id" name="map_id" class="w-100" style="background: transparent; color: white; border: 1px solid var(--white);">
                        <option value="" disabled selected>Select Map</option>
                        <?php foreach ($maps as $map): ?>
                            <option value="<?= htmlspecialchars($map['id']) ?>"><?= htmlspecialchars($map['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>

                <!-- Date Selection -->
                <fieldset class="input w-100 relative">
                    <input required type="datetime-local" id="date" name="date" class="w-100" />
                    <label for="date">Booking Date</label>
                </fieldset>
            </div>

            <h3 class="c-yellow mt-10">Payment Details (Pyamend)</h3>
            <div class="form-gap margin grid-cl-2">
                <!-- Payment Price -->
                <fieldset class="input w-100 relative">
                    <input required type="number" step="0.01" id="payment_price" name="payment_price" />
                    <label for="payment_price">Price</label>
                </fieldset>

                <!-- Payment Type -->
                <fieldset class="input w-100 relative">
                    <select required id="payment_type" name="payment_type" class="w-100" style="background: transparent; color: white; border: 1px solid var(--white);">
                        <option value="" disabled selected>Payment Type</option>
                        <option value="cash">Cash</option>
                        <option value="credit">Credit</option>
                    </select>
                </fieldset>
            </div>
            <div class="form-gap margin">
                <!-- Payment Date -->
                <fieldset class="input w-100 relative">
                    <input required type="datetime-local" id="payment_date" name="payment_date" />
                    <label for="payment_date">Payment Date</label>
                </fieldset>
            </div>

            <h3 class="c-yellow mt-10">Game Details</h3>
            <div class="form-gap margin grid-cl-2">
                <!-- Team -->
                <fieldset class="input w-100 relative">
                    <select required id="team_id" name="team_id" class="w-100" style="background: transparent; color: white; border: 1px solid var(--white);">
                        <option value="" disabled selected>Select Your Team</option>
                        <?php foreach ($teams as $team): ?>
                            <option value="<?= htmlspecialchars($team['id']) ?>"><?= htmlspecialchars($team['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>

                <!-- Opponent -->
                <fieldset class="input w-100 relative">
                    <select required id="opponent_id" name="opponent_id" class="w-100" style="background: transparent; color: white; border: 1px solid var(--white);">
                        <option value="" disabled selected>Select Opponent</option>
                        <?php foreach ($teams as $team): ?>
                            <option value="<?= htmlspecialchars($team['id']) ?>"><?= htmlspecialchars($team['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>
            </div>

            <div class="form-gap margin grid-cl-2">
                <!-- Instructor -->
                <fieldset class="input w-100 relative">
                    <select required id="instructor_id" name="instructor_id" class="w-100" style="background: transparent; color: white; border: 1px solid var(--white);">
                        <option value="" disabled selected>Select Instructor</option>
                        <?php foreach ($instructors as $inst): ?>
                            <option value="<?= htmlspecialchars($inst['id']) ?>"><?= htmlspecialchars($inst['user']['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>

                <!-- Game Duration -->
                <fieldset class="input w-100 relative">
                    <input required type="number" id="game_duration" name="game_duration" />
                    <label for="game_duration">Duration (min)</label>
                </fieldset>
            </div>

            <div class="form-gap margin">
                <!-- Bundle (Bundel) -->
                <fieldset class="input w-100 relative">
                    <select required id="bundel_id" name="bundel_id" class="w-100" style="background: transparent; color: white; border: 1px solid var(--white);">
                        <option value="" disabled selected>Select Bundle</option>
                        <?php foreach ($bundles as $bundle): ?>
                            <option value="<?= htmlspecialchars($bundle['id']) ?>"><?= htmlspecialchars($bundle['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>
            </div>

            <div class="form-gap margin flex items-center gap-10">
                <!-- Photo Upload -->
                <fieldset class="input w-100 relative">
                    <input required type="file" id="photo" name="photo" accept="image/*" onchange="previewImage(event)" />
                    <label for="photo">Photo</label>
                </fieldset>
                
                <!-- Photo Preview -->
                <div id="photo-preview-container" class="profile-img" style="display: none; width: 100px; height: 100px;">
                    <img id="photo-preview" src="#" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                </div>
            </div>

            <div class="flex gap-10 mt-10">
                <button type="submit" class="padding button w-100" style="color:var(--brown-dark);">
                    <img src="/frontend/assets/imgs/image.png" alt="">
                    Book Now
                </button>
                <button type="button" class="padding button w-100" onclick="resetToggle()" style="color:var(--brown-dark);">
                    <img src="/frontend/assets/imgs/image.png" alt="">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    <div id="instructor-content" class="w-100 flex flex-column items-center" style="display: none;">
        <h2 class="c-yellow margin">Instructor Booking Form</h2>
        
        <form action="/backend/actions/create_reservation.php" method="post" class="login-div bg-main padding w-100" style="height: auto; max-width: 800px;">
            <input type="hidden" name="type" value="instructor">
            
            <div class="form-gap margin">
                <!-- Instructor Selection -->
                <fieldset class="input w-100 relative">
                    <select required id="instructor_id_res" name="instructor_id" class="w-100" style="background: transparent; color: white; border: 1px solid var(--white);">
                        <option value="" disabled selected>Select Instructor</option>
                        <?php foreach ($instructors as $inst): ?>
                            <option value="<?= htmlspecialchars($inst['id']) ?>"><?= htmlspecialchars($inst['user']['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>
            </div>

            <h3 class="c-yellow mt-10">Payment Details</h3>
            <div class="form-gap margin grid-cl-2">
                <!-- Payment Price -->
                <fieldset class="input w-100 relative">
                    <input required type="number" step="0.01" id="payment_price_res" name="payment_price" />
                    <label for="payment_price_res">Price</label>
                </fieldset>

                <!-- Payment Type -->
                <fieldset class="input w-100 relative">
                    <select required id="payment_type_res" name="payment_type" class="w-100" style="background: transparent; color: white; border: 1px solid var(--white);">
                        <option value="" disabled selected>Payment Type</option>
                        <option value="cash">Cash</option>
                        <option value="credit">Credit</option>
                    </select>
                </fieldset>
            </div>
            <div class="form-gap margin">
                <!-- Payment Date -->
                <fieldset class="input w-100 relative">
                    <input required type="datetime-local" id="payment_date_res" name="payment_date" />
                    <label for="payment_date_res">Payment Date</label>
                </fieldset>
            </div>

            <div class="flex gap-10 mt-10">
                <button type="submit" class="padding button w-100" style="color:var(--brown-dark);">
                    <img src="/frontend/assets/imgs/image.png" alt="">
                    Book Instructor
                </button>
                <button type="button" class="padding button w-100" onclick="resetToggle()" style="color:var(--brown-dark);">
                    <img src="/frontend/assets/imgs/image.png" alt="">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .hidden-radio {
        display: none;
    }

    .reservation-container {
        min-height: 50vh;
    }

    .option-wrapper {
        transition: all 0.5s ease;
    }

    .option-wrapper.fade-out {
        opacity: 0;
        transform: scale(0.8);
        pointer-events: none;
        width: 0;
        margin: 0;
        overflow: hidden;
    }

    .toggle-container {
        width: 100%;
        max-width: 600px;
    }
    
    .grid-cl-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    
    .c-yellow { color: var(--yellow-primary); }
    .mt-10 { margin-top: 10px; }
    .w-100 { width: 100%; }
    
    select option {
        background: var(--brown-primary);
        color: white;
    }
</style>

<script>
    const bookingRadio = document.getElementById('booking-game');
    const instructorRadio = document.getElementById('instructor');
    const bookingWrapper = document.getElementById('booking-game-wrapper');
    const instructorWrapper = document.getElementById('instructor-wrapper');
    const bookingContent = document.getElementById('booking-content');
    const instructorContent = document.getElementById('instructor-content');

    const radios = document.querySelectorAll('.hidden-all');
    const toggleContainer = document.querySelector('.toggle-container');

    radios.forEach((element) => {
        element.addEventListener('click', () => {
            toggleContainer.classList.add('fade-out');
            setTimeout(() => {
                toggleContainer.style.display = 'none';
                if (element.value === "booking-game") {
                    bookingContent.style.display = 'flex';
                } else {
                    instructorContent.style.display = 'flex';
                }
            }, 500);
        });
    });

    function resetToggle() {
        toggleContainer.classList.remove('fade-out');
        toggleContainer.style.display = 'flex';
        bookingContent.style.display = 'none';
        instructorContent.style.display = 'none';
        bookingRadio.checked = false;
        instructorRadio.checked = false;
        
        // Reset preview
        document.getElementById('photo-preview-container').style.display = 'none';
        document.getElementById('photo-preview').src = '#';
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('photo-preview');
            output.src = reader.result;
            document.getElementById('photo-preview-container').style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>