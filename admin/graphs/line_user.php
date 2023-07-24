<?php 
     // Assuming you have a database connection established ($connection)
     $result = mysqli_query($connection, "SELECT DATE_FORMAT(register_date, '%b %Y') AS month, COUNT(*) AS count FROM users WHERE status = 0 GROUP BY DATE_FORMAT(register_date, '%Y-%m')");
     $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
     

  
     //conert the php data into js
     $months = array();
     $counts = array();
 
     foreach ($data as $row) {
         $months[] = $row['month'];
         $counts[] = $row['count'];
     }
 //making the jscon type
     $months = json_encode($months);
     $counts = json_encode($counts);
?>
  <script>
        var months = <?php echo $months; ?>;
        var counts = <?php echo $counts; ?>;

            // Initialize the chart
            var ctx = document.getElementById('barChart').getContext('2d');

function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

var chart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: months,
    datasets: [{
      label: 'User Registrations',
      data: counts,
      backgroundColor: getRandomColor(), // Generate random color
      borderColor: 'white',
      borderWidth: 3
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
          display: false,
        }
      },
      x: {
        ticks: {
          color: 'white' // Set color of x-axis data labels to white
        },
        grid: {
          display: false,
        }
      }
    },
    responsive: true,
    plugins: {
      legend: {
        labels: {
          color: 'white' // Set label color for light theme
        }
      }
    }
  }
});

    </script>