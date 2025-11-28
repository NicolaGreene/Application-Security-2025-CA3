<?php
include '../includes/connect.php';
$user_id = $_SESSION['user_id'];

$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$phone = (int)$_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];

$stmt = $con->prepare("UPDATE users SET name = ?, username = ?, password = ?, contact = ?, email = ?, address = ? WHERE id = ?");
$stmt->bind_param("sssissi", $name, $username, $password, $phone, $email, $address, $user_id);
if($stmt->execute()){
	$_SESSION['name'] = $name;
}
$stmt->close();
header("location: ../details.php");
?>