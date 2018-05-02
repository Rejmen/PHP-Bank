<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Daniel Bank</title>
	<link rel="stylesheet" href="Style.css">
</head>
<body>
<div id="LoginPanel">
<?php
session_start();
if (!isset($_SESSION['login']))
	header('Location: index.html');

if(strlen($_POST['FAccount']) != 26)
{
	header('Location: DanielIndex.php?validation=TNumber');
}

include 'PanelScripts.php';
	addFriend($_POST['FUser'],$_POST['FName'],$_POST['FAccount']);

	header('Location: DanielIndex.php');
?>

	
</div>



</body>
</html>