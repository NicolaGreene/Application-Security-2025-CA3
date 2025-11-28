<?php
include '../includes/connect.php';
	foreach ($_POST as $key => $value)
	{
		if(preg_match("/[0-9]+_name/",$key)){
			if($value != ''){
			$item_id = intval(strtok($key, '_'));
			$stmt = $con->prepare("UPDATE items SET name = ? WHERE id = ?");
			$stmt->bind_param("si", $value, $item_id);
			$stmt->execute();
			$stmt->close();
			}
		}
		if(preg_match("/[0-9]+_price/",$key)){
			$item_id = intval(strtok($key, '_'));
			$price = (int)$value;
			$stmt = $con->prepare("UPDATE items SET price = ? WHERE id = ?");
			$stmt->bind_param("ii", $price, $item_id);
			$stmt->execute();
			$stmt->close();
		}
		if(preg_match("/[0-9]+_hide/",$key)){
			$item_id = intval(strtok($key, '_'));
			$deleted = ($_POST[$key] == 1) ? 0 : 1;
			$stmt = $con->prepare("UPDATE items SET deleted = ? WHERE id = ?");
			$stmt->bind_param("ii", $deleted, $item_id);
			$stmt->execute();
			$stmt->close();
		}
		if(preg_match("/[0-9]+_image/",$key)){
			$item_id = intval(strtok($key, '_'));
			$stmt = $con->prepare("UPDATE items SET image = ? WHERE id = ?");
			$stmt->bind_param("si", $value, $item_id);
			$stmt->execute();
			$stmt->close();
		}

	}
header("location: ../admin-page.php");
?>