<?php
// require 'config/constants.php';
require '../config/database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if(isset($_POST['send'])){
    $userId = htmlentities($_POST['userId']);
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $subject = htmlentities($_POST['subject']);
    $message = htmlentities($_POST['message']);

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'hylmokesu777@gmail.com';
    $mail->Password = 'vagghrvqywusfufk';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->isHTML(true);
    $mail->setFrom($email, $name);
    $mail->addAddress('hylmokesu777@gmail.com');
    $mail->Subject = ("$email ($subject)");
    $mail->Body = $message;
    $mail->send();
     if($mail->send()) {
         $query="INSERT INTO message(user_id, name, email, subject, message) VALUES ('$userId', '$name', '$email', '$subject', '$message')";
         $result = mysqli_query($connection, $query);
         if($result) {
            $_SESSION['email-send-successfully'] = "Email is sent successfully.";
            header('location: ' . ROOT_URL. 'contact.php');
         } else {
            $_SESSION['email-send-unsuccessfully'] = "Email is not sent.";
            header('location: ' . ROOT_URL. 'contact.php');
         }
        
     } else {
        $_SESSION['email-send-unsuccessfully'] = "Email is not sent.";
        header('location: ' . ROOT_URL. 'contact.php');
     }
}
?>