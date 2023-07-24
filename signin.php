<?php
 require 'config/encryption.php';
 require 'partials/header.php';

if (isset($_COOKIE['username_email']) && isset($_COOKIE['password'])) {
    $encryptedUsernameEmail = $_COOKIE['username_email'];
    $encryptedPassword = $_COOKIE['password'];
    $encryptionKey = $key; // Replace with your own encryption key
    $username_email = decryptCookieValue($encryptedUsernameEmail, $encryptionKey);
    $password = decryptCookieValue($encryptedPassword, $encryptionKey);
} else {
    $username_email = "";
    $password = "";
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Sign In</h2>
        <?php if(isset($_SESSION['signup-success'])) : ?>
        <div class="alert__message success">
            <p>
                <?= $_SESSION['signup-success'];
                unset($_SESSION['signup-success']);
                ?>
            </p>
        </div>
        <?php elseif(isset($_SESSION['signin'])) : ?>
            <div class="alert__message error">
            <p>
                <?= $_SESSION['signin'];
                unset($_SESSION['signin']);
                ?>
            </p>
        </div>
        <?php elseif(isset($_SESSION['password-changed'])) : ?>
        <div class="alert__message success">
            <p>
                <?= $_SESSION['password-changed'];
                unset($_SESSION['password-changed']);
                ?>
            </p>
        </div>
        <?php elseif(isset($_SESSION['login-first'])) : ?>
        <div class="alert__message error">
            <p>
                <?= $_SESSION['login-first'];
                unset($_SESSION['login-first']);
                ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>login_logic/signin-logic.php" method="POST">
            <input type="text" name="username_email" value="<?=$username_email ?>" placeholder="Username or Email">
            <input type="password" name="password" value="<?=$password ?>" placeholder="Password">
            <label for="">
                <input type="checkbox" name="remember_me"> Remember me
            </label>
          <button type="submit" name="submit" class="btn">Sign In</button>
          <small style="display:flex;justify-content:space-between;"><span>Don't have an account? <a href="signup.php" style="text-decoration:underline">Sign Up</a></span> 
          <a href="forget_password.php"  style="text-decoration:underline"  >Forget Password?</a>
          </small>
        </form>
    </div>
</section>

