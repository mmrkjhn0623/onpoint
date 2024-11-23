<?php
session_start();

$user = $_POST['inputUsername'];
$pass = $_POST['inputPassword'];

include "config.php";

$sql="SELECT user_id,username,password,nickname,company_id FROM users WHERE username = '".$user."' and password ='".$pass."'";
$result = mysqli_query($conn,$sql);

if($row = mysqli_fetch_array($result)) {
	
	$_SESSION["user"] = $user;
	$_SESSION["pwd"] = $pass;
	$_SESSION["userid"] = $row["user_id"];
	$_SESSION["companyid"] = $row["company_id"];
	$_SESSION['nickname'] = explode('@', $user)[0];
	
	$sqlcompany="SELECT name,address,contact FROM company WHERE company_id = '".$row["company_id"]."' ";
	$resultcompany = mysqli_query($conn,$sqlcompany);
	if($rowcompany = mysqli_fetch_array($resultcompany)) {
		$_SESSION["company"] = $rowcompany["name"];
		$_SESSION["address"] = $rowcompany["address"];
		$_SESSION["contact"] = $rowcompany["contact"];
		
		header("Location: index.php");
	}
}

else{
	header("Location: login.php?invalid=1");
}
mysqli_close($conn);
?>