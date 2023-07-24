<?php
//Retrieve the current user's posts from the database
$sql = "SELECT SUBSTRING(title, 1, 6) AS truncated_title, count FROM posts WHERE author_id = $current_user_id AND status=0";
$result = mysqli_query($connection, $sql);

$user_posts = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $user_posts[] = $row;
    }
}

//Prepare the data for the line chart
$chart_data = [];
foreach ($user_posts as $post) {
    $chart_data[] = [
        'title' => $post['truncated_title'],
        'likes' => $post['count']
    ];
}

$chart_data_json = json_encode($chart_data);
?>

<script>
   var ctx = document.getElementById('lineChartUser').getContext('2d');
    var chartData = <?php echo $chart_data_json; ?>;

    var titles = chartData.map(function(item) {
        return item.title;
    });

    var likes = chartData.map(function(item) {
        return item.likes;
    });

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    Chart.defaults.elements.line.capBezierPoints = true; // Allow wave-like curves

    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: titles,
            datasets: [{
                label: 'Likes',
                data: likes,
                backgroundColor: getRandomColor(),
                fill: "origin", // Set fill to "origin" for a wave-like fill area
                borderWidth: 0,
                pointRadius: 3,
                pointHoverRadius: 3,
                lineTension: 0.5 // Adjust the line tension for a more pronounced wave-like form
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
