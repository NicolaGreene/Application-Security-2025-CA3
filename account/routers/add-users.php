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
$password = $_POST['password'];
$name = $_POST['name'];
$email = $_POST['email'];
$contact = (int)$_POST['contact'];
$address = $_POST['address'];
$role = $_POST['role'];
$verified = (int)$_POST['verified'];
$deleted = (int)$_POST['deleted'];

$stmt = $con->prepare("INSERT INTO users (username, password, name, email, contact, address, role, verified, deleted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssisisiis", $username, $password, $contact, $name, $email, $address, $role, $verified, $deleted);
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
header("location: ../users.php");
?>