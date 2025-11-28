<?php
include '../includes/connect.php';
include '../includes/wallet.php';
$message = $_POST['message'];
$ticket_id = (int)$_POST['ticket_id'];
$role = $_POST['role'];

if($role == 'Administrator'){
	$status = 'Answered';
	$stmt = $con->prepare("UPDATE tickets SET status = ? WHERE id = ?");
	$stmt->bind_param("si", $status, $ticket_id);
	$stmt->execute();
	$stmt->close();
}
else{
	$status = 'Open';
	$stmt = $con->prepare("UPDATE tickets SET status = ? WHERE id = ?");
	$stmt->bind_param("si", $status, $ticket_id);
	$stmt->execute();
	$stmt->close();
}

if($message != ''){
	$stmt = $con->prepare("INSERT INTO ticket_details (ticket_id, user_id, description) VALUES (?, ?, ?)");
	$stmt->bind_param("iis", $ticket_id, $user_id, $message);
	$stmt->execute();
	$stmt->close();
}
header("location: ../view-ticket.php?id=".urlencode($ticket_id));
?>