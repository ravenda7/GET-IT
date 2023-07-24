<?php
 include 'partials/header.php';

    // fetch categories from DB
    $category_query ="SELECT * FROM categories";
    $categories = mysqli_query($connection, $category_query);

    
// Check if the post ID exists in the session
if (isset($_GET['id'])) {
    $postId = base64_decode($_GET['id']);
    $id = filter_var($postId, FILTER_SANITIZE_NUMBER_INT);
    // Now you have the post ID and can use it in your code
    // fetch post fata from DB if id is set
    $query = "SELECT * FROM posts WHERE id= $id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
} else {
    
   header('location: ' . ROOT_URL . 'admin/index.php');
   exit();
}
 ?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <form action="<?=ROOT_URL ?>admin/edit-post-logic.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$post['id'] ?>">
            <input type="hidden" name="previous_thumbnail_name" value="<?=$post['thumbnail'] ?>">
           <input type="text" placeholder="Title" value="<?=$post['title'] ?>" name="title">
           <select name="category" id="">
            <?php while($category = mysqli_fetch_assoc($categories)) : ?>
            <option value="<?= $category['id']?>"><?=$category['title'] ?></option>
            <?php endwhile ?>
           </select>
           <textarea placeholder="Body" name="body" rows="10"><?= $post['body']?></textarea>
           <div class="form__control inline">
            <input type="checkbox" id="is_featured" name="is_featured" checked value="1">
            <label for="is_featured" >Featured</label>
           </div>
           <div class="form__control ">
            <label for="thumbnail">Change Thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail">
           </div>
          <button type="submit" name="submit" class="btn">Update Post</button>
        </form>
    </div>
</section>


<!--=======end of the category btn======-->
<?php
 include '../partials/footer.php';
 ?>