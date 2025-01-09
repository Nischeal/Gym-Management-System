<?php
session_start();
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if (isset($_POST['email']) && !empty($_POST['email'])&& trim($_POST['email'])) {
         $email = trim($_POST['email']);
         if (!preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/',$email)) {
            $err['email'] = 'Enter valid email';
         }
         }else {
            $err['email'] =  'Please enter email'; 
         }
      if (isset($_POST['pwd']) && !empty($_POST['pwd'])&& trim($_POST['pwd'])) {
         $pwd = trim($_POST['pwd']);
         }else {
            $err['pwd'] =  'Please enter password'; 
         }
         $password_hash = md5($pwd);
      
      if (count($error) == 0) {
         try{
            $connection = new mysqli('localhost','root','','gym_management_system'); //oop
            $sql = "insert into login(email,password_hash) values ('$email','$password_hash')";
            $connection->query($sql);

            $stmt = $pdo->prepare("SELECT * FROM LOGIN WHERE email = :email AND password_hash = :password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Store session variables
            $_SESSION['user_id'] = $user['ref_id'];
            $_SESSION['role'] = $user['user_role'];

            // Redirect based on user role
            if ($user['user_role'] == 'USER') {
                header('Location: user_dashboard.php');
            } elseif ($user['user_role'] == 'TRAINER') {
                header('Location: trainer_dashboard.php');
            } elseif ($user['user_role'] == 'ADMIN') {
                header('Location: admin_dashboard.php');
            }
            exit;
        } else {
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        echo "An error occurred: " . $e->getMessage();
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

      <!-- LOGIN -->
      <div class="login container grid" id="loginAccessRegister">
         <div class="login__access">
            <h1 class="login__title">Log in.</h1>
            
            <div class="login__area">
               <form action="" class="login__form">
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
         
                  <button type="submit" class="login__button">Login</button>
               </form>
      
               <div class="login__social">
                  <p class="login__social-title">Or login with</p>
      
                  <div class="login__social-links">
                     <a href="#" class="login__social-link">
                        <i class='bx bxl-google'></i>
                     </a>
      
                     <a href="#" class="login__social-link">
                        <i class='bx bxl-facebook-circle' ></i>
                     </a>
      
                     <a href="#" class="login__social-link">
                        <i class='bx bxl-github' ></i>
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
               <form action="" class="login__form">
                  <div class="login__content grid">
                     <div class="login__group grid">
                        <div class="login__box">
                           <input type="text" id="names" required placeholder=" " class="login__input">
                           <label for="names" class="login__label">Name</label>
                        </div>
      
                        <div class="login__box">
                           <input type="text" id="surnames" required placeholder=" " class="login__input">
                           <label for="surnames" class="login__label">Surname</label>
                        </div>
                     </div>
                        
                     <div class="login__box">
                           <input type="number" id="phone" required placeholder=" " class="login__input">
                           <label for="Phone no." class="login__label">Phone no.</label>
                        
                     </div>
   
                     <div class="login__box">
                        <input type="email" id="emailCreate" required placeholder=" " class="login__input">
                        <label for="emailCreate" class="login__label">Email</label>
   
                        
                     </div>
   
                     <div class="login__box">
                        <input type="password" id="passwordCreate" required placeholder=" " class="login__input">
                        <label for="passwordCreate" class="login__label">Password</label>
   
                       
                     </div>
                  </div>
   
                  <button type="submit" class="login__button">Create account</button>
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