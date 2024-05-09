<?php
session_start();

// Check if the user is logged in as admin
if ($_SESSION['loggedin'] !== "admin") {
    header("Location: admin.html");
    exit();
}

// Check if the form submission is made via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user ID to be deleted is provided
    if(isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        // Database connection parameters
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "database";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Construct the SQL DELETE query
        $sql = "DELETE FROM users WHERE id = '$user_id'";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            // Redirect back to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error deleting user: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "User ID to be deleted is not provided.";
    }
} else {
    echo "Invalid request!";
}
?>