<?php
session_start();
$q = $_GET['q'];
include "config.php";

$sql="SELECT item_name, item_id FROM items WHERE item_name = '".$q."' and company_id = '".$_SESSION["companyid"]."'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)) {
	echo $row["item_id"];
}
mysqli_close($conn);
?>