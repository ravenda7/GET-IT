<?php

include 'partials/header.php';

// fetch featured post from database
$featured_query = "SELECT * FROM posts WHERE is_featured=1 AND status=0";
$featured_result = mysqli_query($connection, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);
// fetch the folder name 
$user_id = $featured['author_id'];

$sql = "SELECT foldername FROM users WHERE id = '" . mysqli_real_escape_string($connection, $user_id) . "' AND status=0";

$result = mysqli_query($connection, $sql);

if ($result === false) {
    throw new mysqli_sql_exception(mysqli_error($connection));
}

$folder = mysqli_fetch_assoc($result);
$query = "SELECT p.*, u.foldername
          FROM posts AS p
          INNER JOIN users AS u ON p.author_id = u.id
          WHERE p.status = 0 AND u.status = 0
          ORDER BY p.date_time DESC
          LIMIT 9";

$posts = mysqli_query($connection, $query);
?>
<!-- showed featured post here -->
<?php if (mysqli_num_rows($featured_result) == 1): ?>
    <section class="featured">
        <div class="container featured__container">
            <div class="post__thumbnail">
                <img src="./users/<?= $folder['foldername'] ?>/images/<?= $featured['thumbnail'] ?>" alt="">
            </div>
            <div class="post__info">
                <?php
                // fetch category from categories table using category_id of post           
                $category_id = $featured['category_id'];
                $category_query = "SELECT * FROM categories WHERE id = $category_id";
                $category_result = mysqli_query($connection, $category_query);
                $category = mysqli_fetch_assoc($category_result);

                ?>
                <?php
                $id = $category['id'];
                $encrypted_id = base64_encode($id);
                $urll = ROOT_URL . 'category-posts.php?id=' . $encrypted_id;
                ?>
                <a href="<?= $urll ?>" class="category__button">
                    <?= $category['title']; ?>
                </a>
                <h2 class="post__title">
                    <?php
                    $id = $featured['id'];
                    $encrypted_id = base64_encode($id);
                    $url = ROOT_URL . 'post.php?id=' . $encrypted_id;
                    ?>
                    <a href="<?= $url ?>">
                        <?= $featured['title'] ?>
                    </a>
                </h2>
                <p class="post__body">
                    <?= substr($featured['body'], 0, 300) ?>...
                </p>
                <div class="post__author">
                    <?php
                    // fetch author from user table using author_id
                    $author_id = $featured['author_id'];
                    $author_query = "SELECT * FROM users WHERE id=$author_id";
                    $author_result = mysqli_query($connection, $author_query);
                    $author = mysqli_fetch_assoc($author_result);
                    ?>
                    <div class="post__author-avatar">
                        <img src="./users/<?= $author['foldername'] ?>/images/<?= $author['avatar'] ?>" alt="">
                    </div>
                    <div class="post__author-info">
                        <h5>By:
                            <?= "{$author['firstname']} {$author['lastname']}" ?>
                        </h5>
                        <small>
                            <?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>
<!--================end of section=================-->

<section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
    <div class="container posts__container">
        <?php
        while ($post = mysqli_fetch_assoc($posts)):
            $thumbnail = './users/' . $post['foldername'] . '/images/' . $post['thumbnail'];
            ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="<?= $thumbnail ?>" alt="">
                </div>
                <div class="post__info">
                    <?php
                    // fetch category from categories table using category_id of post             
                    $category_id = $post['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id = $category_id";
                    $category_result = mysqli_query($connection, $category_query);
                    $category = mysqli_fetch_assoc($category_result);

                    ?>
                    <?php
                    $id = $category['id'];
                    $encrypted_id = base64_encode($id);
                    $urll = ROOT_URL . 'category-posts.php?id=' . $encrypted_id;
                    ?>
                    <a href="<?= $urll ?>" class="category__button">
                        <?= $category['title'] ?>
                    </a>

                    <h3 class="post__title">
                        <?php
                        $id = $post['id'];
                        $encrypted_id = base64_encode($id);
                        $url = ROOT_URL . 'post.php?id=' . $encrypted_id;
                        ?>
                        <a href="<?= $url ?>">
                            <?= $post['title'] ?>
                        </a>
                    </h3>
                    <p class="post__body">
                        <?= substr($post['body'], 0, 150) ?>...
                    </p>
                    <div class="post__author">
                        <?php
                        // fetch author from user table using author_id
                        $author_id = $post['author_id'];
                        $author_query = "SELECT * FROM users WHERE id=$author_id";
                        $author_result = mysqli_query($connection, $author_query);
                        $author = mysqli_fetch_assoc($author_result);
                        ?>
                        <div class="post__author-avatar">
                            <img src="./users/<?= $author['foldername'] ?>/images/<?= $author['avatar'] ?>" alt="">
                        </div>
                        <div class="post__author-info">
                            <h5>By:
                                <?= "{$author['firstname']} {$author['lastname']}" ?>
                            </h5>
                            <small>
                                <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                            </small>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile ?>
    </div>
</section>

<!--=============end of the post project======-->

<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
        $all_categories_query = "SELECT * FROM categories";
        $all_categories = mysqli_query($connection, $all_categories_query);
        ?>
        <?php while ($category = mysqli_fetch_assoc($all_categories)): ?>
            <?php
            $id = $category['id'];
            $encrypted_id = base64_encode($id);
            $urll = ROOT_URL . 'category-posts.php?id=' . $encrypted_id;
            ?>
            <a href="<?= $urll ?>" class="category__button">
                <?= $category['title'] ?>
            </a>
        <?php endwhile ?>
    </div>
</section>


<?php
include 'partials/footer.php'
    ?>