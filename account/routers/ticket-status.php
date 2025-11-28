<?php
include '../includes/connect.php';
include '../includes/wallet.php';

$status = isset($_POST['status']) ? $_POST['status'] : '';
$ticket_id = isset($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : 0;

if ($ticket_id > 0) {
    $stmt = $con->prepare("UPDATE tickets SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $ticket_id);
    $stmt->execute();
    $stmt->close();
}

header("location: ../view-ticket.php?id=".urlencode($ticket_id));
exit;
?>