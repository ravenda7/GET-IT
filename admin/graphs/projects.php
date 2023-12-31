<?php
// Execute the SQL query
$query = "SELECT categories.title, COUNT(posts.category_id) AS post_count
    FROM categories
    LEFT JOIN posts ON categories.id = posts.category_id AND posts.status = 0
    GROUP BY categories.id
    ORDER BY categories.date_time DESC
    LIMIT 6";

$result = mysqli_query($connection, $query);

// Fetch the results and store them in an array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Prepare the data for the area chart
$categories = array();
$postCounts = array();

foreach ($data as $row) {
    $categories[] = $row['title'];
    $postCounts[] = $row['post_count'];
}

$categories = json_encode($categories);
$postCounts = json_encode($postCounts);
?>

<script>
    var areaChartOptions = {
        series: [
            {
                name: 'Number of Posts', // Updated series name
                data: <?php echo $postCounts; ?>,
            }
        ],
        chart: {
            height: 350,
            type: 'area',
            toolbar: {
                show: false,
            },
        },
        colors: ['#4f35a1'],
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: 'smooth',
        },
        labels: <?php echo $categories; ?>, // Use PHP variable for labels
        markers: {
            size: 0,
        },
        yaxis: [
            {
                title: {
                    text: 'Post Count',
                },
            }
        ],
        tooltip: {
            shared: true,
            intersect: false,
        },
    };

    var areaChart = new ApexCharts(
        document.querySelector('#projects-count-chart'),
        areaChartOptions
    );

    areaChart.render();
</script>