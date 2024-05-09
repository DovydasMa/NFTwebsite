<?php
if (!isset($_SESSION['loggedin'])) {
    header("Location: index.html");
    exit();
}

// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['loggedin'];

$sql = "SELECT * FROM complaints WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<p><strong>Complaint Text:</strong> " . $row["complaint_text"] . "</p>";
            echo "<p><strong>Status:</strong> " . $row["status"] . "</p>";
            echo "<hr>";
        }
    } else {
        echo "No support tickets found.";
    }
    
    
}

$conn->close();
?>
