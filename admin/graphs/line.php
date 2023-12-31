<?php
// Execute the SQL query
$query = "SELECT categories.title, COUNT(posts.category_id) AS post_count
FROM categories
LEFT JOIN posts ON categories.id = posts.category_id AND posts.status=0
GROUP BY categories.id
ORDER BY categories.date_time DESC
LIMIT 6";

$result = mysqli_query($connection, $query);


// Fetch the results and store them in an array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Prepare the data for the line chart
$categories = array();
$postCounts = array();

foreach ($data as $row) {
    $categories[] = $row['title'];
    $postCounts[] = $row['post_count'];
}
?>

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
    var ctx = document.getElementById('lineChart').getContext('2d');

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