<?php 
session_start();
include "config.php";
if(!isset($_SESSION["user"])){
	header("Location: login.php");
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
        <title>OnPoint Online Inventory and Sale Monitoring System</title>
        <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
		<link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
		<link rel="icon" href="onpointweblogo.png" type="image/icon type">
		<script>

		</script>
    </head>
    <body class="sb-nav-fixed">
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
									<a class="nav-link" href="newstock.php"> Add / New</a>
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
                        
						<div class="row">
							<div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body"><a href="#" class="text-white">All Time Best Sellers</a>
									</div>
									<div class="card-footer d-flex align-items-center justify-content-between small text-white">
									<?php
									$sql = "SELECT SUM(invoice.quantity * items.unit_price) as 'cost', SUBSTR(items.item_name,1,12) as 'item', SUM(invoice.quantity) as 'quantity' FROM items,invoice where items.item_id = invoice.item_id and invoice.company_id = '".$_SESSION["companyid"]."' and invoice.quantity != '0' group by items.item_name ORDER BY `cost` DESC limit 3";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									// output data of each row
									while($row = $result->fetch_assoc()) {
									echo "<a href='#' class='small text-white'>".$row["item"]."</a>";
									}
									}
									else{
										echo "<a href='#' class='small text-white'></a>
										  <div class='small text-white'>
										  </div>";
										  echo "<a href='#' class='small text-white'>No Data Found</a>
										  <div class='small text-white'>
										  </div>";
										  echo "<a href='#' class='small text-white'></a>
										  <div class='small text-white'>
										  </div>";
									}
									
									?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body"><a href="#" class="text-white">Hot Sale of the Month</a>
									</div>
									<div class="card-footer d-flex align-items-center justify-content-between small text-white">
									<?php
									$sql = "SELECT SUM(invoice.quantity * items.unit_price) as 'cost', SUBSTR(items.item_name,1,12) as 'item', SUM(invoice.quantity) as 'quantity' FROM items,invoice where items.item_id = invoice.item_id and invoice.company_id = '".$_SESSION["companyid"]."' and MONTH(invoice.date) = MONTH(CURRENT_DATE) and YEAR(invoice.date) = YEAR(CURRENT_DATE) and invoice.quantity != '0' group by items.item_name ORDER BY `cost` DESC limit 3";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									// output data of each row
									while($row = $result->fetch_assoc()) {
									echo "<a href='#' class='small text-white'>".$row["item"]."</a>
										  <div class='small text-white'>
										  </div>";
									}
									}
									else{
										echo "<a href='#' class='small text-white'></a>
										  <div class='small text-white'>
										  </div>";
										  echo "<a href='#' class='small text-white'>No Data Found</a>
										  <div class='small text-white'>
										  </div>";
										  echo "<a href='#' class='small text-white'></a>
										  <div class='small text-white'>
										  </div>";
									}
									
									?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body"><a href="#" class="text-white">Best Sellers Yesterday</a>
									</div>
									<div class="card-footer d-flex align-items-center justify-content-between small text-white">
									<?php
									$sql = "SELECT SUM(invoice.quantity * items.unit_price) as 'cost', SUBSTR(items.item_name,1,12) as 'item', SUM(invoice.quantity) as 'quantity' FROM items,invoice where items.item_id = invoice.item_id and invoice.company_id = '".$_SESSION["companyid"]."' and invoice.date = SUBDATE(CURRENT_DATE(),1) and invoice.quantity != '0' group by items.item_name ORDER BY `cost` DESC limit 3";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									// output data of each row
									while($row = $result->fetch_assoc()) {
									echo "<a href='#' class='small text-white'>".$row["item"]."</a>
										  <div class='small text-white'>
										  </div>";
									}
									}
									else{
										echo "<a href='#' class='small text-white'></a>
										  <div class='small text-white'>
										  </div>";
										  echo "<a href='#' class='small text-white'>No Data Found</a>
										  <div class='small text-white'>
										  </div>";
										  echo "<a href='#' class='small text-white'></a>
										  <div class='small text-white'>
										  </div>";
									}
									
									?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body"><a href="#" class="text-white">Lowest Sale Items</a>
									</div>
									<div class="card-footer d-flex align-items-center justify-content-between small text-white">
									<?php
									$sql = "SELECT SUM(invoice.quantity * items.unit_price) as 'cost', SUBSTR(items.item_name,1,12) as 'item', SUM(invoice.quantity) as 'quantity' FROM items,invoice where items.item_id = invoice.item_id and invoice.company_id = '".$_SESSION["companyid"]."' and invoice.quantity != '0' group by items.item_name ORDER BY `cost` ASC limit 3";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									// output data of each row
									while($row = $result->fetch_assoc()) {
									echo "<a href='#' class='small text-white'>".$row["item"]."</a>
										  <div class='small text-white'>
										  </div>";
									}
									}
									else{
										echo "<a href='#' class='small text-white'></a>
										  <div class='small text-white'>
										  </div>";
										  echo "<a href='#' class='small text-white'>No Data Found</a>
										  <div class='small text-white'>
										  </div>";
										  echo "<a href='#' class='small text-white'></a>
										  <div class='small text-white'>
										  </div>";
									}
									
									?>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        Daily Sale Monitoring
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar mr-1"></i>
                                        Monthly Sale Comparison
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
						
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between">
                                <div><i class="fas fa-table mr-1"></i>Stocks</div>
								<a href="inventoryreport.php" target="_blank">Print <i class="fa fa-print" aria-hidden="true"></i></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>                                           
											<?php
												$sql = "SELECT item_id, item_name, unit, unit_price, stock FROM items where company_id = '".$_SESSION["companyid"]."' order by 'stock' desc";
												$result = $conn->query($sql);

												if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {
												echo "
												<tr>
                                                <td><a href='updatestock.php?item=".$row["item_id"]."'>".$row["item_name"]."</a></td>
                                                <td>".$row["unit"]."</td>
                                                <td>".number_format($row["unit_price"], 2, '.', ',')."</td>
												<td>".$row["stock"]."</td>
												</tr>
												";
												}
												} else {
													echo "0 results";
												}
												
											?>
                                        </tbody>
                                    </table>
                                </div>
								<?php
								

								
								?>
                            </div>
							
                        </div>
						<?php	
							$sql = "SELECT SUM(invoice.quantity * invoice.sold_price) as 'cost' FROM items,invoice WHERE invoice.item_id = items.item_id and invoice.company_id = '".$_SESSION["companyid"]."' and YEAR(invoice.date) = YEAR(CURRENT_DATE)";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							// output data of each row
								while($row = $result->fetch_assoc()) {
									echo "<input type='hidden' id='totalsales' value='".$row["cost"]."' />";
								}
							}
							
							for($i=1; $i<=12; $i++){
								$sql = "SELECT SUM(invoice.quantity * invoice.sold_price) as 'cost', MONTH(invoice.date) as 'month' FROM items,invoice WHERE invoice.item_id = items.item_id and invoice.company_id = '".$_SESSION["companyid"]."' AND MONTH(invoice.date) = '".$i."' and YEAR(invoice.date) = YEAR(CURRENT_DATE) GROUP BY MONTH(invoice.date)";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								// output data of each row
									while($row = $result->fetch_assoc()) {
									echo "<input type='hidden' id='month".$i."' value='".$row["cost"]."'/>";
									}
								}
								else{
									echo "<input type='hidden' id='month".$i."' value='0' />";
								}
							}
							
							$sql = "SELECT SUM(invoice.quantity * invoice.sold_price) as 'cost' FROM items,invoice WHERE invoice.item_id = items.item_id and invoice.company_id = '".$_SESSION["companyid"]."' and invoice.date >= SUBDATE(CURRENT_DATE(),11) and invoice.date <= SUBDATE(CURRENT_DATE(),1)";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							// output data of each row
								while($row = $result->fetch_assoc()) {
									echo "<input type='hidden' id='totalfordailychart' value='".$row["cost"]."' />";
								}
							}
							
							for($i=10; $i>0; $i--){
								$sql = "SELECT SUM(invoice.quantity * invoice.sold_price) as 'cost' FROM items,invoice WHERE invoice.item_id = items.item_id and invoice.company_id = '".$_SESSION["companyid"]."' and invoice.date = SUBDATE(CURRENT_DATE(),".$i.")";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								// output data of each row
									while($row = $result->fetch_assoc()) {
									echo "<input type='hidden' id='day".$i."' value='".$row["cost"]."'/>";
									}
								}
								else{
									echo "<input type='hidden' id='day".$i."' value='0' />";
								}
							}
							
							
						?>
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

        <script src="js/jquery-3.5.1.slim.js" crossorigin="anonymous"></script>
        <script src="js/bootstrap.bundle.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
		
