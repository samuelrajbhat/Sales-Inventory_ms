<?php
    include 'connection.php';
        $view = "CREATE OR REPLACE VIEW category AS SELECT 
            SUM(CASE WHEN category = 'foods' THEN 1 ELSE 0 END) AS foods,
            SUM(CASE WHEN category = 'drinks' THEN 1 ELSE 0 END) AS drinks,
            SUM(CASE WHEN category = 'beauty' THEN 1 ELSE 0 END) AS beauty,
            SUM(CASE WHEN category = 'health' THEN 1 ELSE 0 END) AS health,
            SUM(CASE WHEN category = 'sanitation' THEN 1 ELSE 0 END) AS sanitation,
            SUM(CASE WHEN category = 'stationery' THEN 1 ELSE 0 END) AS stationery,
            SUM(CASE WHEN category = 'utensils' THEN 1 ELSE 0 END) AS utensils,
            SUM(CASE WHEN category = 'tools' THEN 1 ELSE 0 END) AS tools
        FROM products ";
    
    // Execute the query
    $output = mysqli_query($connection, $view);
    
    // Check if the query was successful
    if ($output) {
        echo"Connection Sucessful:";
    } else {
       echo"Error creating the view: " .$conn->error;
    }
?>