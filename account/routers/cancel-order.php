<?php
include '../includes/connect.php';
include '../includes/wallet.php';

$status = isset($_POST['status']) ? $_POST['status'] : '';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id > 0) {
    $stmt = $con->prepare("UPDATE orders SET status = ?, deleted = 1 WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();

    $total = 0;
    $stmt2 = $con->prepare("SELECT total FROM orders WHERE id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $res = $stmt2->get_result();
    if ($row1 = $res->fetch_assoc()) {
        $total = (int)$row1['total'];
    }
    $stmt2->close();

    if (isset($_POST['payment_type']) && $_POST['payment_type'] === 'Wallet' && isset($wallet_id) && isset($balance)) {
        $newBalance = (int)$balance + $total;
        $stmt3 = $con->prepare("UPDATE wallet_details SET balance = ? WHERE wallet_id = ?");
        $stmt3->bind_param("ii", $newBalance, $wallet_id);
        $stmt3->execute();
        $stmt3->close();
    }
}

header("location: ../orders.php");
exit;
?>