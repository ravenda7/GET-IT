<?php
require 'config/database.php';

if (!isset($_GET['token']) && !isset($_GET['email'])) {
    header('location: ' . ROOT_URL . 'forget_password.php');
    die();
} elseif ($_SERVER['REQUEST_TIME'] - $_SESSION['time'] > 60) {
    $_SESSION['expire_time'] = "linked is expired";
    header('location: ' . ROOT_URL . 'forget_password.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--============cdn for icon scout========-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/mode.css">
    <title>Document</title>
</head>

<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Change Password</h2>
            <?php if (isset($_SESSION['no-token-available'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['no-token-available'];
                        unset($_SESSION['no-token-available']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['pwd-not-matched'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['pwd-not-matched'];
                        unset($_SESSION['pwd-not-matched']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['something-went-wrong'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['something-went-wrong'];
                        unset($_SESSION['something-went-wrong']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['invalid-token'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['invalid-token'];
                        unset($_SESSION['invalid-token']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['field-required'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['field-required'];
                        unset($_SESSION['field-required']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>password_recovery/password_reset-logic.php" method="POST">
                <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) {
                    echo $_GET['token'];
                } ?>">
                <input type="hidden" name="email" value="<?php if (isset($_GET['email'])) {
                    echo $_GET['email'];
                } ?>">
                <input type="password" name="new_password" placeholder="New Password">
                <input type="password" name="confirm_password" placeholder="Confirm Password">
                <button type="submit" name="update__password" class="btn">Submit</button>
            </form>
        </div>
    </section>
    <script src="js/mode.js"></script>
</body>

</html>