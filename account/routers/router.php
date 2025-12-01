<?php
include '../includes/connect.php';
$success=false;


function login_log($username, $status){
	$logfile = __DIR__ . '/../../logs/login.txt';
	$timestamp = date("Y-m-d H:i:s");

	$logEntry = "[$timestamp] USERNAME: $username | STATUS: $status" . PHP_EOL;
	file_put_contents($logfile, $logEntry, FILE_APPEND);
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $con->prepare("SELECT * FROM users WHERE username = ? AND role = 'Administrator' AND deleted = 0");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
while($row = mysqli_fetch_array($result))
{
	if(password_verify($password, $row['password'])){
		$success = true;
		$user_id = $row['id'];
		$name = $row['name'];
		$role= $row['role'];
	}
}
$stmt->close();

if($success == true)
{	
	login_log($username, "ADMIN LOGIN SUCCESS");

	session_start();
	$_SESSION['admin_sid']=session_id();
	$_SESSION['user_id'] = $user_id;
	$_SESSION['role'] = $role;
	$_SESSION['name'] = $name;

	header("location: ../admin-page.php");
}
else
{
	if($username == "admin"){
		login_log($username, "ADMIN LOGIN FAILED");
	}
	$stmt = $con->prepare("SELECT * FROM users WHERE username = ? AND role = 'Customer' AND deleted = 0");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	while($row = mysqli_fetch_array($result))
	{
		if(password_verify($password, $row['password'])){
			$success = true;
			$user_id = $row['id'];
			$name = $row['name'];
			$role= $row['role'];
		}
	}
	$stmt->close();
	
	if($success == true)
	{
		login_log($username, "CUSTOMER LOGIN SUCCESS");

		session_start();
		$_SESSION['customer_sid']=session_id();
		$_SESSION['user_id'] = $user_id;
		$_SESSION['role'] = $role;
		$_SESSION['name'] = $name;			
		header("location: ../index.php");
	}
	else
	{
		if($username != "admin"){
			login_log($username, "CUSTOMER LOGIN FAILED");
		}
		header("location: ../login.php");
	}
}
?>