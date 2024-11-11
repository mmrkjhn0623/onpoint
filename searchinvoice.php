<?php
session_start();
include "config.php";
$sidate = $_GET["sidate"];
$query = "SELECT si_no FROM invoice where company_id = '".$_SESSION["companyid"]."' and date='".$sidate."' group by si_no";
$result = $conn->query($query);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo "<tr><td><center><a href='generateinvoice.php?si=".$row["si_no"]."' target='_blank'>".$row["si_no"]."</a></center></td></tr>";
	}
}
else {
  echo "<tr><td><center>No data available in table</center></td></tr>";
}

$conn->close();
?>