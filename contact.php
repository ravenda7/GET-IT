<?php
include 'partials/header.php';
if (!isset($_SESSION['user-id'])) {
    header('location: ' . ROOT_URL);
    die();
} else {
    $id = $_SESSION['user-id'];
    $query = mysqli_query($connection, "SELECT firstname, lastname, email FROM users WHERE id=$id");
    $get_data = mysqli_fetch_assoc($query);
}
?>
<section class="form__section">
    <div class="container form__section-container">
        <?php if (isset($_SESSION['email-send-successfully'])): ?>
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['email-send-successfully'];
                    unset($_SESSION['email-send-successfully']);
                    ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['email-send-unsuccessfully'])): ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['email-send-unsuccessfully'];
                    unset($_SESSION['email-send-unsuccessfully']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <h2>Send Us A Message</h2>
        <form action="<?= ROOT_URL ?>send_message/email_send_logic.php" method="post">
            <input type="text" name="name" placeholder="Enter Your Name"
                value="<?= $get_data['firstname'] . ' ' . $get_data['lastname']; ?>">
            <input type="text" name="email" placeholder="Enter Your Email" value="<?= $get_data['email']; ?>">
            <input type="text" name="subject" placeholder="Enter Subject">
            <input type="hidden" name="userId" value="<?= htmlspecialchars($_SESSION['user-id']); ?>">
            <textarea placeholder="Write Your Message" rows="10" name="message"></textarea>
            <button type="submit" name="send" class="btn">Send Message</button>
        </form>
    </div>
</section>

<?php
include 'partials/footer.php';
?>