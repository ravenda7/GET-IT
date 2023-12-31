<?php
require '../config/database.php';

if (isset($_GET['msg_id'])) {
    // fetch user from database
    $id = filter_var($_GET['msg_id'], FILTER_SANITIZE_NUMBER_INT);

    // delete msg from database
    $delete_msg_query = "UPDATE message SET status = 1 WHERE id = $id";
    $delete_msg_result = mysqli_query($connection, $delete_msg_query);

    if (mysqli_errno($connection)) {
        $_SESSION['delete-msg'] = "Couldn't delete message";
    } else {
        $_SESSION['delete-msg-success'] = "Message is successfully deleted.";
    }
}

header('location: ' . ROOT_URL . 'message.php');
die();
?>