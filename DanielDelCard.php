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

include 'PanelScripts.php';
echo $_POST['id'];
	deleteCard($_POST['id']);
	
	header('Location: DanielIndex.php');
?>

	
</div>



</body>
</html>