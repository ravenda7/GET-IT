<?php
include 'partials/header.php';
//get back from the data if there was a registration error
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
//delet the session signup-data after getting data
unset($_SESSION['signup-data'])
    ?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Sign Up</h2>
        <?php if (isset($_SESSION['signup'])): ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['signup'];
                    unset($_SESSION['signup']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>login_logic/signup-logic.php" enctype="multipart/form-data" method="post">
            <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name" pattern="[a-zA-Z]+"
                oninvalid="this.setCustomValidity('Please enter alphabetic characters only')"
                oninput="this.setCustomValidity('')">
            <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name" pattern="[a-zA-Z]+"
                oninvalid="this.setCustomValidity('Please enter alphabetic characters only')"
                oninput="this.setCustomValidity('')">
            <input type="text" name="username" value="<?= $username ?>" pattern="[a-zA-Z0-9]+" placeholder="Username"
                oninvalid="this.setCustomValidity('Please enter alphanumeric characters only')"
                oninput="this.setCustomValidity('')">
            <input type="text" name="email" value="<?= $email ?>" placeholder="Email">
            <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password">
            <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>"
                placeholder="Confirm Password">
            <div class="form__control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar" accept="image/jpg, image/jpeg, image/png">
            </div>
            <button type="submit" name="submit" class="btn">Sign Up</button>
            <small>Already have an account? <a href="signin.php">Sign In</a></small>
        </form>
    </div>
</section>
<?php
include 'partials/footer.php'
    ?>