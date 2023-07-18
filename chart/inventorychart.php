
<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart of Category</title>
  
    <link rel="stylesheet" href="category_chart.css">

<script src="https://www.gstatic.com/charts/loader.js"></script>
   <script> google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" }],
        
        <?php
        $sql="select * from category";
        $result = mysqli_query($connection, $sql);
        if ($result) {
          $row = mysqli_fetch_assoc($result);
          // Store the counts in an associative array
         
              $foods =$row['foods'];
              $drinks = $row['drinks'];
              $beauty = $row['beauty'];
              $health = $row['health'];
              $stationery = $row['stationery'];
              $utensils = $row['utensils'];
              $tools = $row['tools'];
      
      } else {
          // Handle any errors that occurred during the query
          echo "Error: " . mysqli_error($connection);
      }
      
      // Close the database connection
 
        ?>
        ["Foods", <?php echo $foods?>, "#b87333"],
        ["Drinks", <?php echo $drinks?>, "silver"],
        ["Beauty", <?php echo $beauty?>, "gold",],
        ["Health", <?php echo $health?>, "color: #e504e5"],
        ["Stationery", <?php echo $stationery?>, "color: #e504e5"],
        ["utensils", <?php echo $utensils?>, "color: #e504e5"],
        ["tools", <?php echo $tools?>, "color: #e504e5"],
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Inventory Acuisition chart",
        subtitle: "Hello",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
       // bars:'horizontal',
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }

  //To return back to update page
  function goBack() {
    window.history.go(-1);
  }
  </script>
  </head>
  <body>
  <div id ="go_back">
    <button onclick="goBack()">Go Back</button>
    <span class="tooltip">Inventory Page</span>
  </div>
  <div id="chart_container">
   <div id="barchart_values" style="width: 900px; height: 300px;"></div>
  </div>


    

  </body>
  </html>