<?php
require_once __DIR__ . "/../../security/blockRoutes.php";
block(basename(__FILE__));
?>
<?php if (!$isVerifiedPage): ?>
    <footer class="flex content-around">
        <img class="icon" src="/frontend/assets/imgs/blood-splatter.png" draggable="false" alt="">
        <img class="icon" src="/frontend/assets/imgs/blood-splatter.png" draggable="false" alt="">
        <div>
            <div>
                <h3>PaintBall</h3>
                <p>Your adventure starts here.</p>
            </div>

            <div class="flex " style="gap : 10px"> <img src="/frontend/assets/imgs/instagram.png" width="30" alt=""><img
                    src="/frontend/assets/imgs/xIcon.png" width="30" style="border-radius: 10px;" alt=""><img src="" alt="">
            </div>
        </div>
        <div class="flex content-around links-container" style="width: 500px; gap: var(--gap);">
            <div>
                <h3>Features</h3>
                <ul>
                    <li>Core features</li>
                    <li>Pro experience</li>
                    <li>Integrations</li>
                </ul>
            </div>
            <div>
                <h3>Learn more</h3>
                <ul>
                    <li>Blog</li>
                    <li>Case studies</li>
                    <li>Customer stories</li>
                    <li>Best practices</li>
                </ul>
            </div>
            <div>
                <h3>Support</h3>
                <ul>
                    <li>Contact</li>
                    <li>Support</li>
                    <li>Legal</li>
                </ul>
            </div>
        </div>

    </footer>
<?php endif; ?>

<!-- Scripts -->
<script src="/frontend/assets/js/main.js"></script>


<?php unset($_SESSION["response"]); ?>
</body>

</html>