<script>
		
		// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var totalvalue = document.getElementById("totalsales").value;
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Octo", "Nov", "Dec"],
    datasets: [{
      label: "Sales",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: [document.getElementById("month1").value,
	  document.getElementById("month2").value,
	  document.getElementById("month3").value,
	  document.getElementById("month4").value,
	  document.getElementById("month5").value,
	  document.getElementById("month6").value,
	  document.getElementById("month7").value,
	  document.getElementById("month8").value,
	  document.getElementById("month9").value, 
	  document.getElementById("month10").value,
	  document.getElementById("month11").value, 
	  document.getElementById("month12").value],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'Month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 12
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: parseInt(totalvalue*1.10),
          maxTicksLimit: 10
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});


// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Area Chart Example
var today = new Date();
var day1 = new Date();
var day2 = new Date();
var day3 = new Date();
var day4 = new Date();
var day5 = new Date();
var day6 = new Date();
var day7 = new Date();
var day8 = new Date();
var day9 = new Date();
var day10 = new Date();

day10.setDate(today.getDate() - 1);
day9.setDate(today.getDate() - 2);
day8.setDate(today.getDate() - 3);
day7.setDate(today.getDate() - 4);
day6.setDate(today.getDate() - 5);
day5.setDate(today.getDate() - 6);
day4.setDate(today.getDate() - 7);
day3.setDate(today.getDate() - 8);
day2.setDate(today.getDate() - 9);
day1.setDate(today.getDate() - 10);

