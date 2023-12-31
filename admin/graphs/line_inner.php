<?php
// Execute the SQL query
$query = "SELECT categories.title, COUNT(posts.category_id) AS post_count
FROM categories
LEFT JOIN posts ON categories.id = posts.category_id AND posts.status=0
GROUP BY categories.id";
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