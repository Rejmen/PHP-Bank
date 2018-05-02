<html>
<head>
	<meta charset="utf-8">
	<title>Daniel Bank</title>
	<link rel="stylesheet" href="Style.css">
	<?php include 'Validation.php'; ?>
</head>
<body>
<img src="DanielIMG/DanielLogo.png">


<div id="LoginPanel">
<p align=center>Zaloguj: </p>
	<form method="post" action="DanielLoginStep2.php">
	<table>
		<tr><td>Login: </td><td><input name="login" minlength="8"></td></tr>
		<tr><td>Hasło: </td><td><input type="password" name="password" minlength="10" maxlength="20"></td></tr>
	</table>
		<input type="submit" value="Zaloguj">
	</form>
</div>



</body>
</html>