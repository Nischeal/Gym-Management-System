<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $m_type = $_POST['m_type'];
    $amount = $_POST['amount'];
    $name = $_POST['name'];
    $features = $_POST['features'];
    $duration = $_POST['duration'];
    
    $stmt = $pdo->prepare("INSERT INTO memberships (m_type, amount, name, features, duration) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$m_type, $amount, $name, $features, $duration]);

    $success = "Membership added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- <link rel="stylesheet" href="add.css"> -->
    <link rel="stylesheet" href="style.css">
    <title>Add Membership</title>
</head>
<body class="add">
    <!-- Header -->
    <header>
        <nav>
        <a href="index.php" class="logo">
            <i class='bx bx-dumbbell'></i>
            <div class="logo-name"><span>Gym</span>Hero</div>
        </a>
        </nav>
        
    </header>
    <!-- End of Header -->

    <!-- Main Content -->
    <div class="add-content">
        <main class="add-main-content">
            <div class="add-title">
                <h1>Add New Membership</h1>
                <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="m_type">Membership Type</label>
                        <input type="text" id="m_type" name="m_type" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" id="amount" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="features">Features</label>
                        <input type="text" id="features" name="features" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration in days</label>
                        <input type="number" id="duration" name="duration" required>
                    </div>
                    <button type="submit" class="submit-btn">Add Membership</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>