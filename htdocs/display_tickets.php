<?php
// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve support tickets for the logged-in user
$user_id = $_SESSION['loggedin'];
$sql = "SELECT * FROM complaints WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Display ticket details
        echo "<p><strong>Subject:</strong> " . $row["subject"] . "</p>";
        echo "<p><strong>Description:</strong> " . $row["complaint_text"] . "</p>";
        echo "<p><strong>Status:</strong> " . $row["status"] . "</p>";

        // Check if there is an answer for this ticket
        $complaint_id = $row["id"];
        $sql_response = "SELECT * FROM admin_responses WHERE complaint_id = '$complaint_id'";
        $result_response = $conn->query($sql_response);
        if ($result_response->num_rows > 0) {
            // Display answer
            while($row_response = $result_response->fetch_assoc()) {
                echo "<p><strong>Admin Response:</strong> " . $row_response["response_text"] . "</p>";
            }
        } else {
            echo "<p>No response yet.</p>";
        }

        // Add delete button
        echo "<form action='delete_complaint.php' method='post'>";
        echo "<input type='hidden' name='complaint_id' value='" . $row["id"] . "'>";
        echo "<button type='submit'>Delete Complaint</button>";
        echo "</form>";

        echo "<hr>";
    }
} else {
    echo "No support tickets found.";
}

$conn->close();
?>
