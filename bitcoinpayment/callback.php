<?php 
$secret = "abc123";

$user = $_GET['user'];
$address = $_GET['address'];
$amount = $_GET['amount'];
$invoice = $_GET['invoice'];
$secret = $_GET['secret'];

if($secret != $secret){
	echo 'Error';
	return;
} 

$balance = json_decode(file_get_contents('https://blockchain.info/merchant/$ID/address_balance?password=$password&address=$address&confirmations=0'), true);
$parseBalance = $balance[balance];

if($amount != $parseBalance){
	echo 'Error';
	exit();
} else{
	$sql = "UPDATE users SET active='1' WHERE user='$user'";
	$query = mysqli_query($db_conx, $sql);
	echo '*ok*';
}
?>