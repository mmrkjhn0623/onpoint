<?php
session_start();
include "config.php";

$newpass = $_POST["newpass"];

$query = "UPDATE users SET password = '$newpass' WHERE user_id = '".$_SESSION["userid"]."'";

if ($conn->query($query) === TRUE) {
  $_SESSION["alert"] = "newpass";
  header("Location: changepassword.php");
} else {
  echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>