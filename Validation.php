<?php
if(isset($_GET['validation']))
{
	if( $_GET['validation'] == "TNumber")
		echo '<script>alert("Niepoprawny numer konta")</script>';
	else if( $_GET['validation'] == "TsameNumber")
		echo '<script>alert("Nie możesz wykonać przelewu na to samo konto z którego wysyłasz")</script>';
	else if( $_GET['validation'] == "LPesel")
		echo '<script>alert("Taki użytkownik już istnieje")</script>';
	else if( $_GET['validation'] == "LDate")
		echo '<script>alert("Nie masz 18 lat!")</script>';
	else if( $_GET['validation'] == "LLogin")
		echo '<script>alert("Błędny login lub hasło")</script>';
}
?>
