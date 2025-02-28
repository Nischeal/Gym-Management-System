<?php
session_start();
require 'db.php'; // Your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u_id = $_POST['u_id'];
    $m_id = $_POST['m_id'];

    if (empty($u_id) || empty($m_id)) {
        die("Error: Missing required data.");
    }

    // Insert enrollment record
    $stmt = $conn->prepare("INSERT INTO members (u_id, m_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $u_id, $m_id);

    if ($stmt->execute()) {
        echo "Enrollment successful!";
    } else {
        echo "Error enrolling: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
