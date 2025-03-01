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

// Function to fetch data from the users 
function fetchUsers($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch  from the trainers 
function fetchTrainers($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM trainers");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch  from the memberships 
function fetchMemberships($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM memberships");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch dashboard statistics
function fetchDashboardStats($pdo) {
    $stats = [];

    // Fetch total members
    $stmt = $pdo->prepare("SELECT * FROM user_count");
    $stmt->execute();
    $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

    // Fetch site visits (example value, you might need to adjust this)
    $stmt = $pdo->prepare("SELECT COUNT(t_id) as trainer_count FROM trainers");
    $stmt->execute();
    $stats['t_id'] = $stmt->fetch(PDO::FETCH_ASSOC)['trainer_count'];

   

    // Fetch searches (example value, you might need to adjust this)
    $stmt = $pdo->prepare("SELECT COUNT(*) AS enroll_count FROM members");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stats['eid'] = $result['enroll_count'] ?? 0; 
    

    

    // Fetch total sales (example value, you might need to adjust this)
    $stmt = $pdo->prepare("SELECT SUM(AMOUNT) AS total_amt FROM members");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stats['amount'] = $result['total_amt'] ?? 0; 
    
    return $stats;
}
?>