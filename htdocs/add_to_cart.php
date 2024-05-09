<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = json_decode(file_get_contents("php://input"));
    if (!$data || !isset($data->name) || !isset($data->price)) {
        http_response_code(400); 
        exit("Invalid data received");
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

    $loginname = $data->loginname;

    $itemName = $conn->real_escape_string($data->name); // Escape the name to prevent SQL injection
    $itemPrice = $data->price;


    $checkSql = "SELECT * FROM cart WHERE name = '$itemName' AND owner_name = '$loginname'";
    $checkResult = $conn->query($checkSql);
    if ($checkResult->num_rows > 0) {
        http_response_code(400); // Bad request
        exit("Item already exists in the cart");
    }


    
    $insertSql = "INSERT INTO cart (name, price, owner_name) VALUES ('$itemName', $itemPrice, '$loginname')";
    if ($conn->query($insertSql) === TRUE) {
        http_response_code(200); // OK
        exit("Item added to cart: $itemName");
    } else {
        http_response_code(500); // Internal Server Error
        exit("Error adding item to cart: " . $conn->error);
    }


    $conn->close();
} else {
    http_response_code(405); // Method Not Allowed
    exit("Method not allowed");
}
?>
