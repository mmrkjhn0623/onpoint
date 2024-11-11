<?php
session_start();



//include connection file 
include_once('fpdf183/fpdf.php');

Class dbObj{
/* Database connection start */
var $dbhost = "localhost";
var $username = "root";
var $password = "";
var $dbname = "onpoint";
var $conn;
function getConnstring() {
$con = mysqli_connect($this->dbhost, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());

/* check connection */
if (mysqli_connect_errno()) {
printf("Connect failed: %s\n", mysqli_connect_error());
exit();
} else {
$this->conn = $con;
}
return $this->conn;
}
}
 
class PDF extends FPDF
{
// Page header
function Header()
{	

	$this->SetFont('Arial','B',16);
    $this->Cell(0,20,$_SESSION["company"],0,0,'C');
	$this->Ln(5);
	$this->SetFont('Arial','',8);
    $this->Cell(0,20,$_SESSION["address"]." | ".$_SESSION["contact"],0,0,'C');
	$this->Ln(20);
    $this->SetFont('Arial','B',12);
    $this->Cell(0,0,'Inventory Report',0,0,'C');
    // Line break
	$this->Ln(10);
	$this->SetFont('Arial','',9);
	$this->Cell(0,0,'Date: '.date('M d, Y'),0,0,'L');
	$this->Ln(3);
}
 
// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',3);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
 
$db = new dbObj();
$connString =  $db->getConnstring();
 
$result = mysqli_query($connString, "SELECT item_name, unit, unit_price, stock FROM items where company_id = '".$_SESSION["companyid"]."' order by stock desc") or die("database error:". mysqli_error($connString));
 
$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',9);

$pdf->Cell(80,10,'Item',1,0,'C');
$pdf->Cell(24,10,'Unit',1,0,'C');
$pdf->Cell(36,10,'Price',1,0,'C');
$pdf->Cell(48,10,'Stock',1,0,'C');

$pdf->SetFont('Arial','',9,'C');

foreach($result as $row) {
$pdf->Ln();
$pdf->Cell(80,7,$row['item_name'],'L',0,'C');
$pdf->Cell(24,7,$row['unit'],'L',0,'C');
$pdf->Cell(36,7,number_format($row['unit_price'],2),'L',0,'C');
$pdf->Cell(48,7,$row['stock'],'LR',0,'C');
}
$pdf->Ln(2);
$pdf->Cell(188,5,'   ','B',0,'C');
$pdf->Ln();

$pdf->Output();
?>