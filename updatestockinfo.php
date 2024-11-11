<?php
session_start();
include "config.php";

$item = $_POST['foritemid'];
$itemname = $_POST['itemName'];
$unit = $_POST['unit'];
$price = $_POST['price'];

$query = "UPDATE items SET item_name = '$itemname', unit = '$unit', unit_price = '$price' WHERE item_id = '$item' and company_id = '".$_SESSION["companyid"]."'";

if ($conn->query($query) === TRUE) {
  $_SESSION["alert"] = "updateitem";
  header("Location: updatestock.php?item=".$item);
} else {
  echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>