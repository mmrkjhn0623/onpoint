<?php

// $servername = "sql203.infinityfree.com";
// $username = "if0_37670959";
// $password = "Dvplicadzswe06";
// $dbname = "if0_37670959_onpoint";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "onpoint";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>