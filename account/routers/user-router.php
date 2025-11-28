<?php
include '../includes/connect.php';
	foreach ($_POST as $key => $value)
	{
		if(preg_match("/[0-9]+_role/",$key)){
			$user_id = intval(strtok($key, '_'));
			$stmt = $con->prepare("UPDATE users SET role = ? WHERE id = ?");
			$stmt->bind_param("si", $value, $user_id);
			$stmt->execute();
			$stmt->close();
		}
		if(preg_match("/[0-9]+_verified/",$key)){
			$user_id = intval(strtok($key, '_'));
			$stmt = $con->prepare("UPDATE users SET verified = ? WHERE id = ?");
			$stmt->bind_param("si", $value, $user_id);
			$stmt->execute();
			$stmt->close();
		}
		if(preg_match("/[0-9]+_deleted/",$key)){
			$user_id = intval(strtok($key, '_'));
			$stmt = $con->prepare("UPDATE users SET deleted = ? WHERE id = ?");
			$stmt->bind_param("si", $value, $user_id);
			$stmt->execute();
			$stmt->close();
		}		
		if(preg_match("/[0-9]+_balance/",$key)){
			$user_id = intval(strtok($key, '_'));
			$stmt_wallet = $con->prepare("SELECT * FROM wallet WHERE customer_id = ?");
			$stmt_wallet->bind_param("i", $user_id);
			$stmt_wallet->execute();
			$result = $stmt_wallet->get_result();
			if($row = $result->fetch_array()){
				$wallet_id = $row['id'];
				$stmt_balance = $con->prepare("UPDATE wallet_details SET balance = ? WHERE wallet_id = ?");
				$stmt_balance->bind_param("si", $value, $wallet_id);
				$stmt_balance->execute();
				$stmt_balance->close();
			}
			$stmt_wallet->close();
		}			
	}
header("location: ../users.php");
?>