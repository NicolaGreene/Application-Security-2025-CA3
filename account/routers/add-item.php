<?php
include '../includes/connect.php';

$name = $_POST['name'];
$price = (int)$_POST['price'];
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    echo "Please upload an image.";
    return;
}
$image = file_get_contents($_FILES['image']['tmp_name']);


$stmt = $con->prepare("INSERT INTO items (name, price, image) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $name, $price, $image);
$stmt->execute();

$stmt->close();
 header("location: ../admin-page.php");
?>