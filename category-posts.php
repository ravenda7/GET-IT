<?php
 include 'partials/header.php';


 // fetch posts if id is set
 if(isset($_GET['id'])) {
    $id = filter_var(base64_decode($_GET['id']), FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT p.*, u.foldername
          FROM posts p
          INNER JOIN users u ON p.author_id = u.id
          WHERE p.category_id = $id AND p.status = 0 AND u.status = 0
          ORDER BY p.date_time DESC";

        $posts = mysqli_query($connection, $query);

    } else {
        header('location: ' . ROOT_URL .'blog.php');
        die();
    }
 ?>

    <header class="category__title">
        <h2>
        <?php
        // fetch category from categories table using category_id of post
        $category_id =$id;
        $category_query = "SELECT * FROM categories WHERE id = $id";
        $category_result = mysqli_query($connection, $category_query);
        $category = mysqli_fetch_assoc($category_result);
        echo $category['title'];
        ?>
        </h2>
    </header>

        <?php 
            if(mysqli_num_rows($posts) > 0) :
        ?>
    <section class="posts">
    <div class="container posts__container">
        <?php
            // while($post = mysqli_fetch_assoc($posts)) :
                while ($post = mysqli_fetch_assoc($posts)) :
                    $thumbnail = './users/' . $post['foldername'] . '/images/' . $post['thumbnail'];
        ?>
            <article class="post">
                    <div class="post__thumbnail">
                        
                        <img src="<?= $thumbnail ?>" alt="">
                    </div>
                    <div class="post__info">
                        <?php if(isset($_SESSION['user-id'])): ?>
                        <h3 class="post__title"><a href="<?=ROOT_URL?>post.php?id=<?=base64_encode($post['id'])?>"><?=$post['title'] ?></a></h3>
                        <?php else:?>
                        <h3 class="post__title"><a href="<?=ROOT_URL?>signin.php"><?=$post['title'] ?></a></h3> 
                        <?php endif?>
                        <p class="post__body">
                        <?=substr($post['body'],0, 150) ?>...
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
                            <img src="./users/<?= $author['foldername']?>/images/<?=$author['avatar'] ?>" alt="">
                            </div>
                            <div class="post__author-info">
                            <h5>By: <?="{$author['firstname']} {$author['lastname']}" ?></h5>
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
<?php else :?>
    <div class="alert__message error lg">
        <p>No posts found for this category</p>
    </div>
<?php endif ?>
<!--=============end of the post project======-->



<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
            $all_categories_query = "SELECT * FROM categories";
            $all_categories = mysqli_query($connection, $all_categories_query);
        ?>
        <?php while($category = mysqli_fetch_assoc($all_categories)) : ?>
        <a href="<?=ROOT_URL?>category-posts.php?id=<?= base64_encode($category['id'])?>" class="category__button"><?=$category['title'] ?></a>
        <?php endwhile ?>
    </div>
</section>

<?php
 include 'partials/footer.php';
 ?>
