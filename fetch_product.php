<?php
include 'connection.php';

if (isset($_GET['product_id'])) {
  $productId = $_GET['product_id'];

  // Perform a database query to fetch product details based on the product ID
  $query = "SELECT productName, selling_price FROM products WHERE productId = $productId";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $productDetails = mysqli_fetch_assoc($result);
    echo $productDetails['productName'] . ',' . $productDetails['selling_price'];
  } else {
    echo ''; // Return an empty string if product ID is not found
  }
}
$connection->close();

?>