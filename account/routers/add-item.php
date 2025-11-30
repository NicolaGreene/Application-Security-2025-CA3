<?php
include '../includes/connect.php';

$name = isset($_POST['name']) ? $_POST['name'] : '';
$price = isset($_POST['price']) ? (int)$_POST['price'] : 0;

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    error_log("add-item: Image upload failed. error=" . $_FILES['image']['error']);
    header("location: ../admin-page.php?error=no_image");
    exit;
}

if (empty($name) || $price <= 0) {
    error_log("add-item: Invalid inputs. name=" . $name . ", price=" . $price);
    header("location: ../admin-page.php?error=invalid_input");
    exit;
}

$image = file_get_contents($_FILES['image']['tmp_name']);

$stmt = $con->prepare("INSERT INTO items (name, price, image) VALUES (?, ?, ?)");
$stmt->bind_param("sib", $name, $price, $image);

if(!$stmt->execute()){
    error_log("add-item: Insert failed - " . $stmt->error);
    $stmt->close();
    header("location: ../admin-page.php?error=insert_failed");
    exit;
}

$stmt->close();
header("location: ../admin-page.php?success=item_added");
exit;
?>