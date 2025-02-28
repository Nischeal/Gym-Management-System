
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym_management_system";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection Failed: " .$conn->connect_error);
} 





// $userId = $_SESSION['user_id'];
if (isset($_POST['sendMessage'])) {

    // if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    //     echo "<script>alert('Login Required to send the message'); </script>";
    //     echo '<meta http-equiv = "refresh" content = "0; url = index.php"/>';
    //     // header("location: index.php");
    // } else {
        
    //     $userId = $_SESSION['user_id'];
        
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $errors = [];
        
        // Regular Expressions
        $fullnameRegex = "/^[A-Za-z]{3,16}( [A-Za-z]{3,16}){0,3}$/";
        $emailRegex = "/^[A-Za-z0-9]+(?:[.%_+][A-Za-z0-9]+)*@[A-Za-z0-9]+\.[A-Za-z]{2,}$/";
        
        
        // Fullname validation
        if (empty($fullname)) {
            $errors['user_error'] = "Name cannot be empty!";
        } elseif (!preg_match($fullnameRegex, $fullname)) {
            $errors['user_error'] = "Name Invalid!";
        }
        
        // Email validation
        if (!preg_match($emailRegex, $email)) {
            $errors['email_error'] = "Invalid Email! Enter a valid email address.";
        }
        
        if (empty($errors)) {
            $sql = "INSERT INTO `contactus`(`fullname`, `email`, `subject`, `message`) VALUES ('$fullname','$email','$subject','$message')";
            $result = $conn->query($sql);
            if ($result == true) {
                echo "<script>alert('Thank you for contacting us. We will respond to your message soon.')</script>";
                echo '<meta http-equiv = "refresh" content = "0; url = index.php"/>';
                exit();
            } else {
                echo "<script>alert('Error!, Failed to send message. Try again!');</script>";
            }
        }
    }
// }
?>