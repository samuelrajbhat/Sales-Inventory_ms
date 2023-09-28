<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    // Validate form data
    $errors = [];

    if (empty($name)) {
        $errors[] = "Please enter your name.";
    }

    if (empty($phone)) {
        $errors[] = "Please enter your phone number.";
    } elseif (!preg_match("/^\d{10}$/", $phone)) {
        $errors[] = "Please enter a valid 10-digit phone number.";
    }

    if (empty($address)) {
        $errors[] = "Please enter your address.";
    }

    // If there are no validation errors, proceed with further actions
    if (empty($errors)) {
        // Perform additional operations (e.g., database insertion)

        echo "Registration successful!";
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }

    include "connection.php";//including the connection setup program

    $sql= "INSERT INTO customers(customerName, cPhone , cAddress) VALUES('$name', '$phone','$address')";

if ($connection->query($sql) === true) {
  echo "Customer registred sucessfully successfully.";
} 
else {
  echo "Error: " . $sql . "<br>" . $connection->error;

}
$connection->close();


}
?>