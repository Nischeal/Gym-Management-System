<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $speciality = $_POST['speciality'];
    $phone = $_POST['phone'];

    $stmt = $pdo->prepare("INSERT INTO trainers (fullname, speciality, ph_no) VALUES (?, ?, ?)");
    $stmt->execute([$fullname, $speciality, $phone]);

    $success = "Trainer added successfully!";
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
    <title>Add Trainer</title>
</head>
<body class="add">
    <!-- Header -->
    <header>
        <nav>
        <a href="#" class="logo">
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
                <h1>Add New Trainer</h1>
                <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" name="fullname" required>
                    </div>
                    <div class="form-group">
                        <label for="speciality">Speciality</label>
                        <input type="text" id="speciality" name="speciality" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" required>
                    </div>
                    <button type="submit" class="submit-btn">Add Trainer</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>