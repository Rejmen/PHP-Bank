<html>
<head>
	<meta charset="utf-8">
	<title>Daniel Bank</title>
	<link rel="stylesheet" href="Style.css">
</head>
<body>
<img src="DanielIMG/DanielLogo.png">

<?php
include 'Scripts.php';

$login = filtr($_POST['login']);
$password = md5(filtr($_POST['password']));
$pesel = filtr($_POST['pesel']);

RegisterUser($pesel,$login,$password);
header('Location: index.html');
?>
</body>
</html>