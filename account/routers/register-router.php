<?php
include '../includes/connect.php';
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$phone = (int)$_POST['phone'];

function number($length) {
    $result = '';
    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }
    return $result;
}

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
		
		$cc_number = number(16);
		$cvv_number = number(3);
		$stmt = $con->prepare("INSERT INTO wallet_details(wallet_id, number, cvv) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $wallet_id, $cc_number, $cvv_number);
		$stmt->execute();
		$stmt->close();
	}
}
header("location: ../login.php");
?>