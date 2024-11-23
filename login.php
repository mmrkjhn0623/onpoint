<?php
session_start();
include "config.php";
if(isset($_SESSION["user"])){
	header("Location: index.php");
}
 
error_reporting(0);
$invalidalert = ""; 
if($_GET["invalid"]){
	$invalidalert = "<div class='alert alert-success alert-danger' id='alertdiv'><center><strong>Invalid Username or Password!</strong></center></div>";
}
else{
	$invalidalert = "";
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="google-signin-client_id" content="924512832568-2tlj7jhvppd56ajk2aiu9gi8fib89t5k.apps.googleusercontent.com">
        <title>OnPoint Online Inventory and Sale Monitoring System</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        
		<script>
		$(document).ready(function(){

		document.getElementById("invalid").innerHTML += "fersse";
			
		});
		</script>
		
		<link rel="icon" href="onpointweblogo.png" type="image/icon type">
    </head>
    <body class="bg-primary bg-cus">
        <div id="layoutAuthentication">
		
            <div id="layoutAuthentication_content">
                <main>		
                    <div class="container" style="height:100vh;display:flex;align-items:center;justify-content:center;">
			
                        <div class="row justify-content-center">
						
                            <div class="col">

                                <div class="card shadow-lg border-0 rounded-lg mb-5">
                                    <div class="card-header">
									<h5 class="text-center font-weight-light my-4"><img src="logoonp.png" style="width:142px;height:auto;margin-bottom:8px;" /><br/>Online Inventory and Sales Monitoring System</h5>
									</div>									
                                    <div class="card-body">
										<div class="small mb-1" id="invalid" style="color:red;" ><?php echo $invalidalert; ?></div>
                                        <div id="signinform">
                                            <h4 class="mb-3 text-center">Sign in to your account</h4>
                                            <form method="POST" action="authenticate.php" >
                                                <div class="form-group">
                                                    <label class="small mb-1" id="foruser">Email</label>
                                                    <input class="form-control py-4" id="inputUsername" name="inputUsername" type="email" placeholder="Enter Username" onclick="document.getElementById('invalid').innerHTML = '';" required />
                                                </div>
                                                <div class="form-group">
                                                    <label class="small mb-1" id="forpass">Password</label>
                                                    <input class="form-control py-4" id="inputPassword" name="inputPassword" type="password" placeholder="Enter password" onclick="document.getElementById('invalid').innerHTML = '';"required />
                                                </div>
                                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                    <input type="submit" class="btn btn-primary btn-block" value="Sign in" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div id="signupbtn" class="medium my-2">Don't have an account? <a href="createaccount.php">Sign Up</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
