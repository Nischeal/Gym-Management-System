<?php
session_start();
include 'db.php';


// if (!isset($_SESSION['log'])) {
//     echo "<script>alert('Login Required');</script>";
//     echo '<meta http-equiv="refresh" content="0; url=../Form/login.php"/>';
//     exit();
// }

$userLoggedIn = fetchUserById($pdo, $_SESSION['u_id']);

$isAdmin = $userLoggedIn['role'] === 'admin';

// Fetch data based on role
if ($isAdmin) {
    $users = fetchUsers($pdo);
    $trainers = fetchTrainers($pdo);
    $memberships = fetchMemberships($pdo);
    $dashboardStats = fetchDashboardStats($pdo);
}else {
    $users = [];
    $trainers = [];
    $memberships = [];
    $dashboardStats = [];
}

function fetchUserById($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE u_id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        error_log("fetchUserById: No user found for u_id = " . $userId);
    }
    
    return $user;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym_management_system";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}



// $sql = "SELECT * FROM members WHERE u_id =$userid";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
// }

// fetch members
$sql = "SELECT u.u_id, u.fullname, u.email, m.duration, m.m_type 
        FROM members m
        JOIN users u ON m.u_id = u.u_id
        WHERE m.enrolled_at IS NOT NULL"; // Ensure the user has enrolled in a membership

$result = $conn->query($sql); // Execute the query

if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
     }

