<?php
session_start();
if (!isset($_SESSION['login']))
	header('Location: DanielIndex.php');



$User = $_SESSION['userData'];
$Account = $_SESSION['accountData'];
$Card = $_SESSION['cardData'];



?>