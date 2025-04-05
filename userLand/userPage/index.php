<?php
session_start();
require('db.php');

        
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gym_management_system";
            
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection Failed: " .$conn->connect_error);
            } 

            if (!isset($_SESSION['log'])) {
                echo "<script>alert('Login Required');</script>";
                echo '<meta http-equiv="refresh" content="0; url=../Form/login.php"/>';
                exit();
            }



$memberships = fetchMemberships($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $email = $_POST['email'] ?? '';  // Use null coalescing to avoid warnings
    $password = $_POST['password'] ?? '';

    $users = fetchUserByEmail($pdo, $email, $password);
    

 
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $stmt->execute(['email' => $email, 'password' => md5($password)]); // Consider using password_hash() for better security

    $users = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($users) {
        $_SESSION['u_id'] = $users['u_id'];
        
        header("Location: db.php");
        exit;
    }
    // } else {
    //     echo "Invalid email or password.";
    // }
}
// $stmt = $conn->prepare("SELECT  amount, enrolled_at, duration FROM members WHERE u_id = ?");
// $stmt->bind_param("i", $u_id);
// $stmt->execute();
// $result = $stmt->get_result();

// $membershipInfo = $result->fetch_assoc();

// if ($membershipInfo) {
//     // Calculate remaining days based on the 'enroll_at' and 'duration'
//     $enrolled_date = strtotime($membershipInfo['enrolled_at']);
//     $duration = $membershipInfo['duration']; // Assuming duration is in days
//     $expiry_date = strtotime("+$duration days", $enrolled_date);
//     $remaining_days = max(0, ceil(($expiry_date - time()) / (60 * 60 * 24))); // Calculate remaining days
//     $membershipInfo['remaining_days'] = $remaining_days; // Add remaining days to membership info
// } else {
//     $membershipInfo = null;
// }

// if ($stmt->num_rows > 0) {
//     $stmt->bind_result($enrolled_at, $duration);
//     $stmt->fetch();

//     // Calculate expiry date
//     $enrolledDate = new DateTime($enrolled_at);
//     $expiryDate = clone $enrolledDate;
//     $expiryDate->modify("+$duration days");
//     $today = new DateTime();
    
//     // Calculate remaining days
//     $remainingDays = $today < $expiryDate ? $today->diff($expiryDate)->days : 0;
// }

$stmt = $conn->prepare("SELECT  amount, enrolled_at, duration FROM members WHERE u_id = ?");
$stmt->bind_param("i", $u_id);
$stmt->execute();
$result = $stmt->get_result();
$membershipInfo = $result->fetch_assoc();


$userid = $_SESSION['u_id'];
$stmt = $conn->prepare("SELECT amount, enrolled_at, duration FROM members WHERE u_id = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$membershipInfo = $result->fetch_assoc();

if ($membershipInfo) {
    $enroll_date = strtotime($membershipInfo['enrolled_at']);
    $duration = $membershipInfo['duration']; 
    $expiry_date = strtotime("+$duration days", $enroll_date);
    $remaining_days = max(0, floor(($expiry_date - time()) / (60 * 60 * 24)));  
    $membershipInfo['remaining_days'] = $remaining_days; 
}

// Fetch membership plans
$stmt = $conn->prepare("SELECT * FROM memberships");
$stmt->execute();
$memberships = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);



