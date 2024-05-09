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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  

        $nft_id = $_POST['nft_id'];
        $price = $_POST['price'];

       
        $sql = "UPDATE nftItems SET for_sale = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $t=0;

    $stmt->bind_param("ii", $t, $nft_id); 
    $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            echo "NFT price updated successfully.";
        } else {
            echo "Error updating NFT price: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "NFT ID and price are required.";
    }


$conn->close();
?>