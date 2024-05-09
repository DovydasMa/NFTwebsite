<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    http_response_code(401); // Unauthorized
    exit("User not logged in");
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

$loginname = $_GET['loginname'] ?? '';
$sql = "SELECT * FROM transactions WHERE owner_name = '$loginname'";
$result = $conn->query($sql);

if ($result) {
    $transactions = [];
    while ($row = $result->fetch_assoc()) {
        $transactions[] = [
            'hash' => $row['hash'],
            'name' => $row['name'],
            'price' => $row['price'],
            'owner_name' => $row['owner_name'],

        ];
    }
    if (empty($transactions)) {
        http_response_code(404); // Not Found
        exit("No transactions found");
    }
} else {
    http_response_code(500); // Internal Server Error
    exit("Error executing query: " . $conn->error);
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(['transactions' => $transactions]);
?>
