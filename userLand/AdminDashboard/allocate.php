<?php
session_start();
include 'db.php';

// if(!isset($_SESSION['log'])){
//     echo "<script>alert('Login Required')</script>";
//     echo '<meta http-equiv = "refresh" content = "0; url = ../Form/login.php"/>';
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['u_id']) && isset($_POST['t_id'])) {
        $userId = $_POST['u_id'];
        $trainerId = $_POST['t_id'];

        $stmt = $pdo->prepare("UPDATE users SET t_id = ? WHERE u_id = ?");
        $stmt->execute([$trainerId, $userId]);

        echo "<script>alert('Trainer allocated successfully');</script>";
        echo '<meta http-equiv = "refresh" content = "0; url = index.php"/>';
        exit;
    } else {
        echo "<script>alert('Invalid form submission');</script>";
        exit;
    }
} else {
    if (isset($_GET['u_id'])) {
        $userId = $_GET['u_id'];
        $user = fetchUserById($pdo, $userId);
        
        if (!$user) {
            echo "<script>alert('User not found');</script>";
            exit;
        }

        $trainers = fetchTrainers($pdo);
    } else {
        echo "<script>alert('User ID is missing');</script>";
        exit;
    }
}

function fetchUserById($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE u_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Allocate Trainer</title>
</head>
<body>
    <div class="container">
        <h2>Allocate Trainer to <?php echo htmlspecialchars($user['fullname'] ?? 'Unknown'); ?></h2>
        <form method="POST" action="allocate.php">
            <input type="hidden" name="u_id" value="<?php echo htmlspecialchars($user['u_id']); ?>">
            <label for="trainer">Select Trainer:</label>
            <select name="t_id" id="trainer" required>
                <?php foreach ($trainers as $trainer): ?>
                    <option value="<?php echo htmlspecialchars($trainer['t_id']); ?>"><?php echo htmlspecialchars($trainer['fullname']); ?></option>
                <?php endforeach; ?>
            </select>
            <a href="index.php"><button type="submit">Allocate</button></a>
        </form>
    </div>
</body>
</html>
