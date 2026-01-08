<div>
    <!-- Contact Information -->
    <div class="flex flex-column  padding text-center bg-main w-50 m-center c-white">
        <h2>Get in Touch</h2>
        <p>Have questions? Want to book a match?
            Feel free to contact our team anytime!</p>

        <p><strong>📍 Location:</strong> Beirut, Lebanon</p>
        <p><strong>📞 Phone:</strong> +961 71 123 456</p>
        <p><strong>📧 Email:</strong> support@paintballarena.com</p>

        <h2>Opening Hours</h2>
        <p>Monday – Friday: 10 AM – 8 PM</p>
        <p>Saturday – Sunday: 9 AM – 11 PM</p>
    </div>

    <!-- Contact Form -->
    <div class="form-box">
        <h2 class="text-center c-white">Send a Message</h2>

        <form action="send_message.php" class=" login-div flex flex-column w-100 padding content-around bg-main"
            style="height: 250px;" method="POST">
            <fieldset class="input">
                <input type="text" name="name" required>
                <label for="">Your Full Name</label>
            </fieldset>
            <fieldset class="input">
                <input type="text" name="name" required>
                <label for="">Your Email Address</label>
            </fieldset>
            <fieldset class="input">
                <input type="text" name="name" required>
                <label for="">Subject</label>
            </fieldset>
            <fieldset class="input">
                <input type="text" name="name" required>
                <label for="">Subject</label>
            </fieldset>

            <textarea name="message" rows="6" class="input" placeholder="Write your message..." required></textarea>

            <button type="submit" class="button"> <img src="/frontend/assets/imgs/image.png" alt="">Send
                Message</button>
        </form>
    </div>
</div>