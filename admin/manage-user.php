<?php
include 'partials/header.php';

// fetch users from database but no current user
$current_admin_id = $_SESSION['user-id'];

// setting the page content limit and page size
$limit = 6;
$page = 1;

$query = " SELECT * FROM users WHERE NOT id=$current_admin_id AND status=0";
$users = mysqli_query($connection, $query);

$total_records = mysqli_num_rows($users);

//getting the page number sent from link
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$start = ($page - 1) * $limit;
$query_limit = "SELECT * FROM users WHERE NOT id=$current_admin_id AND status=0 LIMIT $start,$limit";
$result_limit = mysqli_query($connection, $query_limit);

$i = $start + 1;
$total_pages = ceil($total_records / $limit);
?>



<section class="dashboard">
    <?php if (isset($_SESSION['add-user-success'])): // shows if add user was successful ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-user-success'];
                unset($_SESSION['add-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-user-success'])): // shows if edit user was successful ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-user'])): // shows if edit user was Unsuccessful ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['edit-user'];
                unset($_SESSION['edit-user']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-user'])): // shows if delete user was Unsuccessful ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['delete-user'];
                unset($_SESSION['delete-user']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-user-success'])): // shows if delete user was successful ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-user-success'];
                unset($_SESSION['delete-user-success']);
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
                    <a href="index.php"><i class="uil uil-postcard"></i>
                        <h5>Manage Post</h5>
                    </a>
                </li>

                <?php
                if (isset($_SESSION['user_is_admin'])):
                    ?>

                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-user.php" class="active"><i class="uil uil-users-alt"></i>
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
            <h2>Manage Users</h2>
            <?php if ($total_records > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($result_limit)): ?>
                            <tr>
                                <td>
                                    <?= "{$user['firstname']} {$user['lastname']}" ?>
                                </td>
                                <td>
                                    <?= $user['username'] ?>
                                </td>
                                <td>
                                    <?php $id = base64_encode($user['id']); ?>
                                    <a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $id ?>" class="btn sm">Edit</a>
                                </td>
                                <td>
                                    <a href="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?>" class="btn sm danger"
                                        onclick="return confirmDelete()">Delete</a>
                                    <script>
                                        function confirmDelete() {
                                            var result = confirm("Are you sure you want to delete this user?");
                                            if (result) {
                                                return true;  // Proceed to delete-user page
                                            } else {
                                                return false; // Stay on the current page
                                            }
                                        }
                                    </script>
                                </td>
                                <td>
                                    <?= $user['is_admin'] ? "Yes" : "No" ?>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert__message error">
                    <?= "No users found" ?>
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