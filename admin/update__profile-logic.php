<?php
    require 'config/database.php';

    if(!isset($_SESSION['user-id'] )) {
        header('location:' . ROOT_URL . 'signin.php');
        die();
    }

    if(isset($_POST['submit'])){
         //gettig the input from the signup form
         $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
         $avatar = $_FILES['avatar'];
         $id = $_SESSION['user-id'];

         //fetch the folder name
         $sql = mysqli_query($connection, "SELECT foldername from users where id=$id and status=0");
         $fetch = mysqli_fetch_assoc($sql);
         $folderName = $fetch['foldername'];
         $folderPath = '../users/' . $folderName;

        if(!$avatar['name'] == '') {
            //work on avatar
                    // rename avatar
                    $time = time();//this is always going to unique so we use this as the name of the avatar
                    $avatar_name = $time . $avatar['name'];
                    $avatar_temp_name = $avatar['tmp_name'];
                    // $avatar_destination_path = 'images/' . $avatar_name;
                    $avatar_destination_path =  $folderPath . '/images/' . $avatar_name;
                  

                    //make sure file is an image
                    $allowed_files = ['png', 'jpg', 'jpeg'];
                    $extension = explode('.', $avatar_name);
                    $extension = end($extension);
                    if(in_array($extension, $allowed_files)) {
                        // make sure image is not too large (5mb +)
                        if($avatar['size'] < 10000000) {
                            // upload avatar
                            move_uploaded_file($avatar_temp_name, $avatar_destination_path);

                        } else {
                            $_SESSION['signup'] = "file size too big. should be less than 5MB";
                        }
                    } else {
                        $_SESSION['signup'] = "file should be png, jpg or jpeg";
                    }

                    //insert new user into table
            $update_user_query = "UPDATE users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email',avatar='$avatar_name' where id=$id";
            $update_user_result = mysqli_query($connection, $update_user_query);
            if(!mysqli_errno($connection)) {
                // redirect to profile update with success message
                $_SESSION['update-success'] = "Profile update successfully.";
                header('location: ' .ROOT_URL . 'admin/profile_update.php');
                die();
            }
        } else {
           
                    //insert new user into table
                    $update_user_query = "UPDATE users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email' where id=$id";
                    $update_user_result = mysqli_query($connection, $update_user_query);
                    if(!mysqli_errno($connection)) {
                        // redirect to profile update page with success message
                        $_SESSION['update-success'] = "Profile update successfully.";

                        header('location: ' .ROOT_URL . 'admin/profile_update.php');
                        die();
                    }
        }
    } else {
        header('location: ' .ROOT_URL . 'admin/profile_update.php');
        die();
    }
?>