<?php
$host = 'localhost';
$dbname = 'gym_management_system';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function fetchUserByEmail($pdo, $email, $password) {
    // Prepare the statement to fetch the user by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $users = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if the user exists and verify the password
    if ($users && password_verify($password) === $users['password']) {

        return $users; // Return user data if password matches
    }
    
    return null; // Return null if user not found or password does not match
}

function fetchMemberships($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM memberships");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


if (isset($_SESSION['u_id'])) {
    $u_id = $_SESSION['u_id'];  // Get user ID from session

    // Query to get membership details for the logged-in user
    $stmt = $conn->prepare("
        SELECT m.m_type, m.amount 
        FROM members mem
        JOIN memberships m ON mem.m_id = m.m_id
        WHERE mem.u_id = ?
    ");
    $stmt->bind_param("i", $u_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind the result to variables
        $stmt->bind_result($m_type, $amount);
        $stmt->fetch();
    } else {
        // If no membership is found, set to default values
        $m_type = "N/A";
        $amount = "N/A";
    }

    $stmt->close();
} else {
    // If user ID is not available in session, set default values
    $m_type = "N/A";
    $amount = "N/A";
}

?>