// validation part
if (isset($_POST['updateUser'])) {
    // $uid = $_POST['u_id'];
    $name = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $DOB = $_POST['dob'];
    // $status = $_POST['status'];
    $fullname = $address = $phone = $dob = $status = '';
    $errors = [];
}

     if (isset($_POST['updateUser'])) {
        // Validate Full Name
        $fullname = trim($_POST['fullname']);
        if (empty($fullname)) {
            $errors['fullname'] = "Full Name is required.";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
            $errors['fullname'] = "Full Name can only contain letters and white spaces.";
        }

        // Validate Address
        $address = trim($_POST['address']);
        if (empty($address))
            $errors['address'] = "Address is required.";

        // Validate Phone Number
        $phone = trim($_POST['phone']);
        if (empty($phone)) {
            $errors['phone'] = "Phone Number is required.";
        } elseif (!preg_match("/^(98|97)\d{8}$/", $phone)) {
            $errors['phone'] = "Phone Number must be 10 digits and start with 98 or 97.";
        }

        // Validate Date of Birth
        $dob = trim($_POST['dob']);
        if (empty($dob)) {
            $errors['dob'] = "Date of Birth is required.";
        } else {
            $today = new DateTime();
            $birthdate = new DateTime($dob);
            $age = $today->diff($birthdate)->y;

            if ($age < 13) {
                $errors['dob'] = "You must be at least 13 years old.";
            }
        }

        // Validate Status
        // $status = trim($_POST['status']);
        // if (empty($status)) {
        //     $errors['status'] = "Status is required.";
        // }

        // If there are no errors, update the user's information in the database
        if (empty($errors)) {
            $userid = $_SESSION['u_id'];
            $query = "UPDATE users SET fullname = ?, address = ?, ph_no = ?, DOB = ?, Status = ? WHERE u_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssi", $fullname, $address, $phone, $dob, $status, $userid);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Your profile has been updated successfully!";
                header("Location: index.php");
                exit;
            } else {
                $errors['database'] = "Failed to update profile. Please try again.";
            }
        }
    }
    // Fetch users with their membership type
    $sql = "SELECT u.u_id, u.fullname, u.address, u.ph_no, u.role, u.t_id, u.Status, m.m_type, m.enrolled_at 
    FROM users u
    LEFT JOIN members m ON u.u_id = m.u_id
    ORDER BY m.enrolled_at DESC"; // Order by enrollment date to get the newest members first
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
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
    <title>Dashboard</title>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <i class='bx bx-dumbbell' ></i>
            <div class="logo-name"><span>Gym</span>Hero</div>
        </a>
        <ul class="side-menu">
            <li class="active" onclick="loadContent('dashboard')"><span><i class='bx bxs-dashboard'></i>Dashboard</span></li>
            <li onclick="loadContent('users')"><span><i class='bx bxs-user-rectangle'></i>Users</span></li>
            <li  onclick="loadContent('trainer')"><span><i class='bx bx-cycling'></i>Trainers</span></li>
            <li  onclick="loadContent('memberships')"><span><i class='bx bxs-id-card'></i>Memberships</span></li>
            <li  onclick="loadContent('profile')"><span><i class='bx bxs-id-card'></i>profile</span></li>
            
        </ul>
        <ul class="side-menu">
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <!-- <nav>
            
        </nav> -->
        <!-- End of Navbar -->

        <main class="main-content">
            <div id="dashboard" class="content-section">
                <!-- Dashboard -->
                <div class="header">
                    <div class="left">
                        <h1>Dashboard</h1>
                        <ul class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            /
                            <li><a href="#" class="active">Analytics</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Insights -->
                <ul class="insights">
                    <li>
                        <i class='bx bxs-user-account'></i>
                        <span class="info">
                            <h3><?php echo $dashboardStats['total_users']; ?></h3>
                            <p>Members</p>
                        </span>
                    </li>
                    <li>
                        <i class='bx bx-cycling'></i>
                        <span class="info">
                            <h3><?php echo $dashboardStats['t_id']; ?></h3>
                            <p>Trainers</p>
                        </span>
                    </li>
                    <li>
                    <i class='bx bxs-user-check'></i>
                        <span class="info">
                            <h3><?php echo $dashboardStats['eid']; ?></h3>
                            <p>Enrollments</p>
                        </span>
                    </li>
                    <li>
                    <i class='bx bx-money'></i>
                        <span class="info">
                            <h3>Rs.<?php echo intval($dashboardStats['amount']); ?></h3>
                            <p>Earnings</p>
                        </span>
                    </li>
                </ul>
                <!-- End of Insights -->

                <div class="bottom-data">
                    <div class="orders">
                        <div class="header">
                            <i class='bx bx-receipt'></i>
                            <h3>New Members</h3>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Join Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php
            $n = 0;
            foreach ($users as $user): 
                if (!empty($user['enrolled_at'])): // Only show users with an enrollment date
                    $n++;
                    ?>
                    <tr>
                        <td>
                            <p><?php echo htmlspecialchars($user['fullname']); ?></p>
                        </td>
                        <td><?php echo htmlspecialchars($user['enrolled_at']); ?></td>
                    </tr>
                    <?php
                    if ($n == 3) break; // Limit to 3 new members
                endif;
            endforeach; 
            ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Active Members -->
                    <div class="active-users">
                        <div class="header">
                            <i class='bx bx-note'></i>
                            <h3>Active Users</h3>
                        </div>
                        <ul class="task-list">
                            <?php  $n=0; foreach ($users as $user): $n++; 
                                 if($user['Status'] === 'active'){

                                 ?>
                                
                                <li class="<?php echo $user['Status'] === 'active' ? 'active-list' : 'not-active-list'; ?>">
                                    <div class="task-title">
                                        <p><?php
                                         echo $user['fullname']; ?></p>
                                    </div>
                                </li>
                            <?php }if($n == 5)
                        break;  endforeach; ?>
                        </ul>
                    </div>
                    <!-- End of Active Members -->

                </div>
            </div>

            <!-- Users -->
            <div id="users" class="content-section" style="display: none;">
                <div class="header">
                    <div class="left">
                        <h1>Users</h1>
                        <ul class="breadcrumb">
                            <li><a href="index.html">Dashboard</a></li>
                            /
                            <li><a href="#" class="active">Users</a></li>
                        </ul>
                    </div>
                    <!-- <a href="add_user.php" class="report">
                        <i class='bx bx-user-plus'></i>
                        <span>Add User</span>
                    </a> -->
                </div>

                <div class="bottom-data">
                    <div class="table-list">
                        <div class="header">
                            <i class='bx bx-group'></i>
                            <h3>User List</h3>
                            <!-- <i class='bx bx-filter'></i>
                            <i class='bx bx-search'></i> -->
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Membership</th>
                                    <th>Trainer</th>
                                    <th>Role</th>
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        
                                        <td data-label="Name"><?php echo $user['fullname']; ?></td>
                                        <td data-label="Address"><?php echo $user['address']; ?></td>
                                        <td data-label="Phone"><?php echo ($user['ph_no']); ?></td>
                                        <td data-label="MembershipLeft"><?php echo $user['m_type']; ?></td>
                                        
                                        
                                        <td data-label="trainer"><?php echo fetchTrainerName($trainers, $user['t_id']); ?></td>
                                        <td data-label="role"><?php echo ($user['role']); ?></td>
                                       
                                        <td data-label="Action">
                                            <!-- <button class="edit-btn">Edit</button> -->
                                            <a href="allocate.php?u_id=<?php echo urlencode($user['u_id']); ?>"><button class="edit-btn" >Allocate</button></a>
                                            <a href="delete.php?u_id=<?php echo $user['u_id']?>" id=""><button class="delete-btn">Delete</button></a>
                                            <a href="update_role.php?u_id=<?php echo $user['u_id']?>" ><button class="edit-btn">Make Admin</button></a>
                                            
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Trainers -->
            <div id="trainer" class="content-section" style="display: none;">
                <div class="header">
                    <div class="left">
                        <h1>Trainers</h1>
                        <ul class="breadcrumb">
                            <li><a href="index.html">Dashboard</a></li>
                            /
                            <li><a href="#" class="active">Trainers</a></li>
                        </ul>
                    </div>
                    <a href="add_trainer.php" class="report">
                        <i class='bx bx-user-plus'></i>
                        <span>Add Trainer</span>
                    </a>
                </div>

                <div class="bottom-data">
                    <div class="table-list">
                        <div class="header">
                            <i class='bx bx-dumbbell'></i>
                            <h3>Trainer List</h3>
                            <!-- <i class='bx bx-filter'></i>
                            <i class='bx bx-search'></i> -->
                        </div>
                        <table>
                            <thead>
                                <tr>
                                   
                                    <th>Name</th>
                                    
                                    <th>Specialty</th>
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($trainers as $trainer): ?>
                                    <tr>
                                        
                                        <td><?php echo $trainer['fullname']; ?></td>
                                        
                                        <td><?php echo $trainer['speciality']; ?></td>
                                        
                                        <td>
                                            <!-- <button class="edit-btn">Edit</button> -->
                                            
                                            <a href="deleteTrainer.php?t_id=<?php echo $trainer['t_id']?>" ><button class="delete-btn">Delete</button></a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Memberships -->
            <div id="memberships" class="content-section" style="display: none;">
                <div class="header">
                    <div class="left">
                        <h1>Memberships</h1>
                        <ul class="breadcrumb">
                            <li><a href="index.html">Dashboard</a></li>
                            /
                            <li><a href="#" class="active">Memberships</a></li>
                        </ul>
                    </div>
                    <a href="add_membership.php" class="report add-membership-btn">
                        <i class='bx bx-plus-circle'></i>
                        <span>Add Membership</span>
                    </a>
                </div>

                <div class="bottom-data">
                    <div class="table-list">
                        <div class="header">
                            <i class='bx bx-list-ul'></i>
                            <h3>Membership Plans</h3>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Membership Name</th>
                                    <th>Price</th>
                                    <th>Plans</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($memberships as $membership): ?>
                                    <tr>
                                        <td><?php echo $membership['name']; ?></td>
                                        <td>Rs.<?php echo $membership['amount']; ?></td>
                                        <td>
                                            <ul>
                                                <li><?php echo $membership['m_type']; ?></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <!-- <button class="edit-btn">Edit</button> -->
                                            
                                           
                                            <a href="deleteMembership.php?m_id=<?php echo $membership['m_id']?>" ><button class="delete-btn">Delete</button></a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="profile" class="content-section" style="display: none;">
                <div class="header">
                    <div class="left">
                    <h2 class="section-title">Settings</h2>
                    <form action="" method="POST" id="settingForm" novalidate>
                    <label for="fullname" class="settings__label">Full Name</label>
                    <div class="settings__box">
                        <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($userLoggedIn['fullname']); ?>" class="settings__input" placeholder="Fullname">
                        <?php if (isset($errors['fullname'])): ?>
                            <span class="error"><?php echo $errors['fullname']; ?></span>
                        <?php endif; ?>
                    </div>
                    <label for="address" class="settings__label">Address</label>
                    <div class="settings__box">
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($userLoggedIn['address']); ?>" class="settings__input" placeholder="Address">
                        <?php if (isset($errors['address'])): ?>
                            <span class="error"><?php echo $errors['address']; ?></span>
                        <?php endif; ?>
                    </div>
                    <label for="phone" class="settings__label">Phone</label>
                    <div class="settings__box">
                        <input type="number" id="phone" name="phone" value="<?php echo htmlspecialchars($userLoggedIn['ph_no']); ?>" class="settings__input" placeholder="Phone">
                        <?php if (isset($errors['phone'])): ?>
                            <span class="error"><?php echo $errors['phone']; ?></span>
                        <?php endif; ?>
                    </div>
                    <label for="dob" class="settings__label">Date of Birth</label>
                    <div class="settings__box">
                        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($userLoggedIn['u_id']); ?>" class="settings__input" placeholder="DOB">
                        <?php if (isset($errors['dob'])): ?>
                            <span class="error"><?php echo $errors['dob']; ?></span>
                        <?php endif; ?>
                    </div>
                    <!-- <label for="status" class="settings__label">status</label>
                    <div class="settings__box">
                        <select name="status" id="status">
                            <option value="active">Active</option>
                            <option value="inactive">in active</option>
                        </select>
                    </div> -->
                    <button type="submit" name="updateUser" class="settings__submit-btn">Save</button>
                </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="index.js"></script>
</body>
</html>