// Delete expired memberships
$current_date = date('Y-m-d H:i:s');
$stmt = $conn->prepare("
    DELETE FROM members
    WHERE DATE_ADD(enrolled_at, INTERVAL duration DAY) < ?
");
$stmt->bind_param("s", $current_date);
$stmt->execute();

$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Landing</title>
</head>

<body onload="loadContent('profile')">
    <header>
        <nav>
            <a href="#" class="logo">
                <i class='bx bx-dumbbell'></i>
                <div class="logo-name"><span>Gym</span>Hero</div>
            </a>

            <ul class="nav-links">
                <li onclick="loadContent('profile')"><span>Profile</span></li>
                <li onclick="loadContent('plan')"><span>Plans & pricing</span></li>
                <li onclick="loadContent('aboutUs')"><span>About us</span></li>
                <li onclick="loadContent('Contact')"><span>Contact</span></li>
                <li onclick="loadContent('settings')"><span>Settings</span></li>
            </ul>

            <a href="logout.php" class="Sign-in">Log out</a>
            <!-- <form action="#">
                <div class="form-input">
                    
                    <a href="./form/login.php#registerForm" class="register-nav">Register</a>
                </div>
            </form> -->
            <!-- <a href="#" class="notif">
                <i class='bx bx-bell'></i>
            </a> -->
            <!-- <a href="#" class="profile">
                <img src="images/GYMBG.jpg" alt="Profile">
            </a> -->
        </nav>
    </header>

<main class="main-container main-content">
        <!-- profile  Section -->
<div id="profile" class="content-section">

<?php 
$userid =  $_SESSION['u_id'];
$sql="SELECT * FROM users WHERE u_id =$userid";
$result = $conn->query($sql);
if($result->num_rows > 0){
    $row = $result->fetch_assoc();
}

?>
    <div class="profile-container">
        <h2 class="section-title">User  Profile</h2>
        <div class="profile-info">
            <div class="info-item">
            <p><strong>Full name:</strong> <?php echo isset($row['fullname']) ? htmlspecialchars($row['fullname']) : 'N/A'; ?></p>
            </div>
            <div class="info-item">
                <p><strong>Address:</strong> <?php echo isset($row['address']) ? htmlspecialchars($row['address']) : 'N/A'; ?></p>
            </div>
            <div class="info-item">
            <p><strong>Date of Birth:</strong> <?php echo isset($row['DOB']) ? htmlspecialchars($row['DOB']) : 'N/A'; ?></p>
            </div>
            <div class="info-item">
            <p><strong>Phone no.:</strong> <?php echo isset($row['ph_no']) ? htmlspecialchars($row['ph_no']) : 'N/A'; ?></p>
            </div>
            <div class="info-item">
                <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
            </div>
            <div class="info-item">
               <p> <strong>Status:</strong> <?php echo htmlspecialchars($row['Status']); ?></p>
            </div>
            <div class="info-item">
            <p><strong>Membership: </strong><?php echo htmlspecialchars($m_type); ?></p>
            </div>
        </div>
    </div>
</div>



<!-- membership section after enroll -->
<div id="plan" class="content-section" style="display: none;">
<div class="pricing-section" class="content-section" style="display: block;">

            
<?php if ($membershipInfo && $membershipInfo['remaining_days'] > 0): ?>
    <!-- Membership Plan Section (User is enrolled and membership is active) -->
    <div class="membership-plan">
        <h2>Your Membership Plan</h2>
        <p><strong>Amount:</strong> Rs. <?php echo htmlspecialchars($membershipInfo['amount']); ?></p>
        <p><strong>Remaining Days:</strong> <?php echo $membershipInfo['remaining_days']; ?> days</p>
    </div>
<?php else: ?>
    <!-- Pricing Section (User not enrolled or membership has expired) -->
    <div id="plan" class="content-section" style="display: block;">
        <div class="container">
            <h2 class="plans-title">CHOOSE YOUR MEMBERSHIP PLAN</h2>
            <div class="plans">
                <?php foreach ($memberships as $membership) : ?>
                    <div class="plan">
                        <h2><?php echo htmlspecialchars($membership['m_type']); ?></h2>
                        <input type="hidden" name="duration" value="<?php echo $membership['duration']; ?>">
                        <div class="price">Rs. <?php echo htmlspecialchars($membership['amount']); ?></div>
                        <div class="features">
                            <ul>
                                <?php
                                $features = explode(',', $membership['features']);
                                foreach ($features as $feature) :
                                ?>
                                    <li><?php echo htmlspecialchars(trim($feature)); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <a href="enroll.php?m_id=<?php echo $membership['m_id']; ?>&m_type=<?php echo $membership['m_type']; ?>&amount=<?php echo $membership['amount']; ?>&duration=<?php echo $membership['duration']; ?>" class="enroll-button">ENROLL NOW</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>
</div>


        <!-- About Us Section -->
        <div id="aboutUs" class="content-section" style="display: none;">
            <div class="about-section">
                <div class="about-container">
                    <h2 class="section-title">About Us</h2>
                    <div class="about-content">
                        <!-- <div class="about-image">
                            <img src="./images/gym-interior.jpg" alt="Gym Interior">
                        </div> -->
                        <div class="about-text">
                            <h3>Welcome to GymHero</h3>
                            <p>Your premier fitness destination where strength meets transformation.</p>
                            
                            <div class="features-grid">
                                <div class="feature">
                                    <i class='bx bx-dumbbell'></i>
                                    <h4>State-of-the-Art Equipment</h4>
                                    <p>Access to premium fitness equipment and modern facilities</p>
                                </div>
                                <div class="feature">
                                    <i class='bx bx-user'></i>
                                    <h4>Expert Trainers</h4>
                                    <p>Certified professional trainers to guide your fitness journey</p>
                                </div>
                                <div class="feature">
                                    <i class='bx bx-time'></i>
                                    <h4>Flexible Hours</h4>
                                    <p>Open 24/7 to fit your schedule</p>
                                </div>
                                <div class="feature">
                                    <i class='bx bx-group'></i>
                                    <h4>Community Focus</h4>
                                    <p>Join a motivated community of fitness enthusiasts</p>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>

        <!-- contact Section -->
        
        <div id="Contact" class="content-section" style="display: none;">
            <div class="contact-container">
                <h2 class="section-title">Contact Us</h2>
                <div class="contact-content">
                    <div class="contact-info">
                        <div class="info-item">
                            <i class='bx bx-map'></i>
                            <h3>Location</h3>
                            <p>Satdobato, Lalitpur</p>
                            <p>Near swimming pool</p>
                        </div>
                        <div class="info-item">
                            <i class='bx bx-phone'></i>
                            <h3>Phone</h3>
                            <p>+9840312322</p>
                            <p>+9840322322</p>
                        </div>
                        <div class="info-item">
                            <i class='bx bx-envelope'></i>
                            <h3>Email</h3>
                            <p>gymhero@gmail.com</p>
                            <p>supportgymhero@hotmail.com</p>
                        </div>
                        <div class="info-item">
                            <i class='bx bx-time'></i>
                            <h3>Working Hours</h3>
                            <p>Monday - Friday: 5:00 AM - 08:00 PM</p>
                            <p>Saturday - Sunday: 6:00 AM - 07:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="contact-form">
                        <h3>Send us a Message</h3>
                        <form method="POST">
                            <div class="form-group">
                                <input type="text" name="fullname" placeholder="Your Name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Your Email" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" placeholder="Subject" required>
                            </div>
                            <div class="form-group">
                                <textarea  name="message" placeholder="Your Message" required></textarea>
                            </div>
                            <button type="submit" name="sendMessage" class="submit-btn">Send Message</button>
                            <?php include("contactUs.php"); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Section -->
        <div id="settings" class="content-section" style="display: none;">
            <?php 
        
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gym_management_system";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection Failed: " .$conn->connect_error);
            } 
            $userid =  $_SESSION['u_id'];
            $sql="SELECT * FROM users WHERE u_id =$userid";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
            }

          


            if (isset($_POST['updateUser'])) {
                $uid = $_SESSION['u_id'];
                $name = $_POST['fullname'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];
                
                


                $DOB = $_POST['dob'];
                $status = $_POST['status'];

                if (preg_match('/^(98|97)\d{8}$/', $phone)) {
                    
                    $query = "UPDATE `users` SET `fullname`='$name',`address`='$address',`DOB`='$DOB',`ph_no`='$phone',`Status`='$status' WHERE `u_id`=$uid";

                    if ($conn->query($query) === TRUE) {
                        echo "User updated successfully";
                        
                    } else {
                        echo "Error: " . $query . "<br>" . $conn->error;
                        }
                } else {
                    echo "Invalid phone number!";
                   
                }

                   
            }


        
            ?>
            <div class="settings-container" >
                <h2 class="section-title">Settings</h2>
                <form action="" method="POST" novalidate >
                    <label for="fullname" class="settings__label">Full Name</label>
                    <div class="settings__box">
                        <input type="text" id="fullname" name="fullname" value="<?php echo $row['fullname']; ?>" class="settings__input" placeholder="Fullname" >
                    </div>
                    <label for="address" class="settings__label">Address</label>
                    <div class="settings__box">
                        <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" class="settings__input" placeholder="Address" >
                    </div>
                    <label for="phone" class="settings__label">Phone</label>
                    <div class="settings__box">
                        <input type="number" id="phone" name="phone" value="<?php echo $row['ph_no']; ?>" class="settings__input" placeholder="Phone" >
                    </div>
                    <label for="dob" class="settings__label">Date of Birth</label>
                    <div class="settings__box">
                        <input type="date" id="dob" name="dob" value="<?php echo $row['DOB']; ?>" class="settings__input" placeholder="DOB" >
                    </div>
                    <label for="status" class="settings__label">status</label>
                    <div class="settings__box">
                        <select name="status" id="status" >
                            <option value="active">Active</option>
                            <option value="inactive">in active</option>
                        </select>
                    </div>
                    <button type="submit" name="updateUser" class="settings__submit-btn">Submit</button>
                </form>
            </div>
        </div>
</main>

    <script src="index.js"></script>
</body>

</html>
