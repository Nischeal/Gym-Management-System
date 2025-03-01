<?php
session_start();
include 'db.php';
if(!isset($_SESSION['log'])){
    echo "<script>alert('Login Required')</script>";
  
    echo '<meta http-equiv = "refresh" content = "0; url = ../Form/login.php"/>';
}


// Fetch data
$users = fetchUsers($pdo);
$trainers = fetchTrainers($pdo);
$memberships = fetchMemberships($pdo);
$dashboardStats = fetchDashboardStats($pdo);

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
                            <p>Total Sales</p>
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
                                <?php $n=0; foreach ($users as $user): $n++; ?>
                                    <tr>
                                        <td>
                                            
                                            <p><?php echo $user['fullname']; ?></p>
                                        </td>
                                        <td><?php echo $user['date']; ?></td>
                                        
                                    </tr>
                                <?php if($n==3)
                            break; endforeach; ?>
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
                            <?php foreach ($users as $user):
                                if($user['Status'] === 'active'){

                                 ?>
                                <li class="<?php echo $user['Status'] === 'active' ? 'active-list' : 'not-active-list'; ?>">
                                    <div class="task-title">
                                        <p><?php
                                         echo $user['fullname']; ?></p>
                                    </div>
                                </li>
                            <?php } endforeach; ?>
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
                    <a href="add_user.php" class="report">
                        <i class='bx bx-user-plus'></i>
                        <span>Add User</span>
                    </a>
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
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        
                                        <td data-label="Name"><?php echo $user['fullname']; ?></td>
                                        <td data-label="Email"><?php echo $user['email']; ?></td>
                                        <td data-label="Role"><?php echo ucfirst($user['role']); ?></td>
                                        <td data-label="Status"><span class="status <?php echo $user['Status'] === 'active' ? 'active' : 'inactive'; ?>"><?php echo ucfirst($user['Status']); ?></span></td>
                                        <td data-label="Action">
                                            <!-- <button class="edit-btn">Edit</button> -->
                                            <button class="delete-btn">Delete</button>
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
                                            <button class="delete-btn">Delete</button>
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
                                            
                                            <button class="delete-btn">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="index.js"></script>
</body>
</html>