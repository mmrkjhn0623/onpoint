<?php
session_start();
include "config.php";
if(isset($_SESSION["user"])){
	header("Location: index.php");
}
 
include "config.php";
error_reporting(0);
$invalidalert = "";
if($_GET["response"] == 'invalid'){
	$alert = "<div class='alert alert-danger' id='alertdiv'><center><strong>The email has already been taken.</strong></center></div>";
}
else if($_GET["response"] == 'success'){
    $alert = "<div class='alert alert-success' id='alertdiv'><center><strong>Successfully registered! A password has been sent to your email.</strong></center></div>";
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
                    <div class="container" style="height:auto;min-height:100vh;display:flex;align-items:center;justify-content:center;">
			
                        <div class="row justify-content-center">
						
                            <div class="col">
                                <div class="card shadow-lg rounded-lg my-5 row">
                                    <div style="border-right:1px solid rgba(0, 0, 0, 0.125);">
                                        <div class="card-header">
                                            <h5 class="text-center font-weight-light"><img src="logoonp.png" style="width:142px;height:auto;margin-bottom:8px;" /><br/>Online Inventory and Sales Monitoring System</h5>
                                        </div>									
                                        <div class="card-body">
                                            <div class="small mb-1" id="invalid" style="color:red;" ><?php echo $alert; ?></div>
                                            <div id="signupform">
                                                <h4 class="mb-3 text-center">Sign up for OnPoint</h4>
                                                <form method="POST" action="register.php" >
                                                    <div class="form-group">
                                                        <label class="small mb-1">Email</label>
                                                        <input class="form-control py-4" id="registerEmail" name="registerEmail" type="email" placeholder="Enter Email" onclick="document.getElementById('invalid').innerHTML = '';" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1">Business Name</label>
                                                        <input class="form-control py-4" id="registerBname" name="registerBname" type="text" placeholder="Enter Business Name" onclick="document.getElementById('invalid').innerHTML = '';" required />
                                                    </div>
                                                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                        <input type="submit" class="btn btn-primary btn-block" value="Sign up" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <div id="signinbtn" class="medium my-2">Already have account? <a href="login.php"> Sign in</a></div>
                                        </div>
                                    </div>
                                    <div class="p-sm-5 px-3 py-5 d-flex justify-content-center align-items-center my-sm-auto mt-0 ">
                                        <div class="">
                                            <h2 class="mb-3">What are the inclusion</h2>
                                            <ul class="check-list d-flex flex-column" style="gap:8px;">
                                                <li>Instant Access to Real Devices</li>
                                                <li>30 mins each of interactive browser and mobile app testing</li>
                                                <li>100 mins of automated browser testing</li>
                                                <li>100 mins of automated mobile app testing</li>
                                                <li>5000 screenshots/month for visual testing with Percy <span class="label-primary label-badge">New</span></li>
                                                <li>Testing on internal development environments</li>
                                            </ul>
                                        </div>
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
