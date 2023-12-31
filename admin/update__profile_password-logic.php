<?php
require 'config/database.php';

if (!isset($_SESSION['user-id'])) {
    header('location:' . ROOT_URL . 'signin.php');
    die();
}

if (isset($_POST['submit'])) {
    $Oldpassword = filter_var($_POST['Old_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Newpassword = filter_var($_POST['New_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Confirmpassword = filter_var($_POST['Confirm_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $UserID = $_SESSION['user-id'];

    if (!$Oldpassword) {
        $_SESSION['u_error'] = "Please Enter the Old Password";
    } elseif (!$Newpassword) {
        $_SESSION['u_error'] = "Please Enter the Old Password";
    } elseif (!$Confirmpassword) {
        $_SESSION['u_error'] = "Please Enter the Old Password";
    } elseif (strlen($Newpassword) < 8) {
        $_SESSION['u_error'] = "Password Character Must Be 8+ ";
    } else {
        $fetch_user_query = "SELECT * FROM users WHERE id = $UserID";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if (mysqli_num_rows($fetch_user_result) == 1) {
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];
            // compare form password with database password
            if (password_verify($Oldpassword, $db_password)) {
                if ($Newpassword == $Confirmpassword) {
                    $hash_password = password_hash($Newpassword, PASSWORD_DEFAULT);
                    $query = "UPDATE users SET password = '$hash_password' WHERE id = $UserID";
                    $execute = mysqli_query($connection, $query);

                    if ($execute) {
                        $_SESSION['u_success'] = "Password has been changed successfully.";
                        header('location: ' . ROOT_URL . 'admin/profile_update.php');
                        die();
                    } else {
                        $_SESSION['u_error'] = "Unable to change the password.";
                    }
                } else {
                    $_SESSION['u_error'] = "Password Doesn't Matched.";
                }
            } else {
                $_SESSION['u_error'] = "Old Password Doesn't Matched.";
            }
        } else {
            $_SESSION['u_error'] = "Something Went Wrong.";
        }
    }

    if ($_SESSION['u_error']) {
        header('location: ' . ROOT_URL . 'admin/profile_update.php');
        die();
    }

} else {
    header('location: ' . ROOT_URL . 'admin/profile_update.php');
    die();
}
?>