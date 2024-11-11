<?php
session_start();
include "config.php";

$bname = $_POST['businessname'];
$baddress = $_POST["address"];
$bcontact = $_POST["contact"];

$query = "UPDATE company SET name = '$bname', address = '$baddress', contact = '$bcontact' WHERE company_id = '".$_SESSION["companyid"]."'";

if ($conn->query($query) === TRUE) {
  $_SESSION["company"] = $bname;
  $_SESSION["address"] = $baddress;
  $_SESSION["contact"] = $bcontact;
  $_SESSION["alert"] = "businessinfoupdate";
  header("Location: businessinfo.php");
} else {
  echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>