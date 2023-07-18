<?php

// Retrieve form data

$productName = $_POST['productName'];
$productDescription = $_POST['productDescription'];
$costPrice = $_POST['costPrice'];
$sellingPrice = $_POST['sellingPrice'];
$quantity = $_POST['quantity'];
$category = $_POST['category'];
$manufacturer = $_POST['manufacturer'];


// Insert the data into the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sims";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO products ( productName, productDescription, cost_price, selling_price, quantity,category,manufacturer)
        VALUES ('$productName', '$productDescription', '$costPrice', '$sellingPrice', '$quantity','$category','$manufacturer')";

if ($conn->query($sql) === true) {
  echo "Product added successfully.";
} 
else {
  echo "Error: " . $sql . "<br>" . $conn->error;

}

$conn->close();

?>


