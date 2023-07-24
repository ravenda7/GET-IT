<?php
    include 'partials/header.php';
    if(!isset($_SESSION['user-id'])) {
        $_SESSION['login-first'] = 'Please Login First.';
        header('location:' . ROOT_URL . 'signin.php');
        die();
    }
    include 'graphs/line_inner.php';
    include 'graphs/dynamic__radar.php';
    
?>

<section class="section__admin-charts section__extra-margin">
    <div class="container admin__charts-container">
        <h2>Uploaded Projects Analysis</h2>
        <div class="admin__charts">
            <h3 class="Project__title">PROJECT LISTS ON EACH CATEGORY</h3>
            <div class="project__chart">
                <div class="inner__project-chart">
                    <canvas id="lineCharts"></canvas>
                </div>
            </div>    
            <script>
                    // Retrieve the data from PHP
                    var categories = <?php echo json_encode($categories); ?>;
                    var postCounts = <?php echo json_encode($postCounts); ?>;

                    // Generate a random color in hexadecimal format
                    function getRandomColor() {
                        var letters = '0123456789ABCDEF';
                        var color = '#';
                        for (var i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }

                    // Initialize the chart
                    var ctx = document.getElementById('lineCharts').getContext('2d');

                    var chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: categories,
                            datasets: [{
                                label: 'Number of Projects',
                                data: postCounts,
                                backgroundColor: getRandomColor(),
                                borderColor: getRandomColor(),
                                borderWidth: 0,
                                pointRadius: 3, // Set the point radius to a value greater than 0
                                pointHoverRadius: 3, // Set the hover point radius to match
                                fill: true,
                                lineTension: 0.3 // Adjust the line tension to make it smooth and wave-like
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    precision: 0,
                                    ticks: {
                                        stepSize: 1,
                                        color: 'white'
                                    },
                                    grid: {
                                        display: false
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: 'white'
                                    },
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            responsive: true,
                            plugins: {
                                legend: {
                                    labels: {
                                        color: 'white'
                                    }
                                }
                            }
                        }
                    });

            </script>
        </div>
        <?php foreach ($postsData as $post): ?>
        <div class="admin__charts">
            <h3 class="Project__title"><?=$post['title']?></h3>
            <div class="head__project-details">
                <div class="project__type common_type">
                    <div class="inner__project-details">
                        <div class="top__details">
                            <h4><?=$post['category_title']?></h4>
                        </div>
                        <div class="bottom__details">
                            <h4>Category</h4>
                        </div>
                    </div>
                    <div class="projects__icons">
                        <i class="uil uil-apps"></i>
                    </div>
                </div>
                <div class="projects__views common_type">
                <div class="inner__project-details">
                        <div class="top__details">
                            <h4><?=$post['views']?></h4>
                        </div>
                        <div class="bottom__details">
                            <h4>Views</h4>
                        </div>
                    </div>
                    <div class="projects__icons">
                        <i class="uil uil-eye"></i>
                    </div>
                </div>
                <div class="project__downloads common_type">
                    <div class="inner__project-details">
                        <div class="top__details">
                            <h4><?=$post['downloads']?></h4>
                        </div>
                        <div class="bottom__details">
                            <h4>Downloads</h4>
                        </div>
                    </div>
                    <div class="projects__icons">
                        <i class="uil uil-import"></i>
                    </div>
                </div>
                <div class="projects__likes common_type">
                <div class="inner__project-details">
                        <div class="top__details">
                            <h4><?=$post['count']?></h4>
                        </div>
                        <div class="bottom__details">
                            <h4>Likes</h4>
                        </div>
                    </div>
                    <div class="projects__icons">
                        <i class="uil uil-heart"></i>
                    </div>
                </div>
            </div>
            <div class="project__chart">
                <div class="inner__project-chart">
                    <canvas id="radarChart<?php echo $post['id']; ?>"></canvas>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<script>
  <?php foreach ($postsData as $post): ?>
    var ctx<?php echo $post['id']; ?> = document.getElementById('radarChart<?php echo $post['id']; ?>').getContext('2d');
    var gradient<?php echo $post['id']; ?> = ctx<?php echo $post['id']; ?>.createLinearGradient(0, 0, 0, 400);
    gradient<?php echo $post['id']; ?>.addColorStop(0, getRandomColor());
    gradient<?php echo $post['id']; ?>.addColorStop(1, getRandomColor());

    var chart<?php echo $post['id']; ?> = new Chart(ctx<?php echo $post['id']; ?>, {
        type: 'bar',
        data: {
            labels: ['Likes', 'Downloads', 'Views'],
            datasets: [{
                label: '<?php echo $post['title']; ?>',
                data: [
                    <?php echo $post['count']; ?>,
                    <?php echo $post['downloads']; ?>,
                    <?php echo $post['views']; ?>
                ],
                backgroundColor: gradient<?php echo $post['id']; ?>,
                borderColor: 'white',
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                y: {
                    ticks: {
                        beginAtZero: true,
                        precision: 0,
                        fontColor: 'white'
                    },
                    grid: {
                        display: true,
                    }
                },
                x: {
                    ticks: {
                        fontColor: 'white'
                    },
                    grid: {
                        display: true,
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'white'
                    }
                }
            }
        }
    });
<?php endforeach; ?>

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

    </script>

<?php
    include '../partials/footer.php';
?>