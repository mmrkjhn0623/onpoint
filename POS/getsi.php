<?php
session_start();
include "config.php";

$query = "SELECT convert(si_no, int) as 'si' FROM invoice where company_id = '".$_SESSION["companyid"]."' order by si_no desc limit 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo $row["si"];
	}
}
else {
  echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>