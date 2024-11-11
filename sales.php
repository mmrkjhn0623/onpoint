<?php 
session_start();
include "config.php";
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
	
    <body class="sb-nav-fixed" onload="getunitPrice(document.getElementById('selectitem').options[0].text)">
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
							<div class="card-header"><h3 class="text-center font-weight-light my-4">Choose Item</h3></div>
							<div class="card-body">
						<form onsubmit="return false;" >
											<div class="form-row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="small mb-1" >Item</label>
														<input type="hidden" id="forunitprice" name="forunitprice">
														<input type="hidden" id="forstock" name="forstock">
														<input type="hidden" id="forsi" name="forsi" >
                                                        <select class="form-control" id="selectitem" name="selectitem" onchange="getunitPrice(this.value)">
														<?php
														$sql = "SELECT item_id, item_name,unit_price FROM items where company_id = '".$_SESSION["companyid"]."' and stock != 0 order by item_name";
														$result = $conn->query($sql);
														
														
														if ($result->num_rows > 0) {
														// output data of each row
														while($row = $result->fetch_assoc()) {
														echo "
														<option>".$row["item_name"]."</option>
														";
														array_push($unit_price,$row["item_id"]);
														
														}
														} else {
															echo "0 results";
														}
														$conn->close();
														?>
														</select>
														<script>

														</script>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" >Quantity</label>
                                                        <input class="form-control" id="quantity" type="number" name="quantity" min="0" value="0" required/>
														<input type="hidden" id="tablerow" name="tablerow" value="0" />
                                                    </div>
                                                </div>
												<div class="col-md-1">
													<label class="small mb-1" ></label>
													<input type="button" id="btnAdd" class="btn btn-primary btn-block" value="Add" onclick="return Additem();" />
												</div>
												
												<script>
												function getunitPrice(str){
													if (str == "") {
														document.getElementById("lala").innerHTML = "";
														return;
													} 
													else {
														var xmlhttpprice = new XMLHttpRequest();
														xmlhttpprice.onreadystatechange = function() {
														if (this.readyState == 4 && this.status == 200) {
															document.getElementById("forunitprice").value = this.responseText;
															}
														};
													xmlhttpprice.open("GET","getunitprice.php?q="+str,true);
													xmlhttpprice.send();
													
														var xmlhttpstock = new XMLHttpRequest();
														xmlhttpstock.onreadystatechange = function() {
														if (this.readyState == 4 && this.status == 200) {
															document.getElementById("forstock").value = this.responseText;
																			}
														};
													xmlhttpstock.open("GET","getstock.php?q="+str,true);
													xmlhttpstock.send();
													}
															/* document.getElementById("lala").innerHTML	= document.getElementById("selectitem").value; */
																													
												}		
												
												function Additem(){
													if(document.getElementById("quantity").value <= parseInt(document.getElementById("forstock").value)){
														
														table = document.getElementById("ItemTable");
  														var forprice = document.getElementById("forunitprice").value;
														var amount = forprice * document.getElementById("quantity").value;
														var tr = table.getElementsByTagName("tr");
														var itemonthelist;
														var itemonthelistrow;
														var i; 
														var newquantity
									
														for (i = 0; i < tr.length; i++) {
															if(document.getElementById("selectitem").value == document.getElementById("ItemTable").rows[i].cells[0].innerHTML){
																itemonthelist = 1;	
																itemonthelistrow = i;
															}
														}
														
														if(itemonthelist == 1){
															newquantity = parseInt(document.getElementById("ItemTable").rows[itemonthelistrow].cells[2].innerHTML) + parseInt(document.getElementById("quantity").value);
															
															if(document.getElementById("quantity").value > 0 && newquantity <= parseInt(document.getElementById("forstock").value)){
															document.getElementById("ItemTable").rows[itemonthelistrow].cells[2].innerHTML = newquantity;
															amount = forprice * newquantity;
															document.getElementById("ItemTable").rows[itemonthelistrow].cells[3].innerHTML = Number(amount).toLocaleString('en');
															
															return ComputePOS();
															
															
															
															
/* 															document.getElementById("totalquantity").innerHTML = parseInt(document.getElementById("totalquantity").innerHTML) + parseInt(document.getElementById("quantity").value);
															document.getElementById("grandtotalamount").innerHTML = Number(parseFloat(document.getElementById("grandtotalamount").innerHTML) + amount).toLocaleString('en');
															 */
															}
															else{
																alert("Invalid Quantity");
																document.getElementById("quantity").value = parseInt(document.getElementById("forstock").value) - parseInt(document.getElementById("ItemTable").rows[itemonthelistrow].cells[2].innerHTML);
																
															
															}
														}
														else {
															if(document.getElementById("quantity").value > 0){
															document.getElementById("trow").innerHTML  += "<tr onmouseover='rowtodelete = this.rowIndex'><td>"+document.getElementById("selectitem").value+"</td><td>"+Number(forprice).toLocaleString('en')+"</td><td>"+parseInt(document.getElementById("quantity").value)+"</td><td>"+Number(amount).toLocaleString("en")+"</td><td><a href='#?' onclick='return deleteTableRow(rowtodelete)' id='deleteRow' class='delete' title='Delete' data-toggle='tooltip'><i class='material-icons'>delete</i></a></td></tr>";
															
															return ComputePOS();
															
															
															}
															else{
																alert("Invalid Quantity");
															document.getElementById("quantity").value = document.getElementById("forstock").value;
															
															
															}
/* 															document.getElementById("totalquantity").innerHTML = parseInt(document.getElementById("totalquantity").innerHTML) + parseInt(document.getElementById("quantity").value);
															document.getElementById("grandtotalamount").innerHTML = Number(parseFloat(document.getElementById("grandtotalamount").innerHTML) + amount).toLocaleString('en');
												 */
														}
														
												
														/* document.getElementById("selectitem").remove(document.getElementById("selectitem").selectedIndex); */
												
													}
													else{
														alert("Invalid Quantity");
														document.getElementById("quantity").value = document.getElementById("forstock").value;
														
														
													}
												return getunitPrice(document.getElementById("selectitem").value);
												}
												
												function deleteTableRow(rowdel){
													/* var option = document.createElement("option");
													option.text = document.getElementById("ItemTable").rows[rowdel].cells[0].innerHTML;
													document.getElementById("selectitem").add(option); */		
													
													document.getElementById("ItemTable").deleteRow(rowdel);		
													return ComputePOS();
												}
												
												function ComputePOS(){
													table = document.getElementById("ItemTable");
													var tr = table.getElementsByTagName("tr");
													var totalquantity = new Array();
													var grandamount = new Array();
													totalquantity[0] = 0;
													grandamount[0] = 0;
													var i;var j;
													
													for(i = 1; i < tr.length; i++){
														/* totalquantity = parseInt(document.getElementById("ItemTable").rows[i].cells[2].innerHTML); */
														totalquantity[i] = parseInt(document.getElementById("ItemTable").rows[i].cells[2].innerHTML);
														grandamount[i] = parseInt(document.getElementById("ItemTable").rows[i].cells[3].innerHTML.replace(",",""));
/* 														document.getElementById("grandtotalamount").innerHTML = document.getElementById("grandtotalamount").innerHTML + document.getElementById("ItemTable").rows[i].cells[3].innerHTML;
													*/
													}
													
													var fortotalquantity = totalquantity.reduce(myFunc);

													function myFunc(a, b) {
													return a + b;
													}

													var forgrandamount = grandamount.reduce(myFuncamount);

													function myFuncamount(a, b) {
													return a + b;
													}
													
													if(tr.length > 3){
														var forquantitydis = fortotalquantity - parseInt(document.getElementById("totalquantity").innerHTML);
														var forgrandamountdis = forgrandamount - parseInt(document.getElementById("grandtotalamount").innerHTML.replace(",",""));
														document.getElementById("totalquantity").innerHTML = forquantitydis;
														document.getElementById("grandtotalamount").innerHTML = Number(forgrandamountdis).toLocaleString('en');
													}
													else if(tr.length == 3){
														document.getElementById("totalquantity").innerHTML = totalquantity[1];
														document.getElementById("grandtotalamount").innerHTML = Number(grandamount[1]).toLocaleString('en');
													}
													else{
														document.getElementById("totalquantity").innerHTML = "";
														document.getElementById("grandtotalamount").innerHTML = "";
													}

													document.getElementById("quantity").value = 0;

													
													return getSI();
													
												}
												function getSI(){
													var xmlhttpsi = new XMLHttpRequest();
													xmlhttpsi.onreadystatechange = function() {
														if (this.readyState == 4 && this.status == 200) {
															document.getElementById("forsi").value = parseInt(this.responseText) + 1;
														}
													};
													xmlhttpsi.open("GET","getsi.php",true);
													xmlhttpsi.send();
													
												}
												
												function Invoice(){
													table = document.getElementById("ItemTable");
													var tr = table.getElementsByTagName("tr");
													var totalquantity = new Array();
													var grandamount = new Array();
													totalquantity[0] = 0;
													grandamount[0] = 0;
													var i;var j;
													if(tr.length > 2){
													var r = confirm("Are You Sure You Want to Proceed?");
													if(r == true){
														getSI();
														document.getElementById("btnProceed").value = "Please Wait...";
														document.getElementById("btnProceed").disabled = true;
														document.getElementById("btnClear").disabled = true;
													
														for(i = 1; i < tr.length; i++){
															var xmlhttpinvoice = new XMLHttpRequest();
															xmlhttpinvoice.onreadystatechange = function() {
															if (this.readyState == 4 && this.status == 200) {
																document.getElementById("lala").innerHTML += this.responseText;
															}
															};
															xmlhttpinvoice.open("GET","invoice.php?item="+document.getElementById("ItemTable").rows[i].cells[0].innerHTML+"&quantity="+document.getElementById("ItemTable").rows[i].cells[2].innerHTML+"&sino="+document.getElementById("forsi").value,true);
															xmlhttpinvoice.send();
														}
														
														/* window.open("generatereport.php"); */
													
														for(i = 1; i < tr.length; i++){
														document.getElementById("ItemTable").rows[i].cells[4].innerHTML = "";
														}

														setTimeout(() => {
															document.getElementById("alerthere").innerHTML = "<br/><div class='alert alert-success alert-dismissible d-flex justify-content-between' id='alertdiv'><strong>Sales Successfully Processed!</strong><div><a href='sales.php'>New Transaction</a> | <a href='generateinvoice.php?si="+document.getElementById("forsi").value+"' target='_blank' >Print Sale Invoice</a></div></div>";
															document.getElementById("btnProceed").value = "Checkout";
															document.getElementById("btnAdd").disabled = true;
														}, 1800);
														
														document.body.scrollTop = 0; // For Safari
														document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
													
													}
													else{
														return false;
													}
													}
													else{
														if(tr.length <= 2){
															alert("Please select Items for Checkout!");
														}
													}
												}
												
												function Clearpos(){
													table = document.getElementById("ItemTable");
													var tr = table.getElementsByTagName("tr");
													
													for(i = 1; tr.length > 2; i++){
														document.getElementById("ItemTable").deleteRow(1);	
													}
															
													return ComputePOS();
												}
												
												</script>
											</div>
										
							
							<br/><br/>
							<div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Point of Sales
                            </div>
							<div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="ItemTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Unit Price</th>
                                                <th>Quantity</th>
                                                <th>Cost</th>
												<th></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th></th>
												<input type="hidden" name="countquantity" value="0">
                                                <th id="totalquantity" ></th>
                                                <th id="grandtotalamount"  ></th>
												<th></th>
                                            </tr>
                                        </tfoot>
                                        <tbody id="trow">                                           
                                        </tbody>
                                    </table>
                                </div>
							
							</div>

						
							<br/>
							<div class="form-row">
							
							<div class="col-md-10"></div>
							<div class="col-md d-flex flex-row-reverse">
								<input type="button" class="btn btn-secondary" onclick="Clearpos();" id="btnClear" value="Clear" />&nbsp;
								<input type="button" class="btn btn-success" onclick="Invoice();" id="btnProceed" value="Checkout" />
							</div>
							</div>
							</div>	
							<div class="card-footer text-center">
                            </div>
                        </div>
						
						</form>				
                        
					
						<div class="col-md">
                            <div class="form-group">
                                
                            </div>
                        </div>
						<br/><br/><br/>
                    </div>
                </main>
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
