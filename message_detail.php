<?php
require 'partials/header.php';
if (isset($_GET['id'])) {
    $encrypted_id = $_GET['id']; // Retrieve the encrypted ID from the URL parameter
    $msg_id = base64_decode($encrypted_id);

    $query = "SELECT * FROM message WHERE id=$msg_id AND status=0";
    $msg = mysqli_query($connection, $query);
    if ($msg) {
        $m = mysqli_fetch_assoc($msg);
        $user_id = $m['user_id'];
        $query_id = "SELECT foldername, avatar FROM users WHERE id=$user_id";
        $run = mysqli_query($connection, $query_id);
        if ($run) {
            $author = mysqli_fetch_assoc($run);
            $query = mysqli_query($connection, "UPDATE message SET is_shown=1 WHERE id=$msg_id");
        } else {
            header('location: ' . ROOT_URL . 'message.php');
            die();
        }
    } else {
        header('location: ' . ROOT_URL . 'message.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'message.php');
    die();
}




?>

<section class="message__section  <?= $featured ? '' : 'section__extra-margin' ?>">
    <div class="container message__container">
        <h2>Messages</h2>
        <div class="popOut">
            <div class="inner__popout">
                <div class="header_pop">
                    <div class="user__message-info">
                        <div class="image_pop">
                            <img src="./users/<?= $author['foldername'] ?>/images/<?= $author['avatar'] ?>" alt="">
                        </div>
                        <div class="name_pop">
                            <h2>
                                <?= $m['name'] ?>
                            </h2>
                        </div>
                    </div>
                    <div class="close_pop-icon">
                        <a href="<?= ROOT_URL ?>message.php?">
                            <i class="uil uil-multiply"></i>
                        </a>
                    </div>
                </div>
                <div class="body_pop">
                    <div class="email_pop">
                        <div class="email__body">
                            <h3>From:</h3>
                        </div>
                        <div class="email__address">
                            <p>
                                <?= $m['email'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="subject_pop">
                        <div class="subject__title">
                            <h3>Subject:</h3>
                        </div>
                        <div class="subject__detail">
                            <p>
                                <?= $m['subject'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="message_pop">
                        <p>
                            <?= $m['message'] ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php
include 'partials/footer.php';
?>