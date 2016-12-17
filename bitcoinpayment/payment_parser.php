<?php 

$transaction = $_POST['transaction'];
$amount = $_POST['amount'];
$btcAmount = '0.002';
$btc_address = $_POST['BTC_address'];

$label = 'Store order'; 
$note = 'Transaction #'. $transaction;

$href = 'bitcoin:'. $btc_address .'?amount='. $btcAmount .'&message='. $note .'&label='. $label;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PAY WITH BITCOIN</title>
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<div id="mainContent">
		<span id="transactionID">Transaction: <?php echo $transaction; ?></span> 
		<span id="btcAmount"><?php echo $amount; ?> BTC</span> 
		
		<a id="payButton" href="<?php echo $href; ?>"><img src="images/pay_with_bitcoin.png" alt="pay with bitcoin"></a>
		<img id="qrCode" src="qrcode.php?text=http://<?php echo $href; ?>&size=250&padding=10" alt="QR Code">
		<span id="btcAdress"><?php echo $btc_address; ?></span> 
	</div>
</body>
</html>