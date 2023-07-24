<?php
    require 'config/database.php';

    if(isset
    ($_GET['id'])) {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        // fetch post from DB in order to delete thumbnail from image folder
        $query = "UPDATE posts SET status = 1 WHERE id = $id";
        $result =mysqli_query($connection, $query);

                if (!mysqli_errno($connection)) {
                    $_SESSION['delete-post-success'] = "Post deleted successfully";
                }
    }
    header('location: ' . ROOT_URL . 'admin/');
    die();