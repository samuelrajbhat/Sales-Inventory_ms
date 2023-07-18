<?php
// Connect to the database
include('connection.php');


// Select the data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Check if the query was successful
if ($result->num_rows > 0) {
  // Initialize an array to store the data
  $products = [];

  // Loop through the results and add them to the array
  while ($row = $result->fetch_assoc()) {
    $products[] = $row;
  }

  // Encode the data as JSON
  $json = json_encode($products);

  // echo the JSON data
  echo $json;
} else {
  echo "No data found";
}

// Close the connection
$conn->close();
?>
