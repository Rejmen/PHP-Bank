<?php
error_reporting(E_ERROR); // - Tylko BŁĘDY
include ('fpdf/fpdf.php');
include('PanelScripts.php');

	$BankConnection = ConnPDO();
	$select = $BankConnection -> prepare('SELECT * FROM history WHERE Sender ='.$_POST['historyaccount']);
	$select -> execute();
	
	

$pdf = new FPDF();

$pdf -> AddPage();
$pdf -> SetFont('Arial');
$pdf -> SetFontSize(10);
$pdf -> SetFillColor(191, 191, 191);
$pdf -> Image('DanielIMG/DanielLogo.png');
$pdf -> Cell(20,10,'Data wydruku: '.Date('Y-m-d'),0,1);
$pdf -> SetFontSize(7);

$pdf -> Cell(45,10, 'Od',1,0,'L',true);
$pdf -> Cell(45,10, 'Do',1,0,'L',true);
$pdf -> Cell(25,10, 'Odbiorca',1,0,'L',true);
$pdf -> Cell(10,10, 'Kwota',1,0,'L',true);
$pdf -> Cell(35,10, 'Tytulem',1,0,'L',true);
$pdf -> Cell(15,10, 'Data',1,0,'L',true);
$pdf -> Cell(15,10, 'Godzina',1,1,'L',true);

$pdf -> SetFillColor(230, 230, 230);

$i=0;
$x = false;
while(($rekord = $select -> fetch(PDO::FETCH_ASSOC)) != null)
{
	if( $i % 2 == 0)
		$x = false;
	
	else
		$x = true;
	
	$pdf -> Cell(45,10, $rekord['Sender'],1,0,'L',$x);
	$pdf -> Cell(45,10, $rekord['Receiver'],1,0,'L',$x);
	$pdf -> Cell(25,10, $rekord['Name'],1,0,'L',$x);
	$pdf -> Cell(10,10, $rekord['Money'],1,0,'L',$x);
	$pdf -> Cell(35,10, $rekord['Title'],1,0,'L',$x);
	$pdf -> Cell(15,10, substr($rekord['Date'],0,10),1,0,'L',$x);
	$pdf -> Cell(15,10, substr($rekord['Date'],11),1,1,'L',$x);
	
	$i++;
}
$pdf -> Output(); 

?>