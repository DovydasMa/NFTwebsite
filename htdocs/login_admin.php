<?php
session_start();

$servername = "127.0.0.1"; 
$username = "root"; 
$password = ""; 
$dbname = "database";
$database_port = 3306; 



$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$username = $_POST['username'];
$password = $_POST['password'];


$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role = 'admin'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {

    $_SESSION['loggedin'] = 'admin';
    header("Location: dashboard.php");

    exit(); 
} else {

    echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='admin.html';</script>";

}

$conn->close();
?>