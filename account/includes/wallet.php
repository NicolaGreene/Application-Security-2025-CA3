<?php
$user_id=$_SESSION['user_id'];
$stmt = $con->prepare("SELECT * FROM wallet WHERE customer_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$row1 = $res->fetch_assoc();
$wallet_id = $row1['id'];
$stmt->close();

$stmt = $con->prepare("SELECT * FROM wallet_details WHERE wallet_id = ?");
$stmt->bind_param("i", $wallet_id);
$stmt->execute();
$res = $stmt->get_result();
$row1 = $res->fetch_assoc();
$balance = $row1['balance'];
$stmt->close();
?>