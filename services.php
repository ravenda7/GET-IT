<?php
include 'partials/header.php';
?>


<section class="service__page  <?= $featured ? '' : 'section__extra-margin' ?>">
    <h2 class="service__header hidden">What We Offers</h2>
    <div class="conatiner service__container">
        <div class="service__info ">
            <div class="left__service service__image this hidden">
                <img src="images/service1.svg" alt="">
            </div>
            <div class="right__service detail this hidden">
                <h2>Download Projects</h2>
                <p>This site offers a diverse range of project references to meet your specific needs and enhance your
                    own project developments. You can simply download the any projects sample which is relevant to you
                    and create your own successive projects.</p>

            </div>
        </div>
        <div class="service__info this">
            <div class="left__service detail this hidden">
                <h2>Showcase Skills</h2>
                <p>This site offers you to upload you personal works and help you to showcase about you and your skills
                    among society which helps you to get more opportunities.</p>

            </div>
            <div class="right__service service__image this hidden">
                <img src="images/service2.svg" alt="">
            </div>
        </div>
        <div class="service__info this">
            <div class="left__service service__image this hidden">
                <img src="images/service3.svg" alt="">
            </div>
            <div class="right__service detail this hidden">
                <h2>Upload Your Own Projects</h2>
                <p>This site offers you a platform where you can upload your projects and be a contributor among our
                    community. Which helps you to get recognization among our community and you will be a great helper
                    to students communities who are struggling while creating projects.</p>

            </div>
        </div>
    </div>
    <script src="js/amimation.js"></script>
</section>
<?php
include 'partials/footer.php';
?>