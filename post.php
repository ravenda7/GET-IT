<?php
include 'partials/header.php';

// fetch post from DB if id is set
if (isset($_GET['id'])) {
  $id = filter_var(base64_decode($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
  $query = " SELECT * FROM posts WHERE id= $id AND status=0";
  $result = mysqli_query($connection, $query);
  $post = mysqli_fetch_assoc($result);
} else {
  header('location: ' . ROOT_URL . 'index.php');
  die();
}
?>

<?php
if (isset($_SESSION['user-id']) || isset($_SESSION['user_is_admin'])):
  ?>
  <?php $view = mysqli_query($connection, "UPDATE posts SET views=views+1 WHERE id=$id LIMIT 1"); ?>
  <section class="singlepost">
    <div class="container singlepost__container">
      <h2>
        <?= $post['title'] ?>
      </h2>
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
      <div class="singlepost__thumbnail">
        <img src="./users/<?= $author['foldername'] ?>/images/<?= $post['thumbnail'] ?>" alt="">
      </div>
      <p>
        <?= $post['body'] ?>
      </p>
      <div class="post_view-detail">
        <?php
        // Function to check if the post is liked by the user
        function checkIfLikedByUser($userId, $postId)
        {
          //connect to the database 
          $connection = new mysqli('localhost', 'ravenous', 'qwert123', 'bca4');

          if (mysqli_errno($connection)) {
            die(mysqli_error($connection));
          }


          $query = "SELECT COUNT(*) AS liked FROM likes WHERE liker='$userId' AND liked='$postId'";
          $result = mysqli_query($connection, $query);

          if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['liked'] > 0;
          }
          return false;
        }

        $id = $post['id'];
        $count = $post['count'];

        // Check if the current user has liked the post
        $likedByCurrentUser = false;
        if (isset($_SESSION['user-id'])) {
          $userId = $_SESSION['user-id'];
          $likedByCurrentUser = checkIfLikedByUser($userId, $id);
        }

        // Determine the initial image based on whether the current user has liked the post
        $imageSrc = $likedByCurrentUser ? 'red_heart.svg' : 'heart.svg';
        echo "<div class='like__button'>
                                        <div class='like' title='" . $id . "'>
                                            <img class='like_icon' src='" . $imageSrc . "'>
                                            <span class='count'>" . $count . "</span>
                                        </div>
                                    </div>";

        ?>
        <?php $_SESSION['post-id'] = $post['id']; ?>
        <a href="download-logic/download-logic.php" class="category__button">Download</a>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(document).ready(function () {
        $(".like").click(function () {
          var $likeButton = $(this);
          var id = $likeButton.attr("title");
          var i = $likeButton.children(".like_icon").attr("src");

          if (i === "heart.svg") {
            $likeButton.children(".like_icon").attr("src", "red_heart.svg");
            likePost(id, $likeButton);
          } else if (i === "red_heart.svg") {
            $likeButton.children(".like_icon").attr("src", "heart.svg");
            unlikePost(id, $likeButton);
          }
        });

        // Function to send a like request to the server
        function likePost(id, $likeButton) {
          $.post("get.php", { data: id, how: 'like' }, function (response) {
            if (response.status === 1) {
              $likeButton.find("span.count").text(response.count);
            }
          }, 'json');
        }

        // Function to send an unlike request to the server
        function unlikePost(id, $likeButton) {
          $.post("get.php", { data: id, how: 'unlike' }, function (response) {
            if (response.status === 0) {
              $likeButton.find("span.count").text(response.count);
            }
          }, 'json');
        }
      });
    </script>
  </section>
  <?php
elseif (!isset($_SESSION['user-id']) || !isset($_SESSION['user_is_admin'])): ?>
  <?php
  header('location: ' . ROOT_URL . 'signin.php');
  ?>

<?php endif ?>
<!--===========================end of single post========-->
<?php
include 'partials/footer.php';
?>