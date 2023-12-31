<?php
include 'partials/header.php';

//  // fetch current user's post from DB
$current_user_id = $_SESSION['user-id'];
$userQuery = "SELECT is_admin from users where id= $current_user_id";
$result = mysqli_query($connection, $userQuery);
$admin = mysqli_fetch_assoc($result);
$is_admin = $admin['is_admin'];

if ($is_admin == 0) {
    // setting the page content limit and page size
    $limit = 6;
    $page = 1;

    $query = "SELECT * FROM posts  WHERE author_id = $current_user_id AND status=0";
    $posts = mysqli_query($connection, $query);

    $total_records = mysqli_num_rows($posts);

    //getting the page number sent from link
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }

    $start = ($page - 1) * $limit;
    $query_limit = "SELECT * FROM posts WHERE author_id = $current_user_id AND status=0 LIMIT $start,$limit";
    $result_limit = mysqli_query($connection, $query_limit);

    $i = $start + 1;
    $total_pages = ceil($total_records / $limit);


} else {

    // setting the page content limit and page size
    $limit = 6;
    $page = 1;

    //checking the data 
    $query = "SELECT * FROM posts WHERE status=0";
    $posts = mysqli_query($connection, $query);

    $total_records = mysqli_num_rows($posts);

    //getting the page number sent from link
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }

    $start = ($page - 1) * $limit;
    $query_limit = "SELECT * FROM posts WHERE status=0 LIMIT $start,$limit";
    $result_limit = mysqli_query($connection, $query_limit);

    $i = $start + 1;
    $total_pages = ceil($total_records / $limit);
}
?>



<section class="dashboard">
    <?php if (isset($_SESSION['add-post-success'])): // shows if add post was successful ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-post-success'];
                unset($_SESSION['add-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post-success'])): // shows if edit post was successful ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['edit-post-success'];
                unset($_SESSION['edit-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post'])): // shows if edit post wasn't successful ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['edit-post'];
                unset($_SESSION['edit-post']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-post-success'])): // shows if delete post was successful ?>
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
                    <a href="add-post.php"><i class="uil uil-pen"></i>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php" class="active"><i class="uil uil-postcard"></i>
                        <h5>Manage Post</h5>
                    </a>
                </li>
                <?php if ($is_admin == 0): ?>
                    <li>
                        <a href="user_analysis.php"><i class="uil uil-analytics"></i>
                            <h5>Analytics</h5>
                        </a>
                    </li>
                <?php endif ?>
                <?php
                if (isset($_SESSION['user_is_admin'])):
                    ?>
                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-user.php"><i class="uil uil-users-alt"></i>
                            <h5>Manage User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-edit"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-categories.php"><i class="uil uil-list-ul"></i>
                            <h5>Manage Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="analysis.php"><i class="uil uil-analytics"></i>
                            <h5>Analytics</h5>
                        </a>
                    </li>
                <?php endif ?>
                <li>
                    <a href="profile_update.php" class=""> <i class="uil uil-sliders-v-alt"></i>
                        <h5>Update Profile</h5>
                    </a>
                </li>
            </ul>
        </aside>
        <main>
            <h2>Manage Posts</h2>
            <?php if ($total_records > 0): ?>
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
                        <?php while ($post = mysqli_fetch_assoc($result_limit)): ?>
                            <!-- get category title of each post from categories table -->
                            <?php
                            $category_id = $post['category_id'];
                            $category_query = "SELECT title FROM categories WHERE id = $category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                            ?>
                            <tr>
                                <td>
                                    <?= $post['title'] ?>
                                </td>
                                <td>
                                    <?= $category['title'] ?>
                                </td>
                                <td>
                                    <?php $id = base64_encode($post['id']); ?>
                                    <a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $id ?>" class="btn sm">Edit</a>

                                </td>
                                <td><a href="<?= ROOT_URL ?>admin/delete-post.php?id=<?= $post['id'] ?>" class="btn sm danger"
                                        onclick="return confirmDelete()">Delete</a>
                                    <script>
                                        function confirmDelete() {
                                            var result = confirm("Are you sure you want to delete this post?");
                                            if (result) {
                                                return true;  // Proceed to delete-user page
                                            } else {
                                                return false; // Stay on the current page
                                            }
                                        }
                                    </script>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert__message error">
                    <?= "No posts found" ?>
                </div>
            <?php endif ?>

            <!--============this is for the pagination=============-->
            <div class="pagination__container">
                <div class="head-pagination-container">
                    <h4>Pages:
                        <?= $page . '/' . $total_pages ?>
                    </h4>
                </div>
                <div class="body-pagination-container">
                    <?php if ($total_records > $limit): ?>
                        <div class="pagination-btn"><a class='page-link' href='?page=1'>First</a></div>
                        <?php if ($page == 1): ?>
                            <div class="pagination-btn prev">Prev</div>
                        <?php elseif ($page > 1): ?>
                            <?php $prev = $page - 1; ?>
                            <div class="pagination-btn">
                                <li class='page-item'>
                                    <a class='page-link' href='?page=<?= $prev ?>'>Prev</a>
                            </div>
                        <?php endif; ?>

                        <?php if ($page == $total_pages): ?>
                            <div class="pagination-btn">Next</div>
                        <?php elseif ($page < $total_pages): ?>
                            <?php $next = $page + 1; ?>
                            <div class="pagination-btn">
                                <li class='page-item'>
                                    <a class='page-link' href="?page=<?= $next ?>">Next</a>
                            </div>
                        <?php endif; ?>
                        <div class="pagination-btn"><a class='page-link' href="?page=<?= $total_pages ?>">Last</a></div>


                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</section>
<!--============end of the dashboard-->
<?php
include '../partials/footer.php';
?>