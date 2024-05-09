<?php
session_start();

if ($_SESSION['loggedin'] !== "admin") {
    header("Location: admin.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the complaint ID and response are provided
    if(isset($_POST['complaint_id']) && isset($_POST['answer'])) {
        $complaint_id = $_POST['complaint_id'];
        $response_text = $_POST['answer'];

        // Database connection
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "database";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert the response into the admin_responses table
        $sql_insert_response = "INSERT INTO admin_responses (admin_id, complaint_id, response_text) VALUES ('2', '$complaint_id', '$response_text')";
        if ($conn->query($sql_insert_response) === TRUE) {
            // Update the status of the complaint to "answered"
            $sql_update_status = "UPDATE complaints SET status = 'answered' WHERE id = '$complaint_id'";
            if ($conn->query($sql_update_status) === TRUE) {

                echo "<script>alert('Response submitted successfully!'); window.location.href='dashboard.php';</script>";

            } else {
                echo "Error updating status: " . $conn->error;
            }
        } else {
            echo "Error inserting response: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Complaint ID and response are required!";
    }
} else {
    echo "Invalid request!";
}
?>