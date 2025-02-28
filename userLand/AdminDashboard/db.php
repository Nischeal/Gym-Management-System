<?php
$host = 'localhost';
$dbname = 'gym_management_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Function to fetch data from the users table
function fetchUsers($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch data from the trainers table
function fetchTrainers($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM trainers");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch data from the memberships table
function fetchMemberships($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM memberships");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch dashboard statistics
function fetchDashboardStats($pdo) {
    $stats = [];

    // Fetch total members
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_members FROM members");
    $stmt->execute();
    $stats['total_members'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_members'];

    // Fetch site visits (example value, you might need to adjust this)
    $stats['site_visits'] = 3944;

    // Fetch searches (example value, you might need to adjust this)
    $stats['searches'] = 14721;

    // Fetch total sales (example value, you might need to adjust this)
    $stats['total_sales'] = 6742;

    return $stats;
}
?>