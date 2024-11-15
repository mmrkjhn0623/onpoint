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
	
    <body class="sb-nav-fixed" >
        <nav class="sb-topnav navbar navbar-expand bg-cus">
            <a class="navbar-brand" href="index.php"><img href="index.php" src="logoonp.png" style="height: 42px; margin: 0px 0px 0px 10px;"></a>
			<button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

            </form>
            <!-- Navbar-->
            <div class="navbar-nav ml-auto ml-md-0 small">
			<a class="nav-link dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION["nickname"]."  ";?></i></a>
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
                            <li class="breadcrumb-item active" ><?php echo "".$_SESSION["address"]."  |  ".$_SESSION["contact"].""; ?></li>
                        </ol>
						<div id="alerthere" >
						<?php
							
							if(isset($_SESSION["alert"])){
								if($_SESSION["alert"] == "nosi"){
									echo "<div class='alert alert-danger alert-dismissible' id='alertdiv'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Sale Invoice is Empty</strong></div>";									
								}
								unset($_SESSION["alert"]);
							}
							?>
						</div>
						<div class="card shadow-lg border-0 rounded-lg mt-5">
							<div class="card-header"><h3 class="text-center font-weight-light my-4">Return Sale</h3></div>
							<div class="card-body">
							<form method="POST" action="returnsale.php">
										
											<div class="form-row">
											<div class="col-md-3">
                                                    &nbsp;
                                            </div>
										
											<div class="col-md-6">
											<label class="small mb-1" >Invoice No.</label>
												<input type="number" id="invoiceno" name="invoiceno" class="form-control" min="0" placeholder="Enter Invoice No." required/>
											</div>
												<div class="col-md-1">
													<label class="small mb-1" ></label>
													<input type="submit" id="btnGo" class="btn btn-primary btn-block" value="Go" />
												</div>
											</div>
											
									
										
							</form>
							<br/><br/>
							<div class="card-header">
                                Invoice No. 
								<?php 
									if(!isset($_POST["invoiceno"])){
										echo "";
									}
									else{
										echo "<b>".str_pad($_POST["invoiceno"], 6, "0", STR_PAD_LEFT)."</b>";
									}
								?>
                            </div>
							<div class="card-body">
								<form onsubmit="ReturnQuantity();ValidateReturnSale();return false;" >
								<div class="table-responsive">
                                    <table class="table table-bordered" id="ItemTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
												<th>Item</th>
												<th>Sale Quantity</th>
												<th>Cost</th>
												<th>Quantity to Return</th>
												
												
                                            </tr>
                                        </thead>

                                        <tbody id="trow">   
										<?php
											$query = "SELECT invoice.item_id as 'itemid', invoice.si_no as 'sino', invoice.quantity as 'quantity', invoice.quantity * invoice.sold_price as 'cost', items.item_name as 'item' FROM items,invoice where items.item_id = invoice.item_id and invoice.company_id = '".$_SESSION["companyid"]."' and invoice.si_no = '".$_POST["invoiceno"]."' and invoice.si_no != '0' and invoice.quantity != 0";
											$result = $conn->query($query);

											if ($result->num_rows > 0) {
												while($row = $result->fetch_assoc()) {
													echo "<input type='hidden' id='forsi' value='".$row["sino"]."' />
													<tr>
													<td>".$row["item"]."</td>
													<td>".$row['quantity']."</td>
													<td>".number_format($row['cost'],2)."</td>
													<td><input type='number' class='form-control' name='quan".$row["item"]."' id='quan".$row["item"]."' min='1' max='".$row["quantity"]."' /></td>
													</tr>";
												}
											}
											$conn->close();
										?>
                                        </tbody>
                                    </table>
									<script>
									
									function ReturnQuantity(){
										table = document.getElementById("ItemTable");
										var tr = table.getElementsByTagName("tr");
										var totalquantity = 0; 
										var totalreturnquantity = 0;
										for(i = 1; i < tr.length; i++){
											totalreturnquantity = totalreturnquantity + document.getElementById("quan"+document.getElementById("ItemTable").rows[i].cells[0].innerHTML+"").value;
										}
										document.getElementById("totalquantity").value = totalreturnquantity;
										
									}
									
									function ValidateReturnSale(){
											table = document.getElementById("ItemTable");
											var tr = table.getElementsByTagName("tr");
											var totalquantity = 0; 
											var returnquantity = 0;
											var i;var j;
											if(tr.length > 1 && document.getElementById("totalquantity").value != 0){
													var r = confirm("Are You Sure You Want to Process Return Sale?");
													if(r == true){
													document.getElementById("btnreturnsale").value = "Please Wait...";
													document.getElementById("btnreturnsale").disabled = true;	
													
													for(i = 1; i < tr.length; i++){
														totalquantity = totalquantity + parseInt(document.getElementById("ItemTable").rows[i].cells[1].innerHTML);
														returnquantity = returnquantity + parseInt(document.getElementById("quan"+document.getElementById("ItemTable").rows[i].cells[0].innerHTML+"").value);
														if(returnquantity != 0){
															var xmlhttpinvoice = new XMLHttpRequest();
															xmlhttpinvoice.onreadystatechange = function() {
															if (this.readyState == 4 && this.status == 200) {
																document.getElementById("lala").innerHTML += this.responseText;
															}
															};
															xmlhttpinvoice.open("GET","processreturnsale.php?item="+document.getElementById("ItemTable").rows[i].cells[0].innerHTML+"&quantity="+document.getElementById("quan"+document.getElementById("ItemTable").rows[i].cells[0].innerHTML+"").value+"&sino="+document.getElementById("forsi").value,true);
															xmlhttpinvoice.send();
														}														
													}	
													for(i = 1; i < tr.length; i++){
														document.getElementById("quan"+document.getElementById("ItemTable").rows[i].cells[0].innerHTML+"").disabled = true;
													}
 														document.getElementById("btnreturnsale").value = "Return Sale";
														if(totalquantity == returnquantity){
															document.getElementById("alerthere").innerHTML = "<br/><div class='alert alert-danger alert-dismissible d-flex justify-content-between' id='alertdiv'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Sales Successfully Returned!</strong></div>";
														}
														else{
															document.getElementById("alerthere").innerHTML = "<br/><div class='alert alert-danger alert-dismissible d-flex justify-content-between' id='alertdiv'><strong>Sales Successfully Returned!</strong><div><a href='generateinvoice.php?si="+document.getElementById("forsi").value+"' target='_blank' >Print Sale Invoice</a></div></div>";
														}
																										
														document.body.scrollTop = 0; // For Safari
														document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera		
													}														
											}
									}
									
									</script>
                                </div><br/><br/>
							<div class="form-row">
							
							<div class="col-md-10"></div>
							<div class="col-md d-flex flex-row-reverse">
								<input type="hidden" id="totalquantity" />
								<input type="submit" class="btn btn-danger" value="Return Sale" id="btnreturnsale"/>&nbsp;
							</div>
							</div>								
								</form>
                            </div>	
							<div class="card-footer text-center">
                            </div>
                        </div>
						
						</div>
					
                </main>
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
