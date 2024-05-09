<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    http_response_code(401); // Unauthorized
    exit("User not logged in");
}

// Check if loginname is set in the request
if (!isset($_GET['loginname'])) {
    http_response_code(400); // Bad Request
    exit("Login name not provided");
}

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "database"; // Replace with your actual database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    exit("Connection failed: " . $conn->connect_error);
}

$loginname = $conn->real_escape_string($_GET['loginname']);

// Fetch NFTs owned by the user from the purchases table
$sql = "SELECT * FROM purchases WHERE owner_name = '$loginname'";
$result = $conn->query($sql);

if ($result === FALSE) {
    http_response_code(500); // Internal Server Error
    exit("Error fetching NFTs: " . $conn->error);
}

$nfts = array();
while ($row = $result->fetch_assoc()) {
    $nfts[] = $row;
}

// Close the database connection
$conn->close();

// Send the fetched NFTs as JSON response
header('Content-Type: application/json');
echo json_encode($nfts);
?>
