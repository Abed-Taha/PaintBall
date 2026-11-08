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

    <!-- Tabs Header -->
    <div class="tabs-header flex gap-10 margin content-center w-100">
        <button class="tab-button tab-active" data-target="booking-content">Booking a Game</button>
        <button class="tab-button" data-target="instructor-content">Instructor</button>
        <button class="tab-button" data-target="create-team-content">Create a Team</button>
        <button class="tab-button" data-target="join-team-content">Join a Team</button>
    </div>

    <!-- Content Sections -->
    <div class="tabs-content-wrapper w-100 flex flex-column items-center">
        <div id="booking-content" class="tab-content tab-active w-100 flex flex-column items-center">
            <h2 class="c-yellow margin">Game Booking Form</h2>

            <form action="/PaintBall/backend/actions/create_reservation.php" method="post" enctype="multipart/form-data" class="login-div bg-main padding w-100" style="height: auto; max-width: 800px;">
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
                        <img src="/PaintBall/frontend/assets/imgs/image.png" alt="">
                        Book Now
                    </button>
                    <button type="button" class="padding button w-100" onclick="this.closest('form').reset(); resetPreview();" style="color:var(--brown-dark);">
                        <img src="/PaintBall/frontend/assets/imgs/image.png" alt="">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <div id="instructor-content" class="tab-content w-100 flex flex-column items-center">
            <h2 class="c-yellow margin">Instructor Booking Form</h2>

            <form action="/PaintBall/backend/actions/create_reservation.php" method="post" class="login-div bg-main padding w-100" style="height: auto; max-width: 800px;">
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
                        <img src="/PaintBall/frontend/assets/imgs/image.png" alt="">
                        Book Instructor
                    </button>
                    <button type="button" class="padding button w-100" onclick="this.closest('form').reset();" style="color:var(--brown-dark);">
                        <img src="/PaintBall/frontend/assets/imgs/image.png" alt="">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <div id="create-team-content" class="tab-content w-100 flex flex-column items-center">
            <h2 class="c-yellow margin">Create a Team</h2>

            <form action="/PaintBall/backend/actions/create_team.php" method="post" enctype="multipart/form-data" class="login-div bg-main padding w-100" style="height: auto; max-width: 800px;">
                <input type="hidden" name="type" value="create_team">

                <div class="form-gap margin grid-cl-2">
                    <!-- Team Name -->
                    <fieldset class="input w-100 relative">
                        <input required type="text" id="team_name" name="team_name" placeholder=" " class="w-100" />
                        <label for="team_name">Team Name</label>
                    </fieldset>

                    <!-- Max Players -->
                    <fieldset class="input w-100 relative">
                        <input required type="number" id="max_players" name="max_players" placeholder=" " min="1" class="w-100" />
                        <label for="max_players">Max Players</label>
                    </fieldset>
                </div>

                <div class="form-gap margin flex items-center gap-10">
                    <!-- Team Photo Upload -->
                    <fieldset class="input w-100 relative">
                        <input required type="file" id="team_photo" name="team_photo" accept="image/*" onchange="previewImageTeam(event)" />
                        <label for="team_photo">Team Photo</label>
                    </fieldset>

                    <!-- Team Photo Preview -->
                    <div id="team-photo-preview-container" class="profile-img" style="display: none; width: 100px; height: 100px;">
                        <img id="team-photo-preview" src="#" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                    </div>
                </div>

                <div class="flex gap-10 mt-10">
                    <button type="submit" class="padding button w-100" style="color:var(--brown-dark);">
                        <img src="/PaintBall/frontend/assets/imgs/image.png" alt="">
                        Create Team
                    </button>
                    <button type="button" class="padding button w-100" onclick="this.closest('form').reset(); document.getElementById('team-photo-preview-container').style.display='none'; document.getElementById('team-photo-preview').src='#';" style="color:var(--brown-dark);">
                        <img src="/PaintBall/frontend/assets/imgs/image.png" alt="">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
        <div id="join-team-content" class="tab-content w-100 flex flex-column items-center">
            <h2 class="c-yellow margin">Join a Team</h2>

            <div class="search-container w-100 flex gap-10 margin" style="max-width: 800px;">
                <fieldset class="input w-100 relative">
                    <input type="text" id="team-search" placeholder=" " class="w-100" />
                    <label for="team-search">Search Team Name...</label>
                </fieldset>
            </div>

            <div id="teams-list" class="grid-cl-2 w-100 margin" style="max-width: 800px; gap: 20px;">
                <!-- Teams will be loaded here via AJAX -->
            </div>
        </div>
    </div> <!-- End tabs-content-wrapper -->
</div>

