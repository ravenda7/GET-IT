<?php
 require '../config/database.php';
//  if($_GET['id']) {
//     $id = $_GET['id'];
   if(isset($_SESSION['post-id'])) {
   $id = $_SESSION['post-id'];
    $query = "SELECT * FROM posts WHERE id=$id AND status=0 LIMIT 1";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
    $project = $post['projects'];

    $user_id = $post['author_id'];
    $get_foldername = mysqli_query($connection, "SELECT * FROM users where id=$user_id LIMIT 1");
    $get = mysqli_fetch_assoc($get_foldername);
    $foldername = $get['foldername'];
    $file ="C:/xampp/htdocs/02_project/users/$foldername/project/$project";
    $filename = basename($file);

    //set download count
    $download = mysqli_query($connection,"UPDATE posts SET downloads=downloads+1 WHERE id=$id");


// Set headers to trigger the download
header("Content-Type: application/octet-stream");
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . $filename . "\"");
readfile($file);
exit;
 } else {
    header('location: ' . ROOT_URL . 'post.php');
    die();
 }