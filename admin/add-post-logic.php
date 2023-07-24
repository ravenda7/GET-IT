<?php
    require 'config/database.php';

    if(isset($_POST['submit'])) {
        $author_id = $_SESSION['user-id'];
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
        $thumbnail = $_FILES['thumbnail'];

       /*=============this is for project ===========*/
        $projects =  $_FILES['project'];
        /*=============this is for users directory ===========*/
        $sql = "SELECT foldername from users where id=$author_id";
        $result = mysqli_query($connection, $sql);
        $folder = mysqli_fetch_assoc($result);
        $folderName = $folder['foldername'];
        
        //set is_featured to 0 if unchecked
        $is_featured = $is_featured == 1 ?: 0;

        //validate form data
        if (preg_match('/^[A-Za-z].*$/', $title) === 0) {
            $_SESSION['add-post'] = "Enter a valid post title.";
        } elseif (!$category_id) {
            $_SESSION['add-post'] = "Select post category";
        }  elseif (preg_match('/^[A-Za-z].*$/m', $body) === 0) {
            $_SESSION['add-post'] = "Enter a valid post body.";
        }  elseif(!$thumbnail['name']) {
            $_SESSION['add-post'] = "Choose post thumbnail.";
        } elseif(!$projects['name']) {
            $_SESSION['add-post'] = "Choose project file.";
        } else {
            //work on thumnail

            //rename the image
            $time = time(); // make each image name unique
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../users/' . $folderName . '/images/' . $thumbnail_name;


            // make sure is an image

            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);

            if(in_array($extension, $allowed_files)) {
                // make sure is not too big.(2mb+)

                if($thumbnail['size'] < 20_000_000) {
                   // upload thumbnail
                   move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['add-post'] = "File size too big. Sould be less than 2mb.";
                }
            } else {
                $_SESSION['add-post'] = "File should be png, jpg, or jpeg.";
            }

              //rename the file
              $projects_name = $time . $projects['name'];
              $projects_tmp_name = $projects['tmp_name'];
              $projects_destination_path ='../users/' . $folderName . '/project/' . $projects_name;
              
              // make sure it is in zip
              $allowed = ['zip'];
              $ext = explode('.', $projects_name);
              $ext = end($ext);

              if(in_array($ext, $allowed)) {
                // make sure is not too big.(50mb+)

                if($projects['size'] < 50_000_000) {
                   // upload project
                   move_uploaded_file($projects_tmp_name, $projects_destination_path);
                } else {
                    $_SESSION['add-post'] = "File size too big. Sould be less than 50mb.";
                }
            } else {
                $_SESSION['add-post'] = "File should be zip.";
            }


        }
        // redirect back (with form data) to add-post page if there is any problem

        if(isset($_SESSION['add-post'])) {
            $_SESSION['add-post-data'] = $_POST;
            header('location: ' . ROOT_URL . 'admin/add-post.php');
            die();
           
        } else {
            // set is_featured of all posts to 0 if is_featured for this post is 1

            if($is_featured == 1) {
                $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
                $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
            }

            //insert post into DB
            $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured, projects) VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured, '$projects_name')";
            $result = mysqli_query($connection, $query);
            // move_uploaded_file($project_tmp_name,$project_folders);
            if(!mysqli_errno($connection)) {
               
                $_SESSION['add-post-success'] = "New post is added successfully.";
                header('location: ' . ROOT_URL. 'admin/');
                die();
            }
        }
    }
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    die();