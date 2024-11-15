<?php
session_start();
$q = $_GET['q'];
include "config.php";

$sql="SELECT item_id, unit_price FROM items WHERE item_id = '".$q."' and company_id = '".$_SESSION["companyid"]."'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)) {
	echo $row["unit_price"];
}
mysqli_close($conn);
?>