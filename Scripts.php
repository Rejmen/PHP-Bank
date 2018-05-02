<?php
function filtr($toFiltr)
{
	$BankConnection = Connbankdaniel();	
	if(get_magic_quotes_gpc())
        $toFiltr = stripslashes($toFiltr);
 
   
    return mysqli_real_escape_string($BankConnection,htmlspecialchars(trim($toFiltr)));
	$BankConnection -> close();
}

function Connbankdaniel($host='localhost',$user='root',$pass='',$dbname='bankdaniel')
{
	$conn = new mysqli($host,$user,$pass,$dbname);
	$r;
	if(mysqli_connect_errno() != 0)
	{
			echo "Błąd połączenia z bazą danych!";
			$r = FALSE;
	}
	
	else
		$r = $conn;
	
	return $conn;
}

function ExecuteSQL($conn,$sql)
{
	$result = $conn -> query($sql);
	if($result==FALSE)
	{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	return $result;
}

function InsertToBase($RName, $RSurname, $RBirthDate, $RPesel, $RMail, $RPhone)
{
	$BankConnection = Connbankdaniel();
	$r = TRUE;
	if($BankConnection == FALSE)
		exit;
	
	$select = "SELECT * FROM user WHERE Pesel =".$RPesel;
	$result = ExecuteSQL($BankConnection,$select);
	$checkDate = substr($RBirthDate,0,4);
	
		
	if( (count($result -> fetch_assoc()) != 0) || ($checkDate > Date('Y') - 18) )
			header('Location: DanielRegister.php?validation=LDate');
	
	$insertSQL = "INSERT INTO user(Name,Surname,BirthDate,Pesel,Email,Phone) VALUES ('$RName','$RSurname','$RBirthDate','$RPesel','$RMail','$RPhone')";
	
	if((ExecuteSQL($BankConnection,$insertSQL))=== FALSE)
		$r = FALSE;
	
	$BankConnection -> close();
	return $r;
}

function LoginGenerator($RName,$RSurname, $RBirthDate)
{
	$A = substr($RName,0,3);
	$B = substr($RSurname,0,3);
	$C = substr($RBirthDate,2,2);
	return $A.$B.$C;	
}

function RegisterUser($pesel,$login,$password)
{
	$BankConnection = Connbankdaniel();	
	$r = TRUE;
	$ID_User = FindUSERID($pesel);
	if($ID_User == FALSE)
		exit("Błąd w wyszukiwaniu użytkownika w bazie");
	
	$insertSQL = "INSERT INTO login(ID_User,Login,Password) VALUES ('$ID_User','$login','$password')";
	if((ExecuteSQL($BankConnection,$insertSQL))===FALSE)
		$r = FALSE;
	
	$BankConnection -> close();
	CreateAccount($ID_User);
	return $r;
}

function CreateAccount($ID_User, $state=1500)
{
	$r = TRUE;
	$BankConnection = Connbankdaniel();	
	$number = GenerateAccountNumber();
	$sql = "INSERT INTO accounts(ID_User,Number,State) VALUES ('$ID_User','$number','$state')";
	$esql = ExecuteSQL($BankConnection,$sql);
	if($esql == FALSE)
		$r = FALSE;
	
	return $r;	
}



function LoginUser($login,$password)
{
	$BankConnection = Connbankdaniel();	
	$loginSQL = "SELECT * FROM login WHERE Login = '$login' AND Password = '$password'";
	$finduser = ExecuteSQL($BankConnection,$loginSQL); 


		
	$finduser2 = $finduser -> fetch_assoc();
	
		if( $finduser2 == null)
		{
			header('Location: DanielLogin.php?validation=LLogin');
		}
		
	$ID = $finduser2['ID_User'];
	$user = findClient($ID);
	$account = findAccount($ID);
	$card = findCard($ID);
	
	$BankConnection -> Close();
	return Array($user,$account,$card);
}

function findAccount($ID)
{
	$BankConnection2 = Connbankdaniel();
	$findSQL = "SELECT * FROM accounts WHERE ID_User=".$ID;
	$a = ExecuteSQL($BankConnection2,$findSQL);
	$account = $a -> fetch_assoc();
	
	$BankConnection2 -> Close();
	return $account;
}

function findClient($ID)
{
	$BankConnection2 = Connbankdaniel();
	$findSQL = "SELECT * FROM user WHERE ID_User=".$ID;
	$user = ExecuteSQL($BankConnection2,$findSQL);
	if($user == false)
		exit();
	$client = $user -> fetch_assoc();
	
	$BankConnection2 -> Close();
	return $client;
}

function findCard($ID)
{
	$BankConnection2 = Connbankdaniel();
	$findSQL = "SELECT * FROM card WHERE ID_User=".$ID;
	$c = ExecuteSQL($BankConnection2,$findSQL);
	$card = $c -> fetch_assoc();
	$BankConnection2 -> Close();
	return $card;
}


function FindUSERID($pesel)
{
	$BankConnection2 = Connbankdaniel();	

	$findSQL = "SELECT * FROM user WHERE Pesel=".$pesel;
	$findID = ExecuteSQL($BankConnection2,$findSQL);
	$ID = $findID -> fetch_assoc();

	$BankConnection2 -> close();	
	return $ID['ID_User'];
}

function GenerateAccountNumber()
{
	$BankConnection2 = Connbankdaniel();	
	
	$a = rand(10,99);
	$b = rand(10000000,99999999);
	$c = rand(10000000,99999999);
	$d = rand(10000000,99999999);
	$accountNumber = $a.$b.$c.$d;
	$acc =  (string)$accountNumber;
	
	$sql = "SELECT * FROM accounts WHERE Number = 'acc'";
	$find = ExecuteSQL($BankConnection2,$sql);
	$findtab = $find -> fetch_assoc();
	$BankConnection2 -> Close();


	if(count($findtab) == 0)
		return $accountNumber;
	else
		GenerateAccountNumber();
}	

	
	
?>