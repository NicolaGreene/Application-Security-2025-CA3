<?php
include '../includes/connect.php';

function number($length) {
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
}

$username = $_POST['username'];
//password is not hashed before being stored
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$name = $_POST['name'];
$email = $_POST['email'];
$contact = (int)$_POST['contact'];
$address = $_POST['address'];
$role = $_POST['role'];
$verified = (int)$_POST['verified'];
$deleted = (int)$_POST['deleted'];
$payment_method_token = isset($_POST['payment_method_token']) ? $_POST['payment_method_token'] : null;

$stmt = $con->prepare("INSERT INTO users (username, password, name, email, contact, address, role, verified, deleted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssississ", $username, $password, $contact, $name, $email, $address, $role, $verified, $deleted);
if($stmt->execute()){
	$user_id = $con->insert_id;
	$stmt->close();
	
	$stmt = $con->prepare("INSERT INTO wallet(customer_id) VALUES (?)");
	$stmt->bind_param("i", $user_id);
	if($stmt->execute()){
		$wallet_id = $con->insert_id;
		$stmt->close();
		
		$default_balance = 200;
		$stmt = $con->prepare("INSERT INTO wallet_details(wallet_id, balance, payment_method_token) VALUES (?, ?, ?)");
		$stmt->bind_param("iis", $wallet_id, $default_balance, $payment_method_token);
		$stmt->execute();
		$stmt->close();
	}	
}
header("location: ../users.php");
?>