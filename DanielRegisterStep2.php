<html>
<head>
	<meta charset="utf-8">
	<title>Daniel Bank</title>
	<link rel="stylesheet" href="Style.css">
</head>
<body>
<img src="DanielIMG/DanielLogo.png">

<?php
echo '<div id="RegisterPanel">';
include 'Scripts.php';

$RName = filtr($_POST['Rname']);
$RSurname = filtr($_POST['Rsurname']);
$RBirthDate = filtr($_POST['Rbirthdate']);
$RPesel = filtr($_POST['Rpesel']);
$RMail = filtr($_POST['Rmail']);
$RPhone = filtr($_POST['Rphone']);


if ((InsertToBase($RName, $RSurname, $RBirthDate, $RPesel, $RMail, $RPhone)) == TRUE)
{
	$login = LoginGenerator($RName,$RSurname,$RBirthDate);
	echo 'Twój login to:' .$login.'</br>';
	echo "Teraz wymyśl swoje hasło</br>";
	
	echo'
	<form method = "post" action = "DanielRegisterStep3.php">
	<input type="hidden" name="login" value='.$login.'>
	<input type="hidden" name="pesel" value='.$RPesel.'>
	<input type="password" name="password" minlength="10" maxlength="20">
	<input type="submit" value="Wyślij">
	';
}
else
	echo "Nie udało się zarejestrować. Spróbuj ponownie później, lub skontaktuj się z nami";


echo "</div>";
?>
</body>
</html>