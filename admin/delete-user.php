<?php 
    require 'config/database.php'; 

    if(isset($_GET['id'])) {
        // fetch user from database
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
        // retrieve user's information from the database
        $get_user_query = "SELECT firstname, lastname FROM users WHERE id = $id";
        $get_user_result = mysqli_query($connection, $get_user_query);
        $user = mysqli_fetch_assoc($get_user_result);
    
        // delete user from database
        $delete_user_query = "UPDATE users SET status = 1 WHERE id = $id";
        $delete_user_result = mysqli_query($connection, $delete_user_query);

         // remove posts related to users from database
         $delete_post_query = "UPDATE posts SET status = 1 WHERE author_id = $id";
         $delete_post_result = mysqli_query($connection, $delete_post_query);
    
        if(mysqli_errno($connection)) {
            $_SESSION['delete-user'] = "Couldn't delete '{$user['firstname']}' '{$user['lastname']}'";
        } else {
            $_SESSION['delete-user-success'] = "'{$user['firstname']}' '{$user['lastname']}' is successfully deleted.";
        }
    }
    

    header('location: ' . ROOT_URL . 'admin/manage-user.php');
    die();











/*=================re-usable code for future==========*/
    // <?php 
    // require 'config/database.php'; 

    // if(isset($_GET['id'])) {
    //     // fetch user from database
    //     $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //     // fetch user from database 
    //     $query = "SELECT * FROM users WHERE id=$id";
    //     $result = mysqli_query($connection, $query);
    //     $user = mysqli_fetch_assoc($result);

    //     //make sure we got back only one user
    //     if(mysqli_num_rows($result) == 1) {
    //         $avatar_name = $user['avatar'];
    //         $avatar_path = '../images/' . $avatar_name;

    //         //delete image if avaiable
    //         if($avatar_path) {
    //             unlink($avatar_path);
    //         }
    //     }

    //     // for later
    //     //fetch all thumnnails of user's post and delete them
    //     $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id = $id";
    //     $thumbnails_result = mysqli_query($connection, $thumbnails_query);
    //     if(mysqli_num_rows($thumbnails_result) > 0) {
    //         while($thumbnail = mysqli_fetch_assoc($thumbnails_result)) {
    //             $thumbnail_path = '../images/' . $thumbnail['thumbnail'];
    //             // delete thumbnail form images folder is exist
    //             if($thumbnail_path) {
    //                 unlink($thumbnail_path);
    //             }
    //         }
    //     }



    //     //delete user from database
    //     $delete_user_query = "DELETE FROM users WHERE id=$id";
    //     $delete_user_result = mysqli_query($connection, $delete_user_query);

    //     if(mysqli_errno($connection)) {
    //         $_SESSION['delete-user'] = "Couldn't delete '{$user['firstname']}' '{$user['lastname']}' ";
    //     } else {
    //         $_SESSION['delete-user-success'] = " '{$user['firstname']}' '{$user['lastname']}' is successfully deleted.";
    //     }
    // }

    // header('location: ' . ROOT_URL . 'admin/manage-user.php');
    // die();