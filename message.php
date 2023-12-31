<?php
require 'partials/header.php';

$query = "SELECT * FROM message WHERE status=0 ORDER BY date DESC";
$msg = mysqli_query($connection, $query);
?>

<?php if (mysqli_num_rows($msg) > 0): ?>
    <section class="message__section  <?= $featured ? '' : 'section__extra-margin' ?>">
        <?php if (isset($_SESSION['delete-msg-success'])): ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['delete-msg-success'];
                    unset($_SESSION['delete-msg-success']);
                    ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['delete-msg'])): ?>
            <div class="alert__message error container">
                <p>
                    <?= $_SESSION['delete-msg'];
                    unset($_SESSION['delete-msg']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <div class="container message__container">
            <h2>Messages</h2>
            <div class="message__card">
                <table class="message__table">
                    <?php

                    while ($m = mysqli_fetch_assoc($msg)): ?>
                        <tr>
                            <td class="this_td">
                                <div class="profile__details">
                                    <div class="profile_circle">
                                        <?php
                                        $name = $m['name'];
                                        $firstLetter = $name[0];
                                        echo $firstLetter;
                                        ?>
                                    </div>
                                    <div class="user_name">
                                        <?= $m['name'] ?>
                                    </div>
                                </div>
                            </td>
                            <td class="this_td">
                                <a href="<?= ROOT_URL ?>send_message/message_delete-logic.php?msg_id=<?= $m['id'] ?>">
                                    <script src="https://cdn.lordicon.com/lordicon-1.1.0.js"></script>
                                    <lord-icon src="https://cdn.lordicon.com/wpyrrmcq.json" trigger="hover"
                                        colors="primary:#e83a30" style="width:25px;height:25px;" class="trash__icon">
                                    </lord-icon>

                                </a>
                            </td>
                            <td id="hireBtn" class="this_td">
                                <?php
                                $id = $m['id']; // Replace $m['id'] with the actual ID you want to encrypt
                        
                                $encrypted_id = base64_encode($id);
                                $url = ROOT_URL . 'message_detail.php?id=' . $encrypted_id;
                                ?>
                                <a href="<?= $url ?>">
                                    <p>
                                        <?= $m['subject'] ?>
                                    </p>
                                </a>
                            </td>
                            <td class="this_td">
                                <?= date("M d, Y - H:i", strtotime($m['date'])) ?>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </table>
            </div>
        </div>
    </section>
<?php else: ?>
    <div class="alert__message error lg section__extra-margin">
        <p>No message</p>
    </div>
<?php endif ?>


<?php
include 'partials/footer.php';
?>