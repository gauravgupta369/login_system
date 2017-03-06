<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Checking for Username
if (isset($_POST['usernamecheck'])) {
    $u = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
    include_once("includes/connection.php");
    if (validateUserName($conn, $u)) {
        die("valid");
    } else {
        die("invalid");
    }
}
//register user
if (isset($_POST["username"]) && isset($_POST['email']) && isset($_POST['password'])) {
    include_once("includes/connection.php");
    $u = preg_replace('#[^a-z0-9]#i', '', $_POST['username']);
    $e = $_POST['email'];
    $p = $_POST['password'];
    $g = preg_replace('#[^a-z]#', '', $_POST['gender']);
    $c = preg_replace('#[^a-z ]#i', '', $_POST['country']);
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));



    if ($u == "" || $e == "" || $p == "" || $g == "" || $c == "") {
        die("The form submission is missing values.");
        
    } else if (strlen($u) < 3 || strlen($u) > 16) {
        die("Username must be between 3 and 16 characters"); 
    }

    if (! validateUserName($conn, $u)) {
        die("Username already exists");
    }
    if (! validateEmail($conn, $e)) {
        die('Email Allready Registered');
    }

    $p_hash = md5($p);
    try {
    $query = "INSERT INTO users (username, email, password, gender, country, ip,activated,signup, lastlogin, notescheck)       
            VALUES(?, ?, ?, ?, ?, ?, '1', now(), now(), now())";

    $stmt = $conn->prepare($query);
    $stmt->execute([$u, $e, $p_hash, $g, $c, $ip]);
    unset($query, $stmt);
    $uid = $conn->lastInsertId();

    } catch (PDOException $e) {
        die($e->getMessage());
    }
    // Establish their row in the useroptions table
    $query = "INSERT INTO useroptions (id, username, background) VALUES (?, ?,'original')";
    $stmt = $conn->prepare($query);
    $stmt->execute([$uid, $u]);

    // Create directory(folder) to hold each user's files(pics, MP3s, etc.)
    if (!file_exists("user/$u")) {
        mkdir("user/$u", 777);
    }
    
    die("signup_success");
}
//helper functions
function validateUserName($conn, $username) 
{
    if (strlen($username) < 6 || strlen($username) > 16) {
        echo '6 - 16 characters please';
        exit();
    }
    if (is_numeric($username[0])) {
        echo 'Usernames must begin with a letter';
        exit();
    }
    $query = "SELECT id FROM users WHERE username= ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute([$username]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    
    return $result ? false : true;
}

function validateEmail($conn, $email) 
{
    $query = " SELECT id FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);

    return $result ? false : true;
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Social Networking Site</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script type="text/javascript" src="js/ajax.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Chat Room</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="register.php">Register</a></li>
        <li><a href="index.php">Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<section id="register">
  <div class="container">
    <div class="col-md-8 col-md-offset-2">
      <form name="register_form" id="register_form" onsubmit="return false;">
        <label>Username</label>
        <input class="form-control spacing" type="text" placeholder="Username" name="username" id="username" onkeyup="restrict('username')" onblur="checkUserName()">
        <label>Email</label>
        <input class="form-control spacing" type="email" placeholder="Enter Email" name="email" id="email" onkeyup="restrict('email')" required>
        <label>Password</label>
        <input class="form-control spacing" type="password" placeholder="Enter Password" name="password" id="password"  minlength="6" maxlength="16" required>
        <label>Password Confirm</label>
        <input class="form-control spacing" type="password" placeholder="Re-Enter Password" name="password_confirm" id="password_confirm" minlength="6" maxlength="16" required>
        <label>Gender</label>
        <select class="form-control spacing" name="sex" id="sex" required>
          <option value="">Gender</option>
          <option value="m">m</option>
          <option value="f">f</option>
        </select>
        <label>Country</label>
        <select class="form-control spacing" name="country" id="country" required>
          <option value="" >Country</option>
          <option value="India">India</option>
        </select>
        <button class="btn btn-default spacing btn-lg register_btn" name="login_btn" id="login_btn" onclick="register()">
          Register
        </button>

      </form>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="row">  
      <div class="col-md-12">
        <p>Copyright &copy; 2017, All Rights Reserved</p>
      </div>
    </div>
  </div>
</footer>

</body>
</html>