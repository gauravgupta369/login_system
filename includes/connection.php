<?php 

$host = "localhost";
$uname = "gaurav";
$pwd = "*********";
try {
    $conn = new PDO("mysql:host=$host;dbname=login_system", $uname, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