<style>
    .reservation-container {
        min-height: 50vh;
    }

    /* Tab Layout Styles */
    .tabs-header {
        border-bottom: 2px solid var(--brown-dark, #8b4513);
        margin-bottom: 20px;
        max-width: 800px;
        flex-wrap: wrap;
    }

    .tab-button {
        background: var(--brown-dark);
        border: 2px solid var(--brown-dark, #8b4513);
        border-bottom: none;
        padding: 12px 24px;
        font-size: 1.1rem;
        font-weight: bold;
        color: white;
        cursor: pointer;
        border-radius: 12px 12px 0 0;
        position: relative;
        top: 2px;
        /* Overlap border */
        transition: all 0.3s ease;
        box-shadow: 2px -2px 5px rgba(0, 0, 0, 0.1);
        font-family: cursive;
    }

    .tab-button:hover {
        background: var(--yellow-primary);
        transform: translateY(-2px);
    }

    .tab-button:not(.tab-active) {
        opacity: .75;
    }

    .tab-button.tab-active {
        background: var(--yellow-primary);
        color: var(--brown-dark);
        border-bottom: 2px solid var(--brown-dark, #8b4513);
        z-index: 1;
        box-shadow: 2px -4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Content Transition */
    .tab-content {
        display: none;
        animation: fadeIn 0.4s ease;
    }

    .tab-content.tab-active {
        display: flex;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .grid-cl-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .c-yellow {
        color: var(--yellow-primary);
    }

    .mt-10 {
        margin-top: 10px;
    }

    .w-100 {
        width: 100%;
    }

    select option {
        background: var(--brown-primary);
        color: white;
    }

    .team-card {
        background-color: var(--brown-dark);
        border: 2px solid var(--brown-primary);
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .team-card:hover {
        transform: scale(1.02);
    }

    .team-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .team-info {
        padding: 15px;
    }

    .team-info h3 {
        color: var(--yellow-primary);
        margin-bottom: 5px;
        font-family: cursive;
    }

    .team-info p {
        color: white;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove tab-active class from all buttons and contents
                tabButtons.forEach(btn => btn.classList.remove('tab-active'));
                tabContents.forEach(content => content.classList.remove('tab-active'));

                // Add tab-active class to clicked button and corresponding content
                button.classList.add('tab-active');
                const targetId = button.getAttribute('data-target');
                const targetContent = document.getElementById(targetId);

                if (targetContent) {
                    targetContent.classList.add('tab-active');
                }

                // If Join Team tab is clicked, fetch teams
                if (targetId === 'join-team-content') {
                    fetchTeams();
                }
            });
        });

        // Search input listener
        let searchTimeout;
        const searchInput = document.getElementById('team-search');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    fetchTeams(e.target.value);
                }, 500);
            });
        }
    });

    async function fetchTeams(search = '') {
        const list = document.getElementById('teams-list');
        list.innerHTML = '<div class="loader c-white">Loading teams...</div>';

        try {
            const response = await fetch(`/PaintBall/backend/actions/get_teams.php?search=${encodeURIComponent(search)}`);
            const result = await response.json();

            if (result.status === 200) {
                renderTeams(result.data, result.is_already_in_any_team);
            } else {
                list.innerHTML = `<div class="c-red">Error: ${result.message}</div>`;
            }
        } catch (error) {
            list.innerHTML = '<div class="c-red">Failed to fetch teams.</div>';
        }
    }

    function renderTeams(teams, is_already_in_any_team) {
        const list = document.getElementById('teams-list');
        if (teams.length === 0) {
            list.innerHTML = '<div class="c-white">No teams found.</div>';
            return;
        }

        list.innerHTML = teams.map(team => `
            <div class="team-card ">
             
                <img src="${team.photo ? '/PaintBall/backend/storage/images/' + team.photo : '/PaintBall/frontend/assets/imgs/image.png'}" alt="${team.name}">
                <div class="team-info">
                    <div >
                        <h3>${team.name}</h3>
                        <p>Players: ${team.current_members} </p>
                        <p>Available : ${team.max_number - team.current_members}</p>
                    </div>
                    <form action="/PaintBall/backend/actions/join_team.php" method="post" id="join-team-form">
                        <input type="hidden" name="team_id" value="${team.id}">
                    <button 
                        type="button"
                        class="padding button w-100" 
                        style="color:var(--brown-dark);" 
                        ${team.is_joined || team.current_members >= team.max_number || (is_already_in_any_team && !team.is_joined) ? 'disabled' : ''}
                    >
                        <img src="/PaintBall/frontend/assets/imgs/image.png" alt="${team.name}" onclick="document.getElementById('join-team-form').submit()"style="width:120%;transform:translateX(-10px);height:50px;">
                        ${team.is_joined ? 'Joined' : (team.current_members >= team.max_number ? 'Full' : (is_already_in_any_team ? 'Join Team' : 'Join Team'))}
                    </button>
                    </form>
                </div>
            </div>
        `).join('');
    }



    function resetPreview() {
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

    function previewImageTeam(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('team-photo-preview');
            output.src = reader.result;
            document.getElementById('team-photo-preview-container').style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>