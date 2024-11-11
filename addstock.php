<?php
session_start();
include "config.php";

$item = $_POST['selectitem'];
$itemstock = $_POST['itemstock'];

$query = "UPDATE items SET stock = stock + $itemstock WHERE items.item_id = '$item'";

if ($conn->query($query) === TRUE) {
  $_SESSION["alert"] = "stock";
  header("Location: newstock.php");
} else {
  echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>