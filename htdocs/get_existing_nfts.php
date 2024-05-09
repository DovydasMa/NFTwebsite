<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : 'all';

if ($search !== 'all') {
    $limit = 8;
    $offset = ($page - 1) * $limit;

    // Prepare the SQL query with parameterized statement to prevent SQL injection
    $sql = "SELECT * FROM NFTItems WHERE for_sale = 1 AND name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $nfts = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nfts[] = array(
                'image_url' => $row['image_url'],
                'name' => $row['name'],
                'description' => $row['description'],
                'price' => $row['price']
            );
        }
    }
    $stmt->close();
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($nfts);
} else {
    $limit = 8;
    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM NFTItems WHERE for_sale = 1";
    if ($category !== 'all') {
        $sql .= " AND category = '$category'";
    }
    $sql .= " LIMIT $limit OFFSET $offset";

    $result = $conn->query($sql);

    $nfts = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $nfts[] = array(
                'image_url' => $row['image_url'],
                'name' => $row['name'],
                'description' => $row['description'],
                'price' => $row['price']
            );

        }
    }

    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($nfts);
}
?>

