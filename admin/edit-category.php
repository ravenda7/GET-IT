<?php
 include 'partials/header.php';

 if(isset($_GET['id'])) {
    $id = filter_var(base64_decode($_GET['id']), FILTER_SANITIZE_NUMBER_INT);

    //fetch category from DB
    $query = "SELECT * FROM categories WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) == 1) {
        $category = mysqli_fetch_assoc($result);
    }
 } else {
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    die();
 }
 ?>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Category</h2>
        <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">
            <input type="text" name="title" placeholder="Title" value="<?= $category['title'] ?>">
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
           <textarea name="description" placeholder="Description" rows="4"><?= $category['description'] ?></textarea>
          <button type="submit" name="submit" class="btn">Update Category</button>
        </form>
    </div>
</section>


<!--=======end of the category btn======-->
<?php
 include '../partials/footer.php';
 ?>