<?php
session_start();
include "config.php";

$query = "UPDATE invoice,items SET invoice.quantity = invoice.quantity - ".$_GET["quantity"]." WHERE items.item_name = '".$_GET["item"]."' and invoice.company_id = '".$_SESSION["companyid"]."' and si_no = '".$_GET["sino"]."' and invoice.item_id = items.item_id";

if ($conn->query($query) === TRUE) {
  
	$query = "UPDATE items SET stock = stock + ".$_GET["quantity"]." WHERE item_name = '".$_GET["item"]."' and company_id = '".$_SESSION["companyid"]."'";
	$conn->query($query);
  
  $_SESSION["alert"] = "returnsale";
} else {
  echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>