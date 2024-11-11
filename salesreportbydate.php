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
	$datefrom = date_create($_GET["datefrom"]);
	$dateto = date_create($_GET["dateto"]);
	$this->SetFont('Arial','B',16);
    $this->Cell(0,20,$_SESSION["company"],0,0,'C');
	$this->Ln(5);
	$this->SetFont('Arial','',8);
    $this->Cell(0,20,$_SESSION["address"]." | ".$_SESSION["contact"],0,0,'C');
	$this->Ln(20);
    $this->SetFont('Arial','B',12);
    $this->Cell(0,0,'Sales Report',0,0,'C');
    // Line break
	$this->Ln(10);
	$this->SetFont('Arial','',9);
	$this->Cell(0,0,'Date Range: ',0,0,'L');
	$this->SetFont('Arial','B',9);
	$this->Cell(-318,0,date_format($datefrom,'M d, Y'),0,0,'C');
	$this->SetFont('Arial','',9);
	$this->Cell(346,0,'To ',0,0,'C');
	$this->SetFont('Arial','B',9);
	$this->Cell(-319,0,date_format($dateto,'M d, Y'),0,0,'C');
	$this->Cell(0,0,'Order by: Date',3,0,'R');
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
 
$result = mysqli_query($connString, "SELECT SUM(invoice.quantity * items.unit_price) as 'cost', DATE_FORMAT(invoice.date, '%M %e %Y') as 'date', COUNT(DISTINCT(invoice.si_no)) as 'noinday' FROM items,invoice where items.item_id = invoice.item_id and invoice.company_id = '".$_SESSION["companyid"]."' and invoice.date >= '".$_GET["datefrom"]."' and invoice.date <= '".$_GET["dateto"]."' and invoice.quantity != '0' group by invoice.date") or die("database error:". mysqli_error($connString));
 
$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',9);

$pdf->Cell(45,10,'Date',1,0,'C');
$pdf->Cell(43,10,'No. of Transaction',1,0,'C');
$pdf->Cell(100,10,'Total Sales',1,0,'C');

$pdf->SetFont('Arial','',9,'C');

$totalamount = 0;
$totalquantity = 0;

foreach($result as $row) {
$pdf->Ln();
$pdf->Cell(45,7,$row['date'],'L',0,'C');
$pdf->Cell(43,7,$row['noinday'],'L',0,'C');
$pdf->Cell(100,7,number_format($row['cost'],2),'LR',0,'C');
$totalamount = $totalamount + $row['cost'];
$totalquantity = $totalquantity + $row['noinday'];
}
$pdf->Ln(2);
$pdf->Cell(188,5,'   ','B',0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','B',9);

$pdf->Cell(45,10,'Total',1,0,'C');
$pdf->Cell(43,10,$totalquantity,1,0,'C');
$pdf->Cell(100,10,number_format($totalamount,2),1,0,'C');
$pdf->Output();
?>