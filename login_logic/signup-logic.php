<?php

    // require 'config/constants.php';
    require '../config/database.php';

    //get signup from data if signup form button was clicked
    if(isset($_POST['submit'])) {
        //gettig the input from the signup form
        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $avatar = $_FILES['avatar'];


        // Function to generate a unique folder name
        function generateUniqueFolderName() {
            $folderName = uniqid(); // Using uniqid() function to generate a unique ID
            return $folderName;
        }

        // Create a unique folder name for the user
        $folderName = generateUniqueFolderName();

        //validate input values
        if(!$firstname) {
            $_SESSION['signup'] = "Please enter your First Name";
        } elseif (!$lastname) {
            $_SESSION['signup'] = "Please enter your Last Name";
        } elseif (!$username) {
            $_SESSION['signup'] = "Please enter your Username";
        } elseif (!$email) {
            $_SESSION['signup'] = "Please enter your a valid email";
        } elseif (strlen($createpassword) < 8) {
            $_SESSION['signup'] = "Password should be 8+ characters";
        } elseif (!$avatar['name']) {
            $_SESSION['signup'] = "Please add avatar";
        } else {
            //check if password dont't match
            if($createpassword !== $confirmpassword) {
                $_SESSION['signup'] = "Password do not match";
            } else {
                //hash password
                $hash_password = password_hash($createpassword,PASSWORD_DEFAULT);

                // check if username or email already existed in DB\
                $user_check_query = " SELECT * FROM users WHERE username='$username' OR email='$email'";
                $user_check_result = mysqli_query($connection, $user_check_query);
                if(mysqli_num_rows($user_check_result) > 0) {
                    $_SESSION['signup'] = "Username or Email already exits";
                } else {

                     // Create the folder
                        $folderPath = '../users/' . $folderName; // Replace "path/to/folder/" with the desired path
                        if (!file_exists($folderPath)) {
                            if (mkdir($folderPath, 0755, true)) { // Creates the folder with the specified permissions
                                echo "Folder created successfully!";
                                // Create 'images' folder
                                    $imagesFolderPath = $folderPath . '/images';
                                    if (mkdir($imagesFolderPath, 0755, true)) {
                                        echo "Images folder created successfully!";
                                    } else {
                                        echo "Failed to create images folder.";
                                    }
                                    
                                    // Create 'projects' folder
                                    $projectsFolderPath = $folderPath . '/project';
                                    if (mkdir($projectsFolderPath, 0755, true)) {
                                        echo "Projects folder created successfully!";
                                    } else {
                                        echo "Failed to create projects folder.";
                                    }
                              
                            } else {
                                echo "Failed to create folder.";
                            }
                        } else {
                            echo "Folder already exists.";
                        }


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
                }
            }
        }
        // redirect back to signup if there is an error
        if($_SESSION['signup']) {
            // pass from data back to signup page
            $_SESSION['signup-data'] = $_POST;
            header('location:' .ROOT_URL . 'signup.php');
            die();
        } else {
            //insert new user into table
            $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin, foldername) VALUES ('$firstname', '$lastname', '$username', '$email', '$hash_password', '$avatar_name', 0, '$folderName')";
            $insert_use_result = mysqli_query($connection, $insert_user_query);
            if(!mysqli_errno($connection)) {
                // redirect to login page with success message
                $_SESSION['signup-success'] = "Registration successfully. You can login now";

                header('location: ' .ROOT_URL . 'signin.php');
                die();
            }

        }
    } else {
        //if button was not clicked redirect to sign up  page
        header('location:' .ROOT_URL . 'signup.php');
        die();
    }
?>