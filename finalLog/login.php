<?php
session_start();
require 'db.php';

// Initialize error messages
$errors = [];
$login_errors = [];
$response = ['success' => false, 'errors' => []];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // Validate Full Name
        $fullname = trim($_POST['fullname']);
        if (empty($fullname)) {
            $errors['fullname'] = "Full name is required";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
            $errors['fullname'] = "Full name can only contain letters and spaces";
        }

        // Validate Email
        $email = trim($_POST['email']);
        if (empty($email)) {
            $errors['email'] = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }

        // Validate Password
        $password = $_POST['password'];
        if (empty($password)) {
            $errors['password'] = "Password is required";
        } elseif (strlen($password) < 8) {
            $errors['password'] = "Password must be at least 8 characters long";
        }

        // Validate Confirm Password
        $confirm_password = $_POST['confirm_password'];
        if (empty($confirm_password)) {
            $errors['confirm_password'] = "Confirm password is required";
        } elseif ($password !== $confirm_password) {
            $errors['confirm_password'] = "Passwords do not match";
        }

        // If there are no errors, proceed with registration
        if (empty($errors)) {
            // Check if the email is already registered
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $errors['email'] = "Email is already registered";
            } else {
                // Insert the new user into the database
                $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$fullname, $email, password_hash($password, PASSWORD_DEFAULT)]);
                $_SESSION['success'] = "Registration successful!";
                $response['success'] = true;
            }
        }

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }
    } elseif (isset($_POST['login'])) {
        // Validate Login Email
        $login_email = trim($_POST['login_email']);
        if (empty($login_email)) {
            $login_errors['login_email'] = "Email is required";
        } elseif (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
            $login_errors['login_email'] = "Invalid email format";
        }

        // Validate Login Password
        $login_password = $_POST['login_password'];
        if (empty($login_password)) {
            $login_errors['login_password'] = "Password is required";
        }

        // If there are no login errors, proceed with login
        if (empty($login_errors)) {
            // Check the user's credentials
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$login_email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($login_password, $user['password'])) {
                $_SESSION['success'] = "Login successful!";
                $response['success'] = true;
            } else {
                $login_errors['login'] = "Invalid email or password";
            }
        }

        if (!empty($login_errors)) {
            $response['errors'] = $login_errors;
        }
    }

//     // Return JSON response
//     header('Content-Type: application/json');
//     echo json_encode($response);
//     exit;
 }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <!-- Login Form -->
        <form id="loginForm" class="login-form" method="POST" action="">
            <h1>Login</h1>
            <div class="form-group">
                <label for="loginEmail">Email</label>
                <input type="email" id="loginEmail" name="login_email" placeholder="Enter your email" value="<?php echo isset($login_email) ? htmlspecialchars($login_email) : ''; ?>" required>
                <?php if (isset($login_errors['login_email'])): ?>
                    <p class='error'><?php echo $login_errors['login_email']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" name="login_password" placeholder="Enter your password" required>
                <?php if (isset($login_errors['login_password'])): ?>
                    <p class='error'><?php echo $login_errors['login_password']; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="login-btn" name="login">Login</button>
            <p class="register-link">Don't have an account? <a href="#" id="showRegister">Register</a></p>
        </form>

        <!-- Register Form -->
        <form id="registerForm" class="register-form" method="POST" action="" style="display: none;">
            <h1>Register</h1>
            <div class="form-group">
                <label for="registerName">Full Name</label>
                <input type="text" id="registerName" name="fullname" placeholder="Enter your full name" value="<?php echo isset($fullname) ? htmlspecialchars($fullname) : ''; ?>" required>
                <?php if (isset($errors['fullname'])): ?>
                    <p class='error'><?php echo $errors['fullname']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="registerEmail">Email</label>
                <input type="email" id="registerEmail" name="email" placeholder="Enter your email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <p class='error'><?php echo $errors['email']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="registerPassword">Password</label>
                <input type="password" id="registerPassword" name="password" placeholder="Enter your password" required>
                <?php if (isset($errors['password'])): ?>
                    <p class='error'><?php echo $errors['password']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required>
                <?php if (isset($errors['confirm_password'])): ?>
                    <p class='error'><?php echo $errors['confirm_password']; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="login-btn" name="register">Register</button>
            <p class="register-link">Already have an account? <a href="#" id="showLogin">Login</a></p>
            <?php if (isset($_SESSION['success'])): ?>
                <p class='success'><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
            <?php endif; ?>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>