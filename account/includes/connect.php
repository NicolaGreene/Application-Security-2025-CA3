<?php
session_start();
$servername = "127.0.0.1";
$server_user = "root";
$server_pass = "";
$dbname = "food";
$name = $_SESSION['name'];
$role = $_SESSION['role'];
$con = new mysqli($servername, $server_user, $server_pass, $dbname);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
set_exception_handler(function()
{
    echo "Oops! Something went wrong. Please try again later.";
});
?>