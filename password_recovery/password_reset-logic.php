<?php
require '../config/database.php';

if (isset($_POST['update__password'])) {

    $email = filter_var(base64_decode($_POST['email']), FILTER_VALIDATE_EMAIL);

    $new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $token = filter_var(base64_decode($_POST['password_token']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!empty($token)) {

        if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {

            // checking token is valid or not
            $check_token = "SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($connection, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {

                if ($new_password == $confirm_password) {
                    //hash password
                    $hash_password = password_hash($new_password, PASSWORD_DEFAULT);

                    $update_password_run = mysqli_query($connection, "UPDATE users SET password='$hash_password' WHERE verify_token='$token' LIMIT 1");

                    if ($update_password_run) {
                        //updating the token
                        $new_token = md5(rand());

                        $update_token_run = mysqli_query($connection, "UPDATE users SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1");

                        $_SESSION['password-changed'] = "Password changed successfully";
                        header('location: ' . ROOT_URL . 'signin.php');
                        exit(0);
                    } else {
                        $_SESSION['something-went-wrong'] = "Did not update password. Something went wrong.";
                        header('location: ' . ROOT_URL . "password_change.php?token=$token&email=$email");
                        exit(0);
                    }

                } else {
                    $_SESSION['pwd-not-matched'] = "password and confirm password doesn't match.";
                    header('location: ' . ROOT_URL . "password_change.php?token=$token&email=$email");
                    exit(0);
                }
            } else {
                $_SESSION['invalid-token'] = "Invalid Token";
                header('location: ' . ROOT_URL . "password_change.php?token=$token&email=$email");
                exit(0);
            }

        } else {
            $_SESSION['field-required'] = "ALL filed are Mandetory";
            header('location: ' . ROOT_URL . "password_change.php?token=$token&email=$email");
            exit(0);
        }

    } else {

        $_SESSION['no-token-available'] = "No token available";
        header('location: ' . ROOT_URL . 'password_change.php');
        exit(0);

    }
}