<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
    $userId = base64_decode($_GET['id']);
    $id = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'admin/manage-user.php');
}
?>
<section class="form__section ">
    <div class="container form__section-container">
        <h2>Edit User</h2>
        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" placeholder="First Name" name="firstname" value="<?= $user['firstname'] ?>">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <input type="text" placeholder="Last Name" name="lastname" value="<?= $user['lastname'] ?>">
            <input type="text" placeholder="Username" name="username" value="<?= $user['username'] ?>">
            <select name="userrole" id="">
                <option value="0">Author</option>
                <option value="1">Amin</option>
            </select>
            <button type="submit" class="btn" name="submit">Update User</button>
        </form>
    </div>
</section>


<!--=======end of the category btn======-->
<?php
include '../partials/footer.php';
?>