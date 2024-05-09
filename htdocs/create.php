<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "database";
$database_port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate username and password
$username = $conn->real_escape_string($_POST['username']);
$password = $conn->real_escape_string($_POST['password']);

// Validate username
if (empty($username) || strlen($username) < 5 || !preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    echo "<script>alert('Invalid username! Username must be at least 5 characters long and can only contain letters, numbers, and underscores.'); window.location.href='signup.html';</script>";
    exit();
}

// Validate password
if (empty($password) || strlen($password) < 8) {
    echo "<script>alert('Invalid password! Password must be at least 8 characters long.'); window.location.href='signup.html';</script>";
    exit();
}

$check_query = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($check_query);

if ($result->num_rows > 0) {
    echo "<script>alert('Username already exists!'); window.location.href='signup.html';</script>";
} else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password before storing it

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', 'user')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration was successful!'); window.location.href='index.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
