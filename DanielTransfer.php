<?php

session_start();
if (!isset($_SESSION['login']))
	header('Location: DanielIndex.php');

if(strlen($_POST['TNumber']) != 26)
{
	header('Location: DanielIndex.php?validation=TNumber');
}

$User = $_SESSION['userData'];
$Account = $_SESSION['accountData'];

error_reporting(E_ERROR); // - Tylko BŁĘDY
include ('fpdf/fpdf.php');
include ('PanelScripts.php');

$pdf = new FPDF();

function stringToPDF($pdf, $x1,$y1,$a, $txt)
{
	for($i = 0; $i < strlen($txt);$i++)
	{
		$pdf -> Text($x1,$y1,$txt[$i]);
		$x1 += $a;
	}
}

$pdf -> AddPage();
$pdf -> SetFont('Arial');
$pdf -> SetFontSize(15);

$pdf -> Image('DanielIMG/Transfer.gif');
$pdf -> Cell(20,10,'Data wydruku: '.Date('Y-m-d'),0,1);

$name1 = $User['Name']." ".$User['Surname'];
$nr1 = $_POST['TNumber'];
$money = (string)$_POST['TMoney'];
$name2 = $_POST['TName'];
$title = $_POST['TTitle'];


$x = 24;
stringToPDF($pdf,$x,18,5,$name1);
stringToPDF($pdf,$x,36,5,$nr1);
stringToPDF($pdf,100,44,5,$money);
stringToPDF($pdf,$x,60,5,$name2);
stringToPDF($pdf,$x,76,5,$title);

$pdf -> Output(); 





















?>