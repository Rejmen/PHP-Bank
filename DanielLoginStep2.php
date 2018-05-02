<?php
include 'Scripts.php';
$login = filtr($_POST['login']);
$password = md5(filtr($_POST['password']));
$logginning = LoginUser($login, $password);
$loggedUser = $logginning[0];
$account = $logginning[1];
$card = $logginning[2];

session_start();
$_SESSION['login'] = $login;
$_SESSION['userData'] = $loggedUser;
$_SESSION['accountData'] = $account;
$_SESSION['cardData'] = $card;
?>
