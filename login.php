<?php 

//ini_set('display_errors' , 1);
//error_reporting(E_ALL);

if (isset($_POST['email']) && isset($_POST['password'])) {
	include_once("includes/connection.php");
	$email = $_POST['email'];
	$password = $_POST['password']; 
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	if ($email == "" || $password == "") {
 		die("login_failed");
	}
	$query = "SELECT id, username, password FROM users where email= ? AND activated = '1' LIMIT 1";
	$stmt = $conn->prepare($query);
	$stmt->execute([$email]);
	$result = $stmt->fetch(PDO::FETCH_OBJ);
	if ($result) {
		$db_password = $result->password;
		$password = md5($password);
		if ($password == $db_password) {
			$db_id = $result->id;
			$db_username = $result->username;
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_password;
			setcookie("userid", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("username", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("password", $db_password, strtotime( '+30 days' ), "/", "", "", TRUE); 
			// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
			$query = "UPDATE users SET ip= ? , lastlogin=now() WHERE username= ? LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->execute([$ip, $db_username]);
			echo $db_username;
		} else {
			die("login_failed");	
		}
	} else {
		die("login_failed");
	}

} else {
	die("login_failed");
}