<?php
session_start();
include "config.php";

$itemname = $_POST['itemname'];
$unit = $_POST['unit'];
$price = $_POST['price'];

$query = "INSERT INTO items (item_name, unit, unit_price, stock, company_id)
VALUES ('$itemname', '$unit', '$price', '0', '".$_SESSION["companyid"]."')";

if ($conn->query($query) === TRUE) {
  $_SESSION["alert"] = "newitem";
  header("Location: newstock.php");
}
 else {
  echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>