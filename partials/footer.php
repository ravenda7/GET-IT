<footer>
    <div class="footer__socials">
        <a href="" target="_blank"><i class="uil uil-facebook-f"></i></a>
        <a href="" target="_blank"><i class="uil uil-instagram"></i></a>
        <a href="" target="_blank"><i class="uil uil-twitter-alt"></i></a>
        <a href="" target="_blank"><i class="uil uil-telegram-alt"></i></a>
    </div>
    <div class="container footer__container">
        <article>
            <h4>Categories</h4>
            <?php
            $query = mysqli_query($connection, "SELECT * FROM categories ORDER BY date_time DESC
                LIMIT 4");
            ?>
            <ul>
                <?php while ($get = mysqli_fetch_assoc($query)): ?>
                    <?php
                    $id = $get['id'];
                    $encrypted_id = base64_encode($id);
                    $urll = ROOT_URL . 'category-posts.php?id=' . $encrypted_id;
                    ?>
                    <li><a href="<?= $urll ?>">
                            <?= $get['title'] ?>
                        </a></li>
                <?php endwhile; ?>
            </ul>

        </article>
        <article>
            <h4>Support</h4>
            <ul>
                <li><a href="<?= ROOT_URL ?>location.php">Call Numbers</a></li>
                <li><a href="<?= ROOT_URL ?>location.php">Emails</a></li>
                <li><a href="<?= ROOT_URL ?>location.php">Social Suppport</a></li>
                <li><a href="<?= ROOT_URL ?>location.php">Location</a></li>
            </ul>
        </article>
        <article>
            <h4>projects</h4>
            <ul>
                <li><a href="<?= ROOT_URL ?>recent_projects.php">Recent</a></li>
                <li><a href="<?= ROOT_URL ?>popular_projects.php">Popular</a></li>
                <!-- <li><a href="#this">Categories</a></li> -->
            </ul>
        </article>
        <article>
            <h4>Permalinks</h4>
            <ul>
                <li><a href="<?= ROOT_URL ?>index.php">Home</a></li>
                <li><a href="<?= ROOT_URL ?>testimonial.php">Testimonial</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
            </ul>
        </article>
    </div>
    <div class="footer__copyright">
        <small>Copyright &copy; 2023 GET_ET</small>
    </div>
</footer>
<script src="<?= ROOT_URL ?>js/main.js"></script>
</body>

</html>