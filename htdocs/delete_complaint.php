<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if complaint ID is provided
    if(isset($_POST['complaint_id'])) {
        $complaint_id = $_POST['complaint_id'];

        // Database connection
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "database";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Delete related records in admin_responses table
        $sql_delete_responses = "DELETE FROM admin_responses WHERE complaint_id = '$complaint_id'";
        if ($conn->query($sql_delete_responses) === TRUE) {
            // Delete the complaint from the database
            $sql_delete_complaint = "DELETE FROM complaints WHERE id = '$complaint_id'";
            if ($conn->query($sql_delete_complaint) === TRUE) {
                echo "<script> window.location.href='support.php';</script>";
                exit();
            } else {
                echo "Error: " . $sql_delete_complaint . "<br>" . $conn->error;
            }
        } else {
            echo "Error deleting related responses: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Complaint ID is required!";
    }
} else {
    echo "Invalid request!";
}
?>





            