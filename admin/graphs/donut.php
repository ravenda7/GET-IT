<?php 
    // Query to count admin users
$adminQuery = "SELECT COUNT(*) as adminCount FROM users WHERE is_admin = 1 AND status=0";
$adminResult = mysqli_query($connection, $adminQuery);
$adminData = mysqli_fetch_assoc($adminResult);
$adminCount = $adminData['adminCount'];

// Query to count normal users
$normalQuery = "SELECT COUNT(*) as normalCount FROM users WHERE is_admin = 0 AND status=0";
$normalResult = mysqli_query($connection, $normalQuery);
$normalData = mysqli_fetch_assoc($normalResult);
$normalCount = $normalData['normalCount'];

// Store the user counts in an associative array
$userCounts = array(
    'Admin' => $adminCount,
    'Normal' => $normalCount
);

// Convert the user counts to JSON format
$userCountsJSON = json_encode($userCounts);
?>

<script>
        // Retrieve the user counts from PHP and parse it as JSON
        var userCounts = <?php echo $userCountsJSON; ?>;

        // Extract the count values from the JSON data
        var adminCount = userCounts['Admin'];
        var normalCount = userCounts['Normal'];

        // Create a donut chart using Chart.js
var ctx = document.getElementById('userChart').getContext('2d');

function getRandomColors(count) {
  var colors = [];
  for (var i = 0; i < count; i++) {
    var color = '#' + Math.floor(Math.random() * 16777215).toString(16); // Generate random color code
    colors.push(color);
  }
  return colors;
}

var chart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['Admin', 'Normal'],
    datasets: [{
      data: [adminCount, normalCount],
      backgroundColor: getRandomColors(2), // Generate 2 random colors
      borderWidth: 1
    }]
  },
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
        text: 'User Types',
        color: 'white'
      }
    }
  }
});


</script>