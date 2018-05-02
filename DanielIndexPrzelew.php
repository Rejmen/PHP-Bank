<?php
session_start();
if (!isset($_SESSION['login']))
	header('Location: index.html');

$TNumber = $_POST['TNumber'];
if(strlen($TNumber) != 26)
{
	header('Location: DanielIndex.php?validation=TNumber');
}

$User = $_SESSION['userData'];
$Account = $_SESSION['accountData'];
$Card = $_SESSION['cardData'];

if($Account['Number'] == $TNumber)
{
	header('Location: DanielIndex.php?validation=TsameNumber');
}

else
{
include 'PanelScripts.php';

	transfer($Account['Number'],$TNumber,$_POST['TMoney'],$_POST['TTitle']);
	header('Location: DanielIndex.php');
}
	
?>
