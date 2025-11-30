<?php
include '../includes/connect.php';
include '../includes/wallet.php';
$total = 0;
$address = $_POST['address'];
$description = $_POST['description'] ?? '';
$payment_type = $_POST['payment_type'];
$total = (int)($_POST['total'] ?? 0);

$stmt = $con->prepare("INSERT INTO orders (customer_id, payment_type, address, total, description) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isssi", $user_id, $payment_type, $address, $total, $description);
if ($stmt->execute()){
	$order_id = $con->insert_id;
	$stmt->close();
	
	foreach ($_POST as $key => $value)
	{
		if(is_numeric($key)){
			$key = (int)$key;
			$stmt = $con->prepare("SELECT price FROM items WHERE id = ?");
			$stmt->bind_param("i", $key);
			$stmt->execute();
			$res = $stmt->get_result();
			if($row = $res->fetch_array())
			{
				$price = $row['price'];
			}
			$stmt->close();
			
			$quantity = (int)$value;
			$item_price = $quantity * $price;
			$stmt = $con->prepare("INSERT INTO order_details (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)");
			$stmt->bind_param("iiii", $order_id, $key, $quantity, $item_price);
			$stmt->execute();
			$stmt->close();
		}
	}
	
	if($payment_type == 'Wallet'){
		$newBalance = (int)$balance - $total;
		$stmt = $con->prepare("UPDATE wallet_details SET balance = ? WHERE wallet_id = ?");
		$stmt->bind_param("ii", $newBalance, $wallet_id);
		$stmt->execute();
		$stmt->close();
	}
	header("location: ../orders.php");
}
?>