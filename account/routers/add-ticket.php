<?php
include '../includes/connect.php';
$subject = $_POST['subject'];
$description = $_POST['description'];
$type = $_POST['type'];
$user_id = (int)$_POST['id'];

if($type != ''){
	$stmt = $con->prepare("INSERT INTO tickets (poster_id, subject, description, type) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("isss", $user_id, $subject, $description, $type);
	if ($stmt->execute()){
		$ticket_id = $con->insert_id;
		$stmt->close();
		
		$stmt = $con->prepare("INSERT INTO ticket_details (ticket_id, user_id, description) VALUES (?, ?, ?)");
		$stmt->bind_param("iis", $ticket_id, $user_id, $description);
		$stmt->execute();
		$stmt->close();
	}
}
header("location: ../tickets.php");
?>