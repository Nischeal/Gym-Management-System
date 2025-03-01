<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate full name (only letters and spaces)
    if (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
        $error = "Only letters and white space allowed in full name";
    }
    // Validate email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    }
    // Validate password (at least 8 characters, at least one letter and one number)
    elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)) {
        $error = "Password must be at least 8 characters long and include at least one letter and one number";
    }
    else {
        $password = md5($password);
        $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$fullname, $email, $password]);

        $success = "User added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Add User</title>
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
                <h1>Add New User</h1>
                <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" name="fullname" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="submit-btn">Add User</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>