<?php
include '../includes/connect.php';
$status = $_POST['status'];
$id = (int)$_POST['id'];

$stmt = $con->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();
$stmt->close();

header("location: ../all-orders.php");
?>