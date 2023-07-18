<?php
error_log('Request received');
include ('connection.php');

// Retrieve the row data from the POST request
$productId = $_POST['productId'];
$quantity = $_POST['quantity'];
$customerName = $_POST['customerName'];

// TODO: Add your database connection code here

// TODO: Prepare the SQL statement to insert the data into the sales table
$sql = "INSERT INTO sales (productId, salesQuantity, customerName) VALUES ('$productId', '$quantity', '$customerName')";

// TODO: Execute the SQL statement
$result = mysqli_query($connection, $sql);

// Check if the insertion was successful
if ($result) {
  echo "Row data inserted successfully";
  
  // Subtract the quantity from the existing value in the products table
  $updateQuery = "UPDATE products SET quantity = (quantity - $quantity) WHERE productId = $productId";
  $updateResult = mysqli_query($connection, $updateQuery);

  // Check if the subtraction was successful
  if ($updateResult) {
    echo "Quantity subtracted successfully";
  } else {
    echo "Error subtracting quantity: " . mysqli_error($connection);
  }
} else {
  echo "Error inserting row data: " . mysqli_error($connection);
}

// TODO: Close the database connection
mysqli_close($connection);
?>
