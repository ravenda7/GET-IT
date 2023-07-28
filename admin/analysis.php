<?php
 include 'partials/header.php';



 // fetch categories from database
 $query = "SELECT * FROM categories ORDER BY title";
 $categories = mysqli_query($connection, $query);



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
                    <?php endif ?>
                    <li>
                        <a href="profile_update.php" class=""> <i class="uil uil-sliders-v-alt"></i>
                        <h5>Update Profile</h5></a>
                    </li>
                </ul>
            </aside>
            <main>
                <h2>Analysis</h2>
                <?php if(mysqli_num_rows($categories) > 0) : ?>
                <?php else : ?>
                    <div class="alert__message error">
                        <?= "No categories found" ?>
                    </div>
                <?php endif ?>
                <div class="graph__container">
                    <div class="top__line-chart">
                        <div class="category_mini-chart">
                            <canvas id="userChart"></canvas>
                        </div>
                        <div class="category_mini-chart right__line-chart">          
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>

                    <div class="donut__chart">
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="view__more-chart">
                        <a href="admin__charts.php" class="view__more-btn">View More</a>
                    </div>
                </div>
            </main>
        </div>
</section>
    <?php
        //this is for the admin/user donut chart
        include 'graphs/line_user.php';
        //this is for the admin/user donut chart
        include 'graphs/donut.php';
        //this is for the admin/user donut chart
        include 'graphs/line.php';
    ?>

<!--============end of the dashboard-->

<?php
 include '../partials/footer.php';
 ?>