<?php
session_start();
include_once("includes/connection.php");

$log_id = "";
$log_username = "";
$log_password = "";
$user_ok = false;
if (isset($_SESSION["userid"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])) {
	$log_id = preg_replace('#[^0-9]#', '', $_SESSION['userid']);
	$log_username = preg_replace('#[^a-z0-9]#i', '', $_SESSION['username']);
	$log_password = preg_replace('#[^a-z0-9]#i', '', $_SESSION['password']);
	$user_ok = evalLoggedUser($conn,$log_id,$log_username,$log_password);
} else if (isset($_COOKIE["userid"]) && isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
	$_SESSION['userid'] = preg_replace('#[^0-9]#', '', $_COOKIE['userid']);
    $_SESSION['username'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['username']);
    $_SESSION['password'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['password']);
	$log_id = $_SESSION['userid'];
	$log_username = $_SESSION['username'];
	$log_password = $_SESSION['password'];
	// Verify the user
	$user_ok = evalLoggedUser($conn,$log_id,$log_username,$log_password);
	if ($user_ok == true) {
		// Update their lastlogin datetime field
		$query = "UPDATE users SET lastlogin=now() WHERE id= ? LIMIT 1";
		$stmt = prepare($query);
		$stmt->execute([$log_id]);
	}
} else {
	header('location:index.php');
}

function evalLoggedUser($conn,$id,$u,$p){
	$query = "SELECT ip FROM users WHERE id= ?  AND username= ? AND password= ? AND activated='1' LIMIT 1";
   	$stmt = $conn->prepare($query);
   	$stmt->execute([$id, $u, $p]);
   	$result = $stmt->fetch(	PDO::FETCH_OBJ);
	return $result ? false : true;
}
?>
