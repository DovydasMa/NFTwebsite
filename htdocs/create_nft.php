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

    $stmt = $conn->prepare("INSERT INTO NFTItems (image_url, name, description, price, for_sale, category) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdis", $image_url, $name, $description, $price, $for_sale, $category);

    $image_url = $_FILES['image']['name']; 
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $for_sale = $_POST['for_sale']; 
    $category = $_POST['category']; // New line added for category

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

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    if ($stmt->execute()) {
        echo "<script>alert('NFT was added successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
