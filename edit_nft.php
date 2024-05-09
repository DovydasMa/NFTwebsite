<?php
session_start();

if ($_SESSION['loggedin'] !== "admin") {
    header("Location: admin.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $servername = "127.0.0.1"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "database";
    $database_port = 3306; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_POST['nft_id'];
    $stmt_check_owner = $conn->prepare("SELECT owner_id FROM NFTItems WHERE id = ?");
    $stmt_check_owner->bind_param("i", $id);
    $stmt_check_owner->execute();
    $stmt_check_owner->store_result();

    // Check if the owner_id is greater than 0
    if ($stmt_check_owner->num_rows > 0) {
        $stmt_check_owner->bind_result($owner_id);
        $stmt_check_owner->fetch();

        if ($owner_id > 0) {
            echo "<script>alert('This NFT already has an owner and cannot be edited!'); window.location.href='dashboard.php';</script>";
            exit();
        }}

    $stmt = $conn->prepare("UPDATE NFTItems SET name=?, description=?, price=?, for_sale=?, category=? WHERE id=?");
    $stmt->bind_param("ssdisi", $name, $description, $price, $for_sale, $category, $id);

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $for_sale = $_POST['for_sale']; 
    $category = $_POST['category']; 
    $id = $_POST['nft_id']; 

    if (strlen($name) > 255) {
        echo "<script>alert('Name should not exceed 255 characters!'); window.location.href='dashboard.php';</script>";
        exit();
    }

    if (strlen($description) > 255) {
        echo "<script>alert('Description should not exceed 255 characters!'); window.location.href='dashboard.php';</script>";
        exit();
    }

    if ($price > 99999999) {
        echo "<script>alert('Price should not exceed $99999999!'); window.location.href='dashboard.php';</script>";
        exit();
    }
    if ($price < 0) {
        echo "<script>alert('Price can't be negative!'); window.location.href='dashboard.php';</script>";
        exit();
    }

    if ($stmt->execute()) {
        echo "<script>alert('NFT was updated successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