const months = [
  'Jan',
  'Feb',
  'Mar',
  'Apr',
  'May',
  'Jun',
  'Jul',
  'Aug',
  'Sep',
  'Oct',
  'Nov',
  'Dec'
]

var monthName = months[day1.getMonth()];

var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [ months[day1.getMonth()] + " "+ day1.getDate() , 
			  months[day2.getMonth()] + " "+ day2.getDate() ,
			  months[day3.getMonth()] + " "+ day3.getDate() ,
			  months[day4.getMonth()] + " "+ day4.getDate() ,
			  months[day5.getMonth()] + " "+ day5.getDate() ,
	  	      months[day6.getMonth()] + " "+ day6.getDate() ,
			  months[day7.getMonth()] + " "+ day7.getDate() ,
			  months[day8.getMonth()] + " "+ day8.getDate() ,
			  months[day9.getMonth()] + " "+ day9.getDate() ,
			  months[day10.getMonth()] + " "+ day10.getDate() ,],
    datasets: [{
      label: "Sales",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: [document.getElementById("day10").value,
	  document.getElementById("day9").value,
	  document.getElementById("day8").value,
	  document.getElementById("day7").value,
	  document.getElementById("day6").value,
	  document.getElementById("day5").value,
	  document.getElementById("day4").value,
	  document.getElementById("day3").value,
	  document.getElementById("day2").value, 
	  document.getElementById("day1").value],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'Date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 8
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: parseInt(document.getElementById("totalfordailychart").value*1.10),
          maxTicksLimit: 6
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});

		
</script>
</body>
</html>
