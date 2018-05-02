<html>
<head>
	<meta charset="utf-8">
	<title>Daniel Bank</title>
	<link rel="stylesheet" href="Style.css">
</head>
<body>
	<?php
		include 'Validation.php';
	?>
<img src="DanielIMG/DanielLogo.png">

<div id="RegisterPanel">
<p align=center>Rejestracja: </p>
	<form method="post" action="DanielRegisterStep2.php" >
	<table>
		<tr><td>Imię: </td><td><input name="Rname"><br></td></tr>
		<tr><td>Nazwisko: </td><td><input name="Rsurname"><br></td></tr>
		<tr><td>Data Urodzenia: </td><td><input type="date" name="Rbirthdate"><br></td></tr>
		<tr><td>Pesel: </td><td><input maxlength = "11" name="Rpesel"><br></td></tr>
		<tr><td>E-mail: </td><td><input type = "email" name="Rmail"><br></td></tr>
		<tr><td>Telefon: </td><td><input type="tel" maxlength="15" name="Rphone"><br></td></tr>		
	<table>
	<tr><td><input type="submit" value="Zarejestruj"></td></tr>
	</form>
</div>


</body>
</html>