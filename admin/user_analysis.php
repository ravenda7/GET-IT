<?php
 include 'partials/header.php';
 $current_user_id = $_SESSION['user-id'];
 //fetching data from db
 $query = "SELECT id, title, category_id FROM posts WHERE status=0 AND author_id=$current_user_id";
 $posts = mysqli_query($connection, $query);
 ?>


<section class="dashboard">

    <?php if(isset($_SESSION['add-category-success'])) : // shows if add category was successful ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['add-category-success'];
                    unset($_SESSION['add-category-success']);
                    ?>
                </p>
            </div>
            <?php elseif(isset($_SESSION['add-category'])) : // shows if add category wasn't successful ?>
            <div class="alert__message error container">
                <p>
                    <?= $_SESSION['add-category'];
                    unset($_SESSION['add-category']);
                    ?>
                </p>
            </div>
            <?php elseif(isset($_SESSION['edit-category'])) : // shows if edit category wasn't successful ?>
            <div class="alert__message error container">
                <p>
                    <?= $_SESSION['edit-category'];
                    unset($_SESSION['edit-category']);
                    ?>
                </p>
            </div>
            <?php elseif(isset($_SESSION['edit-category-success'])) : // shows if edit category was successful ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['edit-category-success'];
                    unset($_SESSION['edit-category-success']);
                    ?>
                </p>
            </div>
            <?php elseif(isset($_SESSION['delete-category-success'])) : // shows if delete category was successful ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['delete-category-success'];
                    unset($_SESSION['delete-category-success']);
                    ?>
                </p>
            </div>
            <?php elseif(isset($_SESSION['delete-category'])) : // shows if delete category wasn't successful ?>
            <div class="alert__message error container">
                <p>
                    <?= $_SESSION['delete-category'];
                    unset($_SESSION['delete-category']);
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
                        <a href="index.php"><i class="uil uil-postcard"></i>
                        <h5>Manage Post</h5></a>
                    </li>
                  

                        <?php 
                            if(isset($_SESSION['user_is_admin'])) :
                        ?>

                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                        <h5>Add User</h5></a>
                    </li>
                    <li>
                        <a href="manage-user.php"><i class="uil uil-users-alt"></i>
                        <h5>Manage User</h5></a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-edit"></i>
                        <h5>Add Category</h5></a>
                    </li>
                    <li>
                        <a href="manage-categories.php" ><i class="uil uil-list-ul"></i>
                        <h5>Manage Category</h5></a>
                    </li>
                    <li>
                        <a href="analysis.php" class="active"><i class="uil uil-analytics"></i>
                        <h5>Analytics</h5></a>
                    </li>
                    <?php else : ?>
                        <li>
                        <a href="user_analysis.php" class="active"><i class="uil uil-analytics"></i>
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
                <h2>Analysis</h2>
                <?php if(mysqli_num_rows($posts) > 0) : ?>
                    <div class="user__graphs">
                        <!-- <div class="top__user-charts">
                            <div class="left__user-chart">
                                <div class="left__user__chart-detail">
                                    <?php
                                        $sql = mysqli_query($connection, "SELECT COUNT(*) AS post_count FROM posts WHERE author_id =  $current_user_id AND status=0");
                                        $fetch = mysqli_fetch_assoc($sql);
                                        $total_posts = $fetch['post_count'];
                                    ?>
                                    <span><?=$total_posts?></span><br>
                                    <span>Total Uploads</span>
                                </div>
                                <div class="right__user__chart-detail">
                                    <i class="uil uil-folder-upload"></i>
                                </div>
                            </div>

                            <div class="right__user-chart">
                                <div class="left__user__chart-detail">
                                    <?php
                                            $sql = mysqli_query($connection, "SELECT SUM(views) AS total_views
                                            FROM posts
                                            WHERE author_id = $current_user_id AND status=0"
                                            );
                                            $fetch = mysqli_fetch_assoc($sql);
                                            $total_veiws = $fetch['total_views'];
                                    ?>
                                    <span><?=$total_veiws?></span><br>
                                    <span>Total Views</span>
                                </div>
                                <div class="right__user__chart-detail">
                                    <i class="uil uil-eye"></i>
                                </div>
                            </div>
                        </div> -->
                        <div class="body__user-charts">
                            <div class="left__chart-body">
                                <canvas id="donutChartUser"></canvas>
                            </div>
                            <div class="right__chart-body">
                            <canvas id="lineChartUser"></canvas>
                            </div>
                        </div>
                        <div class="view__more-chart">
                        <a href="admin__charts.php" class="view__more-btn">View More</a>
                    </div>
                    </div>
                <?php else: ?>
                    <div class="alert__message error">
                        <?= "No graphs found" ?>
                    </div>
                <?php endif ?> 
            </main>
        </div>
</section>
<?php
    include 'graphs/user_donut.php';
    include 'graphs/user__line-chart.php';
?>
<!--============end of the dashboard-->

<?php
 include '../partials/footer.php';
 ?>