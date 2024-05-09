<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    http_response_code(401); // Unauthorized
    exit("User not logged in");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    exit("POST method required");
}

// Check if JSON data is received
$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    http_response_code(400); // Bad Request
    exit("Invalid JSON data received");
}

// Check if itemName and loginname are set in the JSON data
if (!isset($data->itemName) || !isset($data->loginname)) {
    http_response_code(400); // Bad Request
    exit("Item name or login name not provided in the JSON data");
}

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    exit("Connection failed: " . $conn->connect_error);
}

$itemName = $conn->real_escape_string($data->itemName);
$loginname = $conn->real_escape_string($data->loginname);

$sql = "DELETE FROM cart WHERE name = '$itemName' AND owner_name = '$loginname'";
if ($conn->query($sql) === TRUE) {
    http_response_code(200); // OK
    exit("$itemName removed from cart");
} else {
    http_response_code(500); // Internal Server Error
    exit("Error removing item from cart: " . $conn->error);
}

$conn->close();
?>
