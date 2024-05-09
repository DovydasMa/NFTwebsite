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

// SQL query to select only pending support tickets
$sql = "SELECT * FROM complaints WHERE status = 'pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Subject
        echo "<p><a href='javascript:void(0);' onclick='toggleComplaint(\"complaint_" . $row["id"] . "\")'><strong>Subject:</strong> " . $row["subject"] . "</a></p>";
        // Details
        echo "<div id='complaint_" . $row["id"] . "' style='display:none;'>";
        echo "<p><strong>User ID:</strong> " . $row["user_id"] . "</p>";
        echo "<p><strong>Complaint Text:</strong> " . $row["complaint_text"] . "</p>";
        echo "<p><strong>Status:</strong> " . $row["status"] . "</p>";
        // Form to write an answer
        echo "<form action='answer_complaint.php' method='post'>";
        echo "<input type='hidden' name='complaint_id' value='" . $row["id"] . "'>";
        echo "<textarea name='answer' rows='4' cols='50' placeholder='Write your answer'></textarea><br>";
        echo "<input type='submit' value='Submit Answer'>";
        echo "</form>";
        echo "</div>";
        echo "<br>"; 
        echo "<hr>";
    }
} else {
    echo "No pending support tickets found.";
}

$conn->close();
?>

<script>
    function toggleComplaint(id) {
        var complaint = document.getElementById(id);
        if (complaint.style.display === "none") {
            complaint.style.display = "block";
        } else {
            complaint.style.display = "none";
        }
    }
</script>
