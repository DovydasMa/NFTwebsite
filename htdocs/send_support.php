<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $user_id = $_SESSION['loggedin'];

    // Database connection
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Inserting data into the complaints table
    $sql = "INSERT INTO complaints (user_id, subject, complaint_text, status) VALUES ('$user_id', '$subject', '$description', 'Pending')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Support ticket submitted successfully!'); window.location.href='support.php';</script>";
        exit();

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
