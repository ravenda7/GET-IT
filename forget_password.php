<?php
require 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/mode.css">
</head>

<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Password Reset</h2>
            <?php if (isset($_SESSION['send-token'])): ?>
                <div class="alert__message success" id="expire">
                    <p id="expire_alert">
                        <?= $_SESSION['send-token']; ?>
                        <script>
                            // Set the starting value of the countdown
                            let countdown = 120;

                            // Function to update the timer display
                            function updateTimer() {
                                const timerElement = document.getElementById("timer");
                                const expired = document.getElementById("expire_alert");
                                const error_msg = document.getElementById("expire");
                                timerElement.textContent = countdown;
                                countdown--;

                                // Check if the countdown has reached 0
                                if (countdown < 0) {
                                    clearInterval(timerInterval);
                                    error_msg.classList.remove("success");
                                    error_msg.classList.add("error");
                                    expired.textContent = "linked is expired";
                                }
                            }

                            // Call the updateTimer function every second
                            const timerInterval = setInterval(updateTimer, 1000);
                        </script>
                        <?php unset($_SESSION['send-token']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['something-error'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['something-error'];
                        unset($_SESSION['something-error']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['no-email'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['no-email'];
                        unset($_SESSION['no-email']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['expire_time'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['expire_time'];
                        unset($_SESSION['expire_time']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>password_recovery/password_reset-code.php" method="POST">
                <input type="text" name="email" placeholder="Email">

                <button type="submit" class="btn" name="pwd__reset-link">Submit</button>
            </form>
        </div>
    </section>
    <script src="js/mode.js"></script>
</body>

</html>