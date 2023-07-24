<?php
// Execute the SQL query to fetch the data
$sql = "SELECT c.title, COUNT(p.id) AS post_count
        FROM posts p
        JOIN categories c ON p.category_id = c.id
        WHERE p.author_id = '$current_user_id' AND p.status = 0
        GROUP BY c.title";

// Perform the query
$result = mysqli_query($connection, $sql);

// Format the data for Chart.js
$categories = [];
$postCounts = [];
$backgroundColors = [];

while ($row = mysqli_fetch_assoc($result)) {
    $category = $row['title'];
    $postCount = $row['post_count'];

    $categories[] = $category;
    $postCounts[] = $postCount;
    $backgroundColors[] = getRandomColor();
}

$chartData = [
    'labels' => $categories,
    'datasets' => [
        [
            'data' => $postCounts,
            'backgroundColor' => $backgroundColors,
        ],
    ],
];
?>

<script>
    var ctx = document.getElementById('donutChartUser').getContext('2d');
    var donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: <?php echo json_encode($chartData); ?>,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        color: 'white' // Set label color to white
                    }
                },
                title: {
                    display: true,
                    text: 'Project Types',
                    color: 'white'
                }
            }
        }
    });
</script>

<?php
// Function to generate random color
function getRandomColor() {
    $letters = '0123456789ABCDEF';
    $color = '#';
    for ($i = 0; $i < 6; $i++) {
        $color .= $letters[rand(0, 15)];
    }
    return $color;
}
?>
