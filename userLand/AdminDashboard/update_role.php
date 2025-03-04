<?php
session_start();
include 'db.php';

// if (!isset($_SESSION['log'])) {
//     echo "<script>alert('Login Required');</script>";
//     echo '<meta http-equiv="refresh" content="0; url=../Form/login.php"/>';
//     exit;
// }

if (isset($_GET['u_id'])) {
    $userId = $_GET['u_id'];

    // Update the user's role to admin
    $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE u_id = ?");
    if ($stmt->execute([$userId])) {
        echo "<script>alert('User role updated to admin');</script>";
    } else {
        echo "<script>alert('Failed to update user role');</script>";
    }
    
    echo '<meta http-equiv="refresh" content="0; url=index.php"/>';
} else {
    echo "<script>alert('User ID not provided');</script>";
    echo '<meta http-equiv="refresh" content="0; url=index.php"/>';
}
?>