<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$for_sale = isset($_GET['for_sale']) ? $_GET['for_sale'] : 0;

$sql = "SELECT * FROM NFTItems";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['owner_id'] == $_SESSION['loggedin']){
            if ($row['for_sale'] == $for_sale){
                $nfts[] = array(
                    'image_url' => $row['image_url'],
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'id' => $row['id'], 
                );
        }}
    }
}

$conn->close();


header('Content-Type: application/json');
echo json_encode($nfts);
?>
