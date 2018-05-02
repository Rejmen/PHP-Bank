<?php
include 'Scripts.php';
function ConnPDO($connection ='mysql:dbname=bankdaniel;host=localhost',$user='root',$pass='')
{
	try
	{
		$conn = new PDO($connection,$user,$pass);
	}
	catch(PDOException $e)	
	{
		echo "Połączenie nie udane ".$e->getMessage();
		exit;
	}
	
	return $conn;
}

function formatAccountNumber($accountNumber)
{
  $parts = array(0 => 2, 2 => 4, 6 => 4, 10 => 4, 14 => 4, 18 => 4, 22 => 4);
  $number=null;
  foreach ($parts as $key => $val)
  {
    $number .= substr($accountNumber, $key, $val).' ';
  }
  return trim($number);
}

function transfer($sender,$receiver,$money, $title)
{
	$BankConnection = ConnPDO();
	$select = $BankConnection -> prepare('SELECT * FROM accounts WHERE Number = :nr');
	$update = $BankConnection -> prepare('UPDATE accounts SET State=:newState WHERE Number=:nr');
	
	$select -> bindParam(':nr',$number);
	$update -> bindParam(':nr',$number);
	$update -> bindParam(':newState',$newState);
	
	$BankConnection -> beginTransaction();
	
	try
	{		
		$number = $sender;
		$select -> execute();
		$sState2 = $select -> fetch(PDO::FETCH_ASSOC);
		$newState = $sState2['State'] - $money;
		$update -> execute();
		$number = $receiver;
		$select -> execute();
		$rState2 = $select -> fetch(PDO::FETCH_ASSOC);
		$newState = $rState2['State'] + $money;
		$update -> execute();
		
		toHistory($sender,$receiver,$money,$title);
		
		$BankConnection -> commit();
	}
	
	catch(Exception $e)
	{
		echo $e -> getMessage();
		$BankConnection -> rollback();
	}
	
	
}

function refreshAccountState($account)
{
	$BankConnection = ConnPDO();
	$select = $BankConnection -> prepare('SELECT * FROM accounts WHERE Number ='.$account);
	$select -> execute();
	$newState = $select -> fetch(PDO::FETCH_ASSOC);
	return $newState['State'];
}

function refreshCard($id)
{
	$BankConnection = ConnPDO();
	$select = $BankConnection -> prepare('SELECT * FROM card WHERE ID_User ='.$id);
	$select -> execute();
	$newCard = $select -> fetch(PDO::FETCH_ASSOC);
	return $newCard;
}

function deleteCard($id)
{
	$BankConnection = ConnPDO();
	$delete = $BankConnection -> prepare('DELETE FROM card WHERE ID_User ='.$id);
	$delete -> execute();
}

function toHistory($sender,$receiver,$money,$title)
{
	$BankConnection = ConnPDO();
	$insert = $BankConnection -> prepare("INSERT INTO history(Sender,Money,Receiver,Name,Title,Date) VALUES(:sender,:money,:receiver,:name,:title,:date)");
	$select = $BankConnection -> prepare("SELECT * FROM accounts WHERE Number=".$receiver);
	$insert -> bindValue(':sender',$sender);
	$insert -> bindValue(':money',$money);	
	$insert -> bindValue(':receiver',$receiver);
	$insert -> bindParam(':name',$name);
	$insert -> bindValue(':title',$title);
	$d = date('Y-m-d G:i:s');
	$insert -> bindValue(':date',$d);
	
	$select -> execute();
	
	$name0 = $select -> fetch(PDO::FETCH_ASSOC);
	$name1 = findClient($name0['ID_User']);
	$name = $name1['Name']." ".$name1['Surname'];
	
	
	try{ $insert -> execute(); }
	catch(Exception $e) { echo $e -> getMessage(); }

}

function addCard($id,$type)
{
	$BankConnection = ConnPDO();
	$insert = $BankConnection -> prepare("INSERT INTO card(ID_User,Number,Type) VALUES(:id,:nr,:type)");
	
	$nr = GenerateCardNumber();
	$insert -> bindValue(':id',$id);
	$insert -> bindValue(':nr',$nr);
	$insert -> bindValue(':type',$type);
	
	
	
	try{ $insert -> execute(); }
	catch(Exception $e) { echo $e -> getMessage(); }
}

function GenerateCardNumber()
{
	$BankConnection2 = Connbankdaniel();	
	
	$a = rand(10000000,99999999);
	$b = rand(10000000,99999999);
	
	$card = $a.$b;
	$cardNumber =  (string)$card;
	
	$sql = "SELECT * FROM card WHERE Number = '$cardNumber'";
	$find = ExecuteSQL($BankConnection2,$sql);
	$findtab = $find -> fetch_assoc();
	$BankConnection2 -> Close();
	
	if(count($findtab) == 0)
		return $cardNumber;
	else
		GenerateCardNumber();
}	

function findCardIMG($cardType)
{
		if($cardType == 1)
			$cardIMG = "DanielIMG/VisaElectron.png";
		else if($cardType == 2)
			$cardIMG = "DanielIMG/VisaClassic.png";
		else if($cardType == 3)
			$cardIMG = "DanielIMG/VisaGold.png";
		
		return $cardIMG;
}

function addFriend($user,$name,$nr)
{
	$BankConnection = ConnPDO();
	$insert = $BankConnection -> prepare("INSERT INTO friends(ID_User,Name,Number) VALUES(:id,:name,:nr)");
	
	$insert -> bindValue(':id',$user);
	$insert -> bindValue(':name',$name);
	$insert -> bindValue(':nr',$nr);
	
	try{ $insert -> execute(); }
	catch(Exception $e) { echo $e -> getMessage(); }
}

function delFriend($nr)
{
	$BankConnection = ConnPDO();
	$delete = $BankConnection -> prepare('DELETE FROM friends WHERE Number ='.$nr);
	$delete -> execute();	
}

function showFriend($nr)
{
	$BankConnection = ConnPDO();
	$select = $BankConnection -> prepare("SELECT * FROM friends WHERE ID_User=".findID($nr));
	$select -> execute();
	return $select;
}

function findID($nr)
{
	$BankConnection = ConnPDO();
	$select = $BankConnection -> prepare("SELECT * FROM accounts WHERE Number=".$nr);
	
	$select -> execute();
	
	$a = $select -> fetch(PDO::FETCH_ASSOC);
	
	try{ $select -> execute(); }
	catch(Exception $e) { echo $e -> getMessage(); }
	
	
	return $a['ID_User'];
}

//DODAJ TRY

?>