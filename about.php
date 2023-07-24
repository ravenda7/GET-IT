<?php
 include 'partials/header.php';
 ?>

    <section class="about__page">
    <div class="container about__container">
        <div class="left__about">
            <h1 class="hidden">ABOUT US</h1>
            <p class="this hidden">As a professional/creative in today's digital age, having a platform to showcase all students work and skills is essential.Here, you'll find a collection of best work, experiences, and accomplishments of Arunima's students.<br><br>
            This website give you a clear understanding of what they can offer and how they can contribute to your project or company.From design to development, writing to photography, we're excited to share our expertise and passion with you.</p>
        </div>
        <div class="right__about this hidden">
            <img src="images/about__page.svg" alt="">
        </div>
    </div>
    </section>

    <section class="service__page ">
        <h2 class="service__header hidden">Our Teams</h2>
        <div class="container service__container">
            <div class="service__info ">
                <div class="left__service service__image this hidden">
                    <img src="images/daw_new.png" alt="">
                </div>
                <div class="right__service detail this hidden">
                    <h2>Dawa Dorje Tamang</h2>
                    <p>Dawa is a multi-talented creative professional who brings characters to life, captivates through animation, and enhances user experiences with his UI/UX design skills. his passion for storytelling, meticulous attention to detail, and ability to seamlessly merge his various skills make him an exceptional talent in the world of character design, animation, and UI/UX design..</p>
                    <a href="<?=ROOT_URL?>our_team/dawa/index.html" target="_blank" class="learn-more">Learn More
                        <i class="uil uil-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="service__info this">
                <div class="left__service detail this hidden">
                <h2>Kesang Hyolmo</h2>
                    <p>Kesang possesses a unique blend of skills in UI/UX design, photography, and Full Stack development, making him a versatile and sought-after professional in the digital realm.The combination of these skills makes this individual a valuable asset to any team or project...</p>
                    <a href="<?=ROOT_URL?>our_team/kesang/index.html" target="_blank" class="learn-more">Learn More
                        <i class="uil uil-arrow-right"></i>
                    </a>
                </div>
                <div class="right__service service__image this hidden">
                <img src="images/kesang_new.png" alt="">
                </div>
            </div>
        </div>
        <script src="js/amimation.js"></script>
    </section>
    <?php
 include 'partials/footer.php';
 ?>
