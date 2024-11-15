<?php
session_start();
$q = $_GET['q'];
include "config.php";

$sql="SELECT item_id,item_name, stock, company_id FROM items WHERE item_id = '".$q."' and company_id = '".$_SESSION["companyid"]."' ";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)) {
	echo $row["stock"];
}
mysqli_close($conn);
?>