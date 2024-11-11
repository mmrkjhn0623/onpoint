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
	$db = new dbObj();
	$connString =  $db->getConnstring();
 
	$result = mysqli_query($connString, "SELECT si_no, DATE_FORMAT(date, '%M %e %Y') as 'date' FROM invoice WHERE si_no = '".$_GET["si"]."' and company_id = '".$_SESSION["companyid"]."' limit 1") or die("database error:". mysqli_error($connString));
 
	$this->SetFont('Arial','B',16);
    $this->Cell(0,20,$_SESSION["company"],0,0,'C');
	$this->Ln(5);
	$this->SetFont('Arial','',8);
    $this->Cell(0,20,$_SESSION["address"]." | ".$_SESSION["contact"],0,0,'C');
	$this->Ln(20);
    $this->SetFont('Arial','B',12);
    $this->Cell(0,0,'Sale Invoice',0,0,'C');
    // Line break
	$this->Ln(10);
	$this->SetFont('Arial','',9);
	foreach($result as $row) {
		$this->Cell(0,0,'Date: '.$row['date'],0,0,'L');
		$this->Cell(0,0,'Invoice No: '.$row['si_no'],0,0,'R');
	
	}
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
 
$result = mysqli_query($connString, "SELECT invoice.si_no as 'sino', items.item_name as 'itemname', invoice.sold_price as 'price', invoice.quantity as 'quantity', invoice.date as 'date' FROM invoice, items WHERE invoice.item_id = items.item_id and invoice.si_no = '".$_GET["si"]."' and invoice.company_id = '".$_SESSION["companyid"]."' and invoice.quantity != 0 order by items.item_name asc") or die("database error:". mysqli_error($connString));
if (mysqli_num_rows($result)==0){
	$_SESSION["alert"] = "nosi";
	header("Location: returnsale.php");
}
	

 
$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',9);

$pdf->Cell(24,10,'Quantity',1,0,'C');
$pdf->Cell(80,10,'Item',1,0,'C');
$pdf->Cell(36,10,'Unit Price',1,0,'C');
$pdf->Cell(48,10,'Cost',1,0,'C');

$pdf->SetFont('Arial','',9,'C');

$totalamount = 0;
foreach($result as $row) {
$amount = $row['price'] * $row['quantity'];
$pdf->Ln();
$pdf->Cell(24,7,$row['quantity'],'L',0,'C');
$pdf->Cell(80,7,$row['itemname'],'L',0,'C');
$pdf->Cell(36,7,number_format($row['price'],2),'L',0,'C');
$pdf->Cell(48,7,number_format($amount,2),'LR',0,'C');
$totalamount = $totalamount + $amount;
}
$vatamount = $totalamount * 0.12;
$pdf->Ln(2);
$pdf->Cell(188,5,'   ','B',0,'C');
$pdf->Ln();
$pdf->Cell(24,7,'',0,'C');
$pdf->Cell(80,7,'',0,'C');
$pdf->Cell(36,7,'',0,0,'C');
$pdf->Cell(48,7,'',0,0,'C');

$pdf->Ln();
$pdf->Cell(24,7,'',0,0,'C');
$pdf->Cell(80,7,'',0,0,'C');
$pdf->Cell(36,7,'VATable Sale',1,0,'C');
$pdf->Cell(48,7,number_format($totalamount-$vatamount,2),1,0,'C');
$pdf->Ln();
$pdf->Cell(24,7,'',0,0,'C');
$pdf->SetFont('Arial','U',9,'C');
$pdf->Cell(80,7,'                                                 ',0,0,'C');
$pdf->SetFont('Arial','',9,'C');
$pdf->Cell(36,7,'12% VAT',1,0,'C');
$pdf->Cell(48,7,number_format($vatamount,2),1,0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Ln();
$pdf->Cell(24,7,'',0,0,'C');
$pdf->Cell(80,2,'Customer',0,0,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(36,7,'Total Due',1,0,'C');
$pdf->Cell(48,7,number_format($totalamount,2),1,0,'C');
$pdf->Ln();

$pdf->Output();

?>