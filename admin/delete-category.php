<?php 
    require 'config/database.php';

    if(isset($_GET['id'])) {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        // for later
        // update category_id of post that belong to this category to id of uncategorized category
        $update_query = "UPDATE posts SET category_id = 9 WHERE category_id=$id";
        $update_result = mysqli_query($connection, $update_query);



        if(!mysqli_errno($connection)) {
             // delete category
        $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
        if($result) {
            $_SESSION['delete-category-success'] = "Category deleted successfully";
        } else {
            $_SESSION['delete-category'] = "Unable to delete category";
        }
        }
    }
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    die();