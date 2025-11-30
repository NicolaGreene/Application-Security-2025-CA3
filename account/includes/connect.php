<?php
session_start();
$servername = "127.0.0.1";
$server_user = "root";
$server_pass = "";
$dbname = "food";
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$con = new mysqli($servername, $server_user, $server_pass, $dbname);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
set_exception_handler(function()
{
    echo "Oops! Something went wrong. Please try again later.";
});
?>