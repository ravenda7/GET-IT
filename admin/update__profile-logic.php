<?php
    require 'config/database.php';
    if(!isset($_SESSION['user-id'])) {
        header('location:' . ROOT_URL . 'signin.php');
        die();
    }
    
    if(isset($_POST['submit'])) {
         //gettig the input from the signup form
         $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
         $currenpassword =filter_var($_POST['currentPwd'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
         $createpassword = filter_var($_POST['newPwd'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $confirmpassword = filter_var($_POST['confirmPwd'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $avatar = $_FILES['avatar'];
         print_r($_POST);
    } else {
        header('location:' . ROOT_URL . 'admin/profile_update.php');
        die();
    }
?>