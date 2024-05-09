<?php

if (isset($_POST['delete_submit'])) {

    if (isset($_POST['delete_id'])) {

        $servername = "127.0.0.1";
        $username = "root"; 
        $password = ""; 
        $dbname = "database";


        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        $stmt = $conn->prepare("DELETE FROM NFTItems WHERE id = ?");
        $stmt->bind_param("i", $delete_id);


        $delete_id = $_POST['delete_id'];


        if ($stmt->execute()) {

            if ($stmt->affected_rows > 0) {
                echo "<script>alert('NFT with ID $delete_id deleted successfully!'); window.location.href='dashboard.php';</script>";
            } else {
                echo "<script>alert('NFT with ID $delete_id does not exist!'); window.location.href='dashboard.php';</script>";
            }
        } else {
            echo "Error: " . $stmt->error;
        }


        $stmt->close();
        $conn->close();
    } else {
        echo "ID to delete not specified.";
    }
}
?>
