<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Daniel Bank</title>
	<link rel="stylesheet" href="Style.css">
	
	<?php
		include 'PanelScripts.php';
		
		session_start();
		if (!isset($_SESSION['login']))
			header('Location: index.html');
		if(isset($_GET['Ses']))
		{
			session_destroy();
			header('Location: index.html');
		}

		$User = $_SESSION['userData'];
		$Account = $_SESSION['accountData'];
		$Card = $_SESSION['cardData'];
		
		$cardType = refreshCard($User['ID_User']);
		$Account['State'] = refreshAccountState($Account['Number']);
		
		if(isset($_GET['validation']))
			include 'Validation.php';
		
	?>
	
</head>
<body>


<img id= "Logo" height = 150px src="DanielIMG/DanielLogo.png">

<div class="tile" id="Header">
	<?php 
	transfer('47849471961436606724019332','85188203894481348320238938',1500,'Przelew Daniel');
	transfer('47849471961436606724019332','87972358469656662248491237',15000,'Przelew Anna');
		echo "Witaj <b>".$User['Name']."</b>
			</br>Dzisiaj mamy: <b>".date('Y-m-d')."</b>
			</br>Miłego dnia!";
	?>
	</br><a href= "DanielIndex.php?Ses=destroy"><button>Wyloguj</button></a>
</div>

<div id="MainTile">
	<p class="title">KONTO</p>
	
	<div id="AccountTile1">	
		Numer konta:
		<b></br><p id="Content"> <?php echo formatAccountNumber($Account['Number']); ?> </p></b>
	</div>
	
	<div id="AccountTile2">		
		Stan konta:
		<b></br><p id="Content"> <?php echo $Account['State']." zł" ?> </p></b>
	</div>
	
	<div id="AccountTile3">	
		<form method="post" action="DanielHistory.php">
			<input type="hidden" name = "historyaccount" value="<?php echo $Account['Number'] ?>">
			<input type="submit" value="Historia">
		</form>
	</div>
</div>



<div id="MainTile">
	<p class="title">PRZELEW</p>
	
	<div id="TransferTile1">
		<form id= "TransferForm" method="post" action="DanielIndexPrzelew.php">
			<table>
				<tr><td>Odbiorca: </td><td><input name="TName"></td></tr>
				<tr><td>Numer konta: </td><td><input type = "number" maxlength="26" name="TNumber"></td></tr>
				<tr><td>Tytuł: </td><td><input name="TTitle"></td></tr>
				<tr><td>Kwota: </td><td><input type = "number" name="TMoney"></td></tr>
			</table>
		</form>
	</div>
	
	<div id="TransferTile2">
		<input type="submit" form="TransferForm" value="Wykonaj przelew">
		</br><input type="submit" form="TransferForm" formaction = "DanielTransfer.php"  formtarget="_blank" value="Generuj druk przelewu">
	</div>	
</div>

<div id="MainTile">
	<p class = "title"> ZNAJOMI ODBIORCY </p>
	<table class = "title" id="FriendTable">
	

	
	<?php
		$friend = showFriend($Account['Number']);
		while ($result = $friend -> fetch(PDO::FETCH_ASSOC)) 
		{
			echo "<tr id=\"FriendTR\"><td>".$result['Name']."</td><td>".$result['Number']."</td>
			<td> 
			
			<a href= \"DanielFriendDel.php?Nr=".$result['Number']."\"><button>Usuń</button></a>

			
			</td></tr>";
		}
	?>
	</table>
	
	<div id="FriendTile">
		<form id = "FriendForm" method="post" action="DanielIndexFriends.php">
		<table>
			<tr><td>Nazwa: </td><td><input name="FName"></td></tr>
			<tr><td>Konto: </td><td><input name="FAccount"></td></tr>
			<input type="hidden" name="FUser" value=<?php echo $User['ID_User'] ?> >
		</table>
		</form>
	</div>
	
	<div id = "FriendTile"> <input type="submit" form="FriendForm" value="Dodaj znajomego"> </div>
	</div>
	

<div id="MainTile">
<p class="title">KARTY</p>
<?php
if($cardType['Type'] != null)
{
	$cardIMG = findCardIMG($cardType['Type']);
	echo '
	<div id="CardTile">
		<img width="500px" height="300px" src='.$cardIMG.'>	
	</div>';
	echo '
	<div id="CardTile">
		Numer karty <p id="Content">'.$cardType['Number'].'</p></br>
		<form method="post" action="DanielDelCard.php">
			<input type="hidden" name="id" value='.$User['ID_User'].'>
			<input type="submit" value="Usuń kartę">
		</form>
	</div>';
}

else	
{
	echo '<div id="CardTile"> Nie posiadasz żadnej karty płatniczej</div>';
	echo '
		<div id="CardTile">
		<form method="post" action="DanielCard.php">
			<select name="type">
				<option value="1"> Electron </option>
				<option value="2"> Classic </option>
				<option value="3"> Gold </option>
			</select>
			</br>				
			<input type="hidden" name="id" value = '.$User["ID_User"].'>
			<input type="submit" value = "Dodaj karte">
		</form>
		</div>
	';
}
?>


</div>


</body>
</html>