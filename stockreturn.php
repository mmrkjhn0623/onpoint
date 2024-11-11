<?php
session_start();
include "config.php";

$item = $_POST['selectitem'];
$itemstock = $_POST['itemstock'];

$query = "UPDATE items SET stock = stock - $itemstock WHERE items.item_name = '$item' and company_id = '".$_SESSION["companyid"]."'";

if ($conn->query($query) === TRUE) {
  $_SESSION["alert"] = "returnstock";
  header("Location: returnstock.php");
} else {
  echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>