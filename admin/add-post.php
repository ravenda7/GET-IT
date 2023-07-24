<?php
 include 'partials/header.php';

 // fetch categories from DB

 $query = "SELECT * FROM categories";
 $categories = mysqli_query($connection, $query);

 // get back form data if form was invalid
 $title = $_SESSION['add-post-data']['title'] ?? null;
 $body = $_SESSION['add-post-data']['body'] ?? null;

 // delete from  data session
 unset($_SESSION['add-post-data']);
 ?>
<section class="form__section  <?= $featured ? '' : 'section__extra-margin' ?>" style="padding-bottom:45rem;">
    <div class="container form__section-container">
        <h2>Add Post</h2>
        <?php if(isset($_SESSION['add-post'])): ?>
        <div class="alert__message error">
            <p>
                <?= $_SESSION['add-post'];
                    unset($_SESSION['add-post']);
                ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
           <input type="text" name="title" placeholder="Title" value="<?=$title
           ?>">
           <select name="category">
            <?php while($category = mysqli_fetch_assoc($categories)) : ?>
            <option value="<?=$category['id'] ?>"><?= $category['title'] ?></option> 
            <?php endwhile ?>
           </select>
           <textarea placeholder="Description" rows="10" name="body"><?=$body
           ?></textarea>
           <?php if(isset($_SESSION['user_is_admin'])) : ?>
           <div class="form__control inline">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" checked>
            <label for="is_featured" >Featured</label>
           </div>
           <?php endif ?>
           <div class="form__control ">
            <label for="thumbnail">Add Thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/jpg, image/jpeg, image/png">
           </div>
           <div class="form__control ">
            <label for="project">Add Project File</label>
            <input type="file" name="project" id="project">
           </div>
          <button type="submit" name="submit" class="btn">Add Post</button>
        </form>
    </div>
</section>


<!--=======end of the category btn======-->
<?php
 include '../partials/footer.php';
 ?>