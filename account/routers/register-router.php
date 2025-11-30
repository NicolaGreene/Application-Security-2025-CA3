<?php
include '../includes/connect.php';
$name = $_POST['name'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$phone = (int)$_POST['phone'];
// NEW: expect payment method token from Stripe (frontend collected card, sent token)
$payment_method_token = isset($_POST['payment_method_token']) ? $_POST['payment_method_token'] : null;

$stmt = $con->prepare("INSERT INTO users (name, username, password, contact) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $name, $username, $password, $phone);
if($stmt->execute()){
	$user_id = $con->insert_id;
	$stmt->close();
	
	$stmt = $con->prepare("INSERT INTO wallet(customer_id) VALUES (?)");
	$stmt->bind_param("i", $user_id);
	if($stmt->execute()){
		$wallet_id = $con->insert_id;
		$stmt->close();
		
		//tokenised credit card storage with default balance of 200
		$default_balance = 2000;
		$stmt = $con->prepare("INSERT INTO wallet_details(wallet_id, balance, payment_method_token) VALUES (?, ?, ?)");
		$stmt->bind_param("iis", $wallet_id, $default_balance, $payment_method_token);
		$stmt->execute();
		$stmt->close();
	}
}
header("location: ../login.php");
?>