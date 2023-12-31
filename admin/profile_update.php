<?php
include 'partials/header.php';

if (isset($_SESSION['user-id'])) {
    $userId = $_SESSION['user-id'];
    $id = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id=$id AND status=0";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

} else {
    header('location: ' . ROOT_URL . 'signin.php');
}
?>

<section class="update__profile-section ">
    <div class="container form__section-container">
        <h2>Edit User</h2>
        <?php if (isset($_SESSION['update'])): ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['update'];
                    unset($_SESSION['update']);
                    ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['update-success'])): ?>
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['update-success'];
                    unset($_SESSION['update-success']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form class="update__profile-form" id="form" action="update__profile-logic.php" enctype="multipart/form-data"
            method="post">

            <div class="outer_profile-update">
                <div class="left__profile-update">
                    <input type="text" placeholder="First Name" name="firstname" value="<?= $user['firstname'] ?>">
                    <input type="text" placeholder="Last Name" name="lastname" value="<?= $user['lastname'] ?>">
                    <input type="text" placeholder="Username" name="username" value="<?= $user['username'] ?>">
                </div>
                <div class="right__profile-update">
                    <div class="profile_update">
                        <img src="<?= ROOT_URL . 'users/' . $avatar['foldername'] . '/images/' . $avatar['avatar'] ?>"
                            id="image">

                        <div class="rightRound" id="upload">
                            <input type="file" name="avatar" id="fileImg" accept=".jpg, .jpeg, .png">
                            <i class="fa fa-camera"></i>
                        </div>

                        <div class="leftRound" id="cancel" style="display: none;">
                            <i class="fa fa-times"></i>
                        </div>
                    </div>
                </div>
            </div>
            <input type="text" placeholder="Email" name="email" value="<?= $user['email'] ?>">

            <button type="submit" class="btn" name="submit">Update</button>
        </form>

        <h2>Change Password</h2>
        <?php if (isset($_SESSION['u_error'])): ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['u_error'];
                    unset($_SESSION['u_error']);
                    ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['u_success'])): ?>
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['u_success'];
                    unset($_SESSION['u_success']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form class="update__profile-form" action="update__profile_password-logic.php" method="post">
            <div class="password-container">
                <input type="password" placeholder="Old Password" name="Old_password" id="password-field">
                <span class="eye-icon" id="toggle-password">
                    <i class="fa-solid fa-eye-slash" id="this_toggle"></i>
                </span>
            </div>
            <input type="text" placeholder="New Password" name="New_password">
            <input type="text" placeholder="Confirm Password" name="Confirm_password">

            <button type="submit" class="btn" name="submit">Update</button>
        </form>
    </div>
</section>
<script src="../js/toggle.js"></script>
<script type="text/javascript">
    document.getElementById("fileImg").onchange = function () {
        document.getElementById("image").src = URL.createObjectURL(fileImg.files[0]); // Preview new image
        document.getElementById("cancel").style.display = "block";
        document.getElementById("upload").style.display = "none";
    }

    var userImage = document.getElementById('image').src;
    document.getElementById("cancel").onclick = function () {
        document.getElementById("image").src = userImage; // Back to previous image
        document.getElementById("cancel").style.display = "none";
        document.getElementById("upload").style.display = "block";
    }
</script>

<!--=======end of the category btn======-->
<?php
include '../partials/footer.php';
?>