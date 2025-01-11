<?php
session_start();
require 'db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle login
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        $email = trim($_POST['email']);
        $password = trim($_POST['pwd']);

        if (empty($email) || empty($password)) {
            $errors['login'] = 'Email and Password are required.';
        } else {
            $password_hash = md5($password); // Replace with password_hash in production
            $stmt = $pdo->prepare("
                SELECT * 
                FROM (
                    SELECT u_id AS id, 'USER' AS role, email, hashpassword FROM User
                    UNION ALL
                    SELECT a_id AS id, 'ADMIN' AS role, email, hashpassword FROM Admin
                ) AS all_users
                WHERE email = :email AND hashpassword = :password
            ");
            $stmt->execute(['email' => $email, 'password' => $password_hash]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['email'] = $user['email'];
                $_SESSION['password'] = $user['hashpassword'];
                header("Location: dashboard/{$user['role']}_dashboard.php");
                exit;
            } else {
                $errors['login'] = 'Invalid email or password.';
            }
        }
    }

    // Handle registration
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        $name = trim($_POST['rname']);
        $surname = trim($_POST['rsurname']);
        $phone = trim($_POST['rphone']);
        $email = trim($_POST['remail']);
        $password = trim($_POST['rpassword']);

        // Validation rules
        if (empty($name) || empty($surname) || empty($phone) || empty($email) || empty($password)) {
            $errors['register'] = 'All fields are required.';
        } elseif (strlen($password) < 8) {
            $errors['register'] = 'Password must be at least 8 characters long.';
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors['register'] = 'Name must not contain numbers.';
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $surname)) {
            $errors['register'] = 'Surname must not contain numbers.';
        } elseif (!preg_match("/^9\d{9}$/", $phone)) {
            $errors['register'] = 'Phone number must be exactly 10 digits and start with 9.';
        } else {
            // If all validations pass, proceed to register the user
            $password_hash = md5($password); // Replace with password_hash in production
            $stmt = $pdo->prepare("
                INSERT INTO User (first_name, last_name, ph_no, email, hashpassword)
                VALUES (:name, :surname, :phone, :email, :password)
            ");
            $stmt->execute([
                'name' => $name,
                'surname' => $surname,
                'phone' => $phone,
                'email' => $email,
                'password' => $password_hash,
            ]);
            header('Location: index.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="styles.css">
   <title>Responsive login & Registration Form</title>
</head>

<body>

   <!-- Error Messages -->
   <?php if (!empty($errors)): ?>
       <div class="error-messages">
           <?php foreach ($errors as $error): ?>
               <p class="error"><?php echo htmlspecialchars($error); ?></p>
           <?php endforeach; ?>
       </div>
   <?php endif; ?>

   <!-- LOGIN -->
   <div class="login container grid" id="loginAccessRegister">
      <div class="login__access">
         <h1 class="login__title">Log in.</h1>

         <div class="login__area">
         <form action="" method="POST" class="login__form">
               <input type="hidden" name="action" value="login">
               <div class="login__content grid">
                  <div class="login__box">
                     <input type="email" id="email" required placeholder=" " class="login__input" name="email">
                     <label for="email" class="login__label">Email</label>
                  </div>

                  <div class="login__box">
                     <input type="password" id="password" required placeholder=" " class="login__input" name="pwd">
                     <label for="password" class="login__label">Password</label>
                  </div>
               </div>

               <a href="#" class="login__forgot">Forgot your password?</a>

               <input type="submit" class="login__button" value="Login">
            </form>

            <div class="login__social">
               <p class="login__social-title">Or login with</p>

               <div class="login__social-links">
                  <a href="#" class="login__social-link">
                     <i class='bx bxl-google'></i>
                  </a>

                  <a href="#" class="login__social-link">
                     <i class='bx bxl-facebook-circle'></i>
                  </a>

                  <a href="#" class="login__social-link">
                     <i class='bx bxl-github'></i>
                  </a>
               </div>
            </div>

            <p class="login__switch">
               Don't have an account?
               <button id="loginButtonRegister">Register</button>
            </p>
         </div>
      </div>

      <!--REGISTER-->
      <div class="login__register">
         <h1 class="login__title">Register!</h1>

         <div class="login__area">
            <form action="" method="POST" class="login__form">
               <input type="hidden" name="action" value="register">
               <div class="login__content grid">
                  <div class="login__group grid">
                     <div class="login__box">
                        <input type="text" id="names" required placeholder=" " class="login__input" name="rname">
                        <label for="names" class="login__label">Name</label>
                     </div>

                     <div class="login__box">
                        <input type="text" id="surnames" required placeholder=" " class="login__input" name="rsurname">
                        <label for="surnames" class="login__label">Surname</label>
                     </div>
                  </div>

                  <div class="login__box">
                     <input type="number" id="phone" required placeholder=" " class="login__input" name="rphone">
                     <label for="phone" class="login__label">Phone no.</label>
                  </div>

                  <div class="login__box">
                     <input type="email" id="emailCreate" required placeholder=" " class="login__input" name="remail">
                     <label for="emailCreate" class="login__label">Email</label>
                  </div>

                  <div class="login__box">
                     <input type="password" id="passwordCreate" required placeholder=" " class="login__input" name="rpassword">
                     <label for="passwordCreate" class="login__label">Password</label>
                  </div>
               </div>

               <input type="submit" class="login__button" value="Create account">
            </form>

            <p class="login__switch">
               Already have an account?
               <button id="loginButtonAccess">Log In</button>
            </p>
         </div>
      </div>
   </div>

   <script src="script.js"></script>
</body>

</html>