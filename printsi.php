<?php
session_start();
//include connection file 
include_once('fpdf183/fpdf.php');

Class dbObj{
/* Database connection start */
var $dbhost = "localhost";
var $username = "root";
var $password = "";
var $dbname = "on_point";
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
	$this->Ln(3);
    $this->SetFont('Arial','B',12);
    $this->Cell(0,50,'Inventory',0,0,'C');
    // Line break
    $this->Ln(30);
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
$display_heading = array('item_name'=> 'Item Name', 'unit'=> 'Unit','unit_price'=> 'Price', 'stock'=> 'Stock');
 
$result = mysqli_query($connString, "SELECT item_name, unit, unit_price, stock FROM items where company_id = '".$_SESSION["companyid"]."' order by item_name asc") or die("database error:". mysqli_error($connString));
 
$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',9);

$pdf->Cell(80,10,'Name',1,0,'C');
$pdf->Cell(24,10,'Unit',1,0,'C');
$pdf->Cell(36,10,'Price',1,0,'C');
$pdf->Cell(48,10,'Stock',1,0,'C');

$pdf->SetFont('Arial','',9);

foreach($result as $row) {
$pdf->Ln();
$pdf->Cell(80,10,$row['item_name'],'L',0,'C');
$pdf->Cell(24,10,$row['unit'],'L',0,'C');
$pdf->Cell(36,10,$row['unit_price'],'L',0,'C');
$pdf->Cell(48,10,$row['stock'],'LR',0,'C');

}
$pdf->Ln(2);
$pdf->Cell(190,10,'   ','B',0,'C');
$pdf->Output();
?>