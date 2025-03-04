<?php
session_start();
require ('db.php'); // Your database connection file
// print_r($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u_id = $_POST['u_id'];
    $m_id = $_POST['m_id'];
    $m_type = $_POST['m_type'];
    $amount = $_POST['amount'];
    $duration = $_POST['duration'];

    if ($u_id == null || $m_id == null || $m_type == null || $amount == null || $duration == null || $duration == 0) {
        die("Error: Missing or invalid data.");
    }
    
    // Insert enrollment record
    $stmt = $conn->prepare("INSERT INTO members (u_id, m_id, m_type, amount, duration) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisii", $u_id, $m_id, $m_type, $amount, $duration);

    if ($stmt->execute()) {
        // echo "Enrollment successful!";
        header('Location: index.php');
    } else {
        echo "Error enrolling: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
