<?php
session_start();
require ('db.php'); // Your database connection file
// print_r($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u_id = $_POST['u_id'];
    $m_id = $_POST['m_id'];
    $amount = $_POST['amount'];
    $duration = $_POST['duration'];

    if ($u_id == null || $m_id == null || $amount == null || $duration == null || $duration == 0) {
        die("Error: Missing or invalid data.");
    }
    
    // Insert enrollment record
    $stmt = $conn->prepare("INSERT INTO members (u_id, m_id, amount, duration) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiii", $u_id, $m_id, $amount, $duration);

    if ($stmt->execute()) {
        echo "Enrollment successful!";
    } else {
        echo "Error enrolling: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
