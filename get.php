<?php
require 'config/database.php';

if (isset($_POST['how'])) {
    $post_id = $_POST['data'];
    $user_id = $_SESSION['user-id'];

    if ($_POST['how'] === 'like') {
        $liked = likePost($user_id, $post_id);
        if ($liked['status'] === 1) {
            $count = $liked['count'];
            $response = array('status' => 1, 'count' => $count);
            echo json_encode($response);
        }
    } elseif ($_POST['how'] === 'unlike') {
        $unliked = unlikePost($user_id, $post_id);
        if ($unliked['status'] === 0) {
            $count = $unliked['count'];
            $response = array('status' => 0, 'count' => $count);
            echo json_encode($response);
        }
    }
}

// Function to like a post
function likePost($userId, $postId)
{
    global $connection;

    // Check if the user has already liked the post
    $query = "SELECT COUNT(*) AS liked FROM likes WHERE liker='$userId' AND liked='$postId'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['liked'] > 0) {
            // User has already liked the post
            return array('status' => 0, 'count' => null); // Return status 0 and null count
        }
    }

    // Insert a new row in the "likes" table
    $insertQuery = "INSERT INTO likes (liker, liked) VALUES ('$userId', '$postId')";
    $insertResult = mysqli_query($connection, $insertQuery);

    if (!$insertResult) {
        return array('status' => 0, 'count' => null); // Return status 0 and null count
    }

    // Update the post count in the "posts" table
    $updateQuery = "UPDATE posts SET count = count + 1 WHERE id = '$postId'";
    $updateResult = mysqli_query($connection, $updateQuery);

    if (!$updateResult) {
        return array('status' => 0, 'count' => null); // Return status 0 and null count
    }

    // Get the updated count
    $count = updatePostCount($postId, $connection);

    // Return status 1 and updated count
    return array('status' => 1, 'count' => $count);
}

// Function to unlike a post
function unlikePost($userId, $postId)
{
    global $connection;

    // Check if the user has liked the post
    $query = "SELECT COUNT(*) AS liked FROM likes WHERE liker='$userId' AND liked='$postId'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['liked'] == 0) { // Compare with == instead of ===
            // User has not liked the post
            return array('status' => 0, 'count' => null); // Return status 0 and null count
        }
    }

    // Delete the row from the "likes" table
    $deleteQuery = "DELETE FROM likes WHERE liker='$userId' AND liked='$postId'";
    $deleteResult = mysqli_query($connection, $deleteQuery);

    if (!$deleteResult) {
        return array('status' => 0, 'count' => null); // Return status 0 and null count
    }

    // Update the post count in the "posts" table
    $updateQuery = "UPDATE posts SET count = count - 1 WHERE id = '$postId'";
    $updateResult = mysqli_query($connection, $updateQuery);

    if (!$updateResult) {
        return array('status' => 0, 'count' => null); // Return status 0 and null count
    }

    // Get the updated count
    $count = updatePostCount($postId, $connection);

    // Return status 0 and updated count
    return array('status' => 0, 'count' => $count);
}

// Function to update the count of a post
function updatePostCount($postId, $connection)
{
    // Retrieve the current count of the post
    $query = "SELECT COUNT(*) AS count FROM likes WHERE liked='$postId'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }

    return null;
}
?>