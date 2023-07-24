<?php
 include 'partials/header.php';

/*==========this is re-usable code for future user========*/
//  $current_user_id = $_SESSION['user-id'];
//  $query = "SELECT id, title, category_id FROM posts  WHERE author_id = $current_user_id ORDER BY id DESC";
//  $posts = mysqli_query($connection, $query);

//  // fetch current user's post from DB
$current_user_id = $_SESSION['user-id'];
$userQuery = "SELECT is_admin from users where id= $current_user_id";
$result = mysqli_query($connection,$userQuery);
$admin = mysqli_fetch_assoc($result);
$is_admin = $admin['is_admin'];

if($is_admin == 0) {
    $query = "SELECT id, title, category_id FROM posts  WHERE author_id = $current_user_id AND status=0 ORDER BY id DESC";
    $posts = mysqli_query($connection, $query);
} else {
    $query = "SELECT id, title, category_id FROM posts WHERE status=0";
    $posts = mysqli_query($connection, $query);
}
 ?>



    <section class="dashboard">
    <?php if(isset($_SESSION['add-post-success'])) : // shows if add post was successful ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['add-post-success'];
                    unset($_SESSION['add-post-success']);
                    ?>
                </p>
            </div>
        <?php elseif(isset($_SESSION['edit-post-success'])) : // shows if edit post was successful ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['edit-post-success'];
                    unset($_SESSION['edit-post-success']);
                    ?>
                </p>
            </div>
            <?php elseif(isset($_SESSION['edit-post'])) : // shows if edit post wasn't successful ?>
            <div class="alert__message error container">
                <p>
                    <?= $_SESSION['edit-post'];
                    unset($_SESSION['edit-post']);
                    ?>
                </p>
            </div>
            <?php elseif(isset($_SESSION['delete-post-success'])) : // shows if delete post was successful ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['delete-post-success'];
                    unset($_SESSION['delete-post-success']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <div class="container dashboard__container">
            <button id="show__sidebar-btn" class="sidebar__toggle">
                <i class="uil uil-angle-right-b"></i>
            </button>
            <button id="hide__sidebar-btn" class="sidebar__toggle">
                <i class="uil uil-angle-left-b"></i>
            </button>
            <aside>
                <ul>
                    <li>
                        <a href="add-post.php"><i   class="uil uil-pen"></i>
                        <h5>Add Post</h5></a>
                    </li>
                    <li>
                        <a href="index.php"  class="active"><i class="uil uil-postcard"></i>
                        <h5>Manage Post</h5></a>
                    </li>
                    <?php if($is_admin == 0):?>
                    <li>
                        <a href="user_analysis.php"><i class="uil uil-analytics"></i>
                        <h5>Analytics</h5></a>
                    </li>
                    <?php endif?>
                    <?php 
                            if(isset($_SESSION['user_is_admin'])) :
                        ?>
                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                        <h5>Add User</h5></a>
                    </li>
                    <li>
                        <a href="manage-user.php" ><i class="uil uil-users-alt"></i>
                        <h5>Manage User</h5></a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-edit"></i>
                        <h5>Add Category</h5></a>
                    </li>
                    <li>
                        <a href="manage-categories.php"><i class="uil uil-list-ul"></i>
                        <h5>Manage Category</h5></a>
                    </li>
                    <li>
                        <a href="analysis.php"><i class="uil uil-analytics"></i>
                        <h5>Analytics</h5></a>
                    </li>
                    <?php endif ?>
                    <li>
                        <a href="settings.php"><i class="uil uil-sliders-v-alt"></i></i>
                        <h5>Settings</h5></a>
                    </li>
                </ul>
            </aside>
            <main>
                <h2>Manage Posts</h2>
                <?php if(mysqli_num_rows($posts) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                            <!-- get category title of each post from categories table -->
                            <?php 
                                $category_id = $post['category_id'];
                                $category_query = "SELECT title FROM categories WHERE id = $category_id";
                                $category_result = mysqli_query($connection, $category_query);
                                $category = mysqli_fetch_assoc($category_result);
                            ?>
                        <tr>
                            <td><?= $post['title']?></td>
                            <td><?= $category['title'] ?></td>
                            <td>
                                <?php $id = base64_encode($post['id']); ?>
                                <a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?=$id?>" class="btn sm">Edit</a>

                            </td>
                            <td><a href="<?=ROOT_URL ?>admin/delete-post.php?id=<?=$post['id'] ?>" class="btn sm danger" onclick="return confirmDelete()">Delete</a>
                            <script>
                                        function confirmDelete() {
                                            var result = confirm("Are you sure you want to delete this post?");
                                            if (result) {
                                            return true;  // Proceed to delete-user page
                                            } else {
                                            return false; // Stay on the current page
                                            }
                                        }
                                        </script></td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <div class="alert__message error">
                        <?= "No posts found" ?>
                    </div>
                <?php endif ?>    
            </main>
        </div>
    </section>
<!--============end of the dashboard-->
<?php
 include '../partials/footer.php';
 ?>
