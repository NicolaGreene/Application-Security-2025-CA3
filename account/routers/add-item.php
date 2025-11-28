<?php
include '../includes/connect.php';

$name = $_POST['name'];
$price = (int)$_POST['price'];
$image = file_get_contents($_FILES['image']['tmp_name']);

$stmt = $con->prepare("INSERT INTO items (name, price, image) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $name, $price, $image);
$stmt->execute();
if(!$stmt){
    echo mysqli_error($con);
}
var_dump($con->error);
$stmt->close();
// header("location: ../admin-page.php");
?>