<?php 
session_start();
include "config.php";
error_reporting(0);
if(!isset($_SESSION["user"])){
	header("Location: login.php");
}
$unit_price = array();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>OnPoint Online Inventory and Sale Monitoring System</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
		
		<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
			getunitPrice(document.getElementById("selectitem").options[0].text);
			
		});
		
		</script>
		
		<link rel="icon" href="onpointweblogo.png" type="image/icon type">
    </head>
	
    <body class="sb-nav-fixed" onload="setDateMax();hideOtherGo('btnDateGo');">
        <nav class="sb-topnav navbar navbar-expand bg-cus">
            <a class="navbar-brand" href="index.php"><img href="index.php" src="logoonp.png" style="height: 42px; margin: 0px 0px 0px 10px;"></a>
			<button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

            </form>
            <!-- Navbar-->
            <div class="navbar-nav ml-auto ml-md-0 small">
			<a class="nav-link dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION["user"]."  ";?></i></a>
			<div class="dropdown-menu dropdown-menu-right">
			  <a class="dropdown-item small" href="changepassword.php" >Change Password</a>
			  <div class="dropdown-divider"></div>
			  <a class="dropdown-item small" href="logout.php">Logout</a>
			</div>
				
            </div>
			
			
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading"></div>
							<a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Home
                            </a>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-check-alt"></i></div>
                                POS
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
									<a class="nav-link" href="sales.php"> New</a>
                                    <a class="nav-link" href="returnsale.php">Return</a>
									<a class="nav-link" href="saleinvoice.php">Sale Invoice</a>
                                    
                                </nav>
                            </div>
							
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                                Stock
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
								<nav class="sb-sidenav-menu-nested nav">
									<a class="nav-link" href="newstock.php">Add / New</a>
                                    <a class="nav-link" href="returnstock.php">Return</a>
                                </nav>
							</div>
							<a class="nav-link" href="salesreport.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Reports
                            </a>
							<a class="nav-link" href="businessinfo.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-landmark"></i></div>
                                Business Info 
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer sb-sidenav-light">
                        <div class="text-muted">Copyright &copy;</div>
                        <a href="index.php">onpoint.com</a>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4" ><?php echo $_SESSION["company"]; ?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo "".$_SESSION["address"]."  |  ".$_SESSION["contact"].""; ?></li>
                        </ol>
						<div id="alerthere" ></div>	
				<div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Generate Sales Report</h3></div>
                        <div class="card-body">
						<form>
										
							<div class="form-row" style="max-width:620px;margin-inline:auto;">
								<div class="col-md-12">
                                    &nbsp;
                                </div>
								<div class="col-md-12 mb-2">
									<label class="small mb-1" >Order by</label>
									<select type="date" id="selectorder" name="selectorder" class="form-control">
									<option>Date</option>
									<option>Product</option>
									</select>
								</div>
										
								<div class="col-md-12 mb-2">
									<label class="small mb-1" >Date From</label>
									<input type="date" id="datefrom" name="datefrom" class="form-control" onchange="setDatetoMin(this.value)" required/>
								</div>
								<div class="col-md-12 mb-2">
									<label class="small mb-1" >Date To</label>
									<input type="date" id="dateto" name="dateto" class="form-control" onchange="setDatefromMax(this.value)" required/>
								</div>
								<div class="col-md-12 mb-2">
									<label class="small mb-1" ></label>
									<input type="button" id="btnDateGo" class="btn btn-primary btn-block" value="Go" onclick="generateReport();" />
								</div>
								<div class="col-md-1">
                                    &nbsp;
                                </div>
							</div>	
						</form>
						</div>
                <div class="card-footer text-center"></div>
                </div>
                </main>
				<script>

				function setDateMax(){
					var today = new Date();
					var dd = today.getDate();
					var mm = today.getMonth()+1; //January is 0!
					var yyyy = today.getFullYear();
					 if(dd<10){
							dd='0'+dd;
						} 
						if(mm<10){
							mm='0'+mm;
						} 

					today = yyyy+'-'+mm+'-'+dd;
					document.getElementById("datefrom").setAttribute("max", today);
					document.getElementById("dateto").setAttribute("max", today);
				}
				function setDatetoMin(min){
					document.getElementById("dateto").setAttribute("min", min);
				}
				function setDatefromMax(max){
					document.getElementById("datefrom").setAttribute("max", max);
				}
				
				function generateReport(){
					if(document.getElementById("datefrom").value != "" && document.getElementById("dateto").value != ""){
						if(document.getElementById("selectorder").value == "Date"){
							window.open("salesreportbydate.php?datefrom="+document.getElementById("datefrom").value+"&dateto="+document.getElementById("dateto").value);
						}
						else{
							window.open("salesreportbyprod.php?datefrom="+document.getElementById("datefrom").value+"&dateto="+document.getElementById("dateto").value);
						}
					}
				}
				
				</script>
				<br/><br/><br/>
                <footer class="py-4 bg-light mt-auto fixed-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy;<a href="index.php"> onpoint.com</a></div>
							
                            <div>
                                <a href="privacypolicy.php">Privacy Policy</a>
                                &middot;
                                <a href="termandcondition.php">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
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
