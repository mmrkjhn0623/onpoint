<?php
session_start();
$item = $_GET['item'];
$quantity = $_GET['quantity'];
$sino = $_GET['sino'];
$customer = $_GET['customer'];

include "config.php";

$sql="SELECT item_id,item_name,unit_price FROM items WHERE item_name = '".$item."'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)) {
$invoiceitem = "INSERT INTO invoice (si_no, item_id, sold_price, quantity, date, company_id)
VALUES ('".$sino."','".$row["item_id"]."','".$row["unit_price"]."','".$quantity."', NOW(), '".$_SESSION["companyid"]."')";
$conn->query($invoiceitem);

$query = "UPDATE items SET stock = stock - $quantity WHERE items.item_name = '$item'";
$conn->query($query);


}
mysqli_close($conn);
?>