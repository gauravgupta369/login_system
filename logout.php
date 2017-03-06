<?php
session_start();
// Set Session data to an empty array
$_SESSION = array();
// Expire their cookie files
if(isset($_COOKIE["userid"]) && isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
	setcookie("userid", '', strtotime( '-5 days' ), '/');
    setcookie("username", '', strtotime( '-5 days' ), '/');
	setcookie("password", '', strtotime( '-5 days' ), '/');
}

session_destroy();

header('location:index.php');

?>
