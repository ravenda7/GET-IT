<?php
    require '../config/database.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

    function send_password_reset($get_name, $get_email, $token) {

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hylmokesu777@gmail.com';
        $mail->Password = 'vagghrvqywusfufk';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->setFrom('hylmokesu777@gmail.com', $get_name);
        $mail->addAddress($get_email);
        $mail->Subject = "Password Reset Notification";
        $en_token = base64_encode($token);
        $en_email = base64_encode($get_email);
        $mail->Body = "
        <h2>Hello</h2>
        <h3>You are receiving this email because we received a password reset request for your account.</h3>
        <br><br>
        <a href='http://localhost/02_project/password_change.php?token=$en_token&email=$en_email'> Click Here</a>";
        $mail->send();
    }

    

    if(isset($_POST['pwd__reset-link'])) {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        $token = md5(rand());

        $check_email = "SELECT email FROM users WHERE email='$email' limit 1";
        $check_email_run = mysqli_query($connection, $check_email);

        if(mysqli_num_rows($check_email_run) > 0) {
            $row = mysqli_fetch_array($check_email_run);
            $get_name = $row['name'];
            $get_email = $row['email'];

            $update_token = "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
            $update_token_run = mysqli_query($connection,$update_token);

            if($update_token_run) {
                
                send_password_reset($get_name, $get_email, $token);
                $timestamp = $_SERVER['REQUEST_TIME'];
                $_SESSION['time'] = $timestamp;

                $expire_msg = 'We e-mailed you a password reset link<br>Link will expire in <span id="timer"></span>';
                $_SESSION['send-token'] = $expire_msg;
                header('location: ' . ROOT_URL . 'forget_password.php');
                exit(0);
            } else {
                $_SESSION['something-error'] = "Something went wrong.";
                header('location: ' . ROOT_URL . 'forget_password.php');
                exit(0);
            }
        } else {
            $_SESSION['no-email'] = "No Email Found";
            header('location: ' . ROOT_URL . 'forget_password.php');
            exit(0);
        }
    }