<?php
require 'partials/header.php';


if (isset($_GET['search']) && isset($_GET['submit'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = $query = "SELECT posts.*, categories.title, users.firstname
        FROM posts
        INNER JOIN categories ON posts.category_id = categories.id
        INNER JOIN users ON posts.author_id = users.id
        WHERE posts.status = 0 
        AND (posts.title LIKE '%$search%'
        OR categories.title LIKE '%$search%'
        OR users.firstname LIKE '%$search%')
        ORDER BY posts.date_time DESC";
    $posts = mysqli_query($connection, $query);
} else {
    header('location: ' . ROOT_URL . 'index.php');
    die();
}
?>



<?php if (mysqli_num_rows($posts) > 0): ?>
    <section class="posts section__extra-margin">
        <div class="container posts__container">
            <?php
            while ($post = mysqli_fetch_assoc($posts)):
                ?>
                <article class="post">
                    <?php
                    // fetch author from user table using author_id
                    $author_id = $post['author_id'];
                    $author_query = "SELECT * FROM users WHERE id=$author_id AND status=0";
                    $author_result = mysqli_query($connection, $author_query);
                    $author = mysqli_fetch_assoc($author_result);
                    ?>
                    <div class="post__thumbnail">
                        <img src="./users/<?= $author['foldername'] ?>/images/<?= $post['thumbnail'] ?>" alt="">
                    </div>
                    <div class="post__info">
                        <?php
                        // fetch category from categories table using category_id of post              
                        $category_id = $post['category_id'];
                        $category_query = "SELECT * FROM categories WHERE id = $category_id";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = mysqli_fetch_assoc($category_result);

                        ?>
                        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= base64_encode($post['category_id']) ?>"
                            class="category__button">
                            <?= $category['title'] ?>
                        </a>
                        <h3 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= base64_encode($post['id']) ?>">
                                <?= $post['title'] ?>
                            </a></h3>
                        <p class="post__body">
                            <?= substr($post['body'], 0, 150) ?>...
                        </p>
                        <div class="post__author">
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
<?php else: ?>
    <div class="alert__message error lg section__extra-margin">
        <p>No post found for this search</p>
    </div>
<?php endif ?>
<!--=============end of the post project======-->

<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
        $all_categories_query = "SELECT * FROM categories";
        $all_categories = mysqli_query($connection, $all_categories_query);
        ?>
        <?php while ($category = mysqli_fetch_assoc($all_categories)): ?>
            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= base64_encode($category['id']) ?>" class="category__button">
                <?= $category['title'] ?>
            </a>
        <?php endwhile ?>
    </div>
</section>

<?php include 'partials/footer.php'; ?>