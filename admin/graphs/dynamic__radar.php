<?php
    $currentUserID = $_SESSION['user-id'];

$query = "SELECT posts.id, posts.title, posts.date_time, categories.title AS category_title, posts.count, posts.downloads, posts.views 
          FROM posts
          INNER JOIN categories ON posts.category_id = categories.id
          WHERE posts.author_id = $currentUserID";
$result = mysqli_query($connection, $query);

$postsData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $postsData[] = $row;
}
?>

