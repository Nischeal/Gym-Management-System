<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard</title>
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
            <li  onclick="loadContent('Settings')"><span><i class='bx bxs-cog' ></i> Settings</span></li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#" class="logout">
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
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
            
            <a href="#" class="notif">
                <i class='bx bx-bell'></i>
                <span class="count">8</span>
            </a>
            <a href="#" class="profile">
                <i class='bx bx-user'></i>
            </a>
        </nav>
        <!-- End of Navbar -->

        <main class="main-content">

        <div id="dashboard" class="content-section" >

            <!-- Dashboard -->
             
            <div class="header">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Dashboard
                            </a></li>
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
                        <h3>
                            1,074
                        </h3>
                        <p>Members</p>
                    </span>
                </li>
                <li><i class='bx bxs-show'></i></i>
                    <span class="info">
                        <h3>
                            3,944
                        </h3>
                        <p>Site Visit</p>
                    </span>
                </li>
                <li><i class='bx bxs-file-find'></i>
                    <span class="info">
                        <h3>
                            14,721
                        </h3>
                        <p>Searches</p>
                    </span>
                </li>
                <li><i class='bx bxs-dollar-circle'></i></i>
                    <span class="info">
                        <h3>
                            $6,742
                        </h3>
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
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="">
                                    <p>Sujal</p>
                                </td>
                                <td>14-08-2023</td>
                                <td><span class="status active-list">Completed</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="">
                                    <p>Nischal</p>
                                </td>
                                <td>14-08-2023</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="">
                                    <p>Ram</p>
                                </td>
                                <td>14-08-2023</td>
                                <td><span class="status process">Processing</span></td>
                            </tr>
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
                        <li class="active-list">
                            <div class="task-title">
                                <!-- <i class='bx bx-check-circle'></i> -->
                                <p>User1</p>
                            </div>
                            
                        </li>
                        <li class="active-list">
                            <div class="task-title">
                            
                                <p>User2</p>
                            </div>
                            
                        </li>
                        <li class="not-active-list">
                            <div class="task-title">
                                <p>User3</p>
                            </div>
                            
                        </li>
                    </ul>
                </div>

                <!-- End of Reminders-->

            </div>
        </div>
        
            <!-- users -->
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
                <a href="#" class="report">
                    <i class='bx bx-user-plus'></i>
                    <span>Add User</span>
                </a>
            </div>

            <div class="bottom-data">
                <div class="table-list">
                    <div class="header">
                        <i class='bx bx-group'></i>
                        <h3>User List</h3>
                        <i class='bx bx-filter'></i>
                        <i class='bx bx-search'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="Profile"><img src="" alt="User Profile"></td>
                                <td data-label="Name">Sujal Maharjan</td>
                                <td data-label="Email">Sujal@gmail.com</td>
                                <td data-label="Role">Admin</td>
                                <td data-label="Status"><span class="status active">Active</span></td>
                                <td data-label="Action">
                                    <button class="edit-btn">Edit</button>
                                    <button class="delete-btn">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Profile"><img src="" alt="User Profile"></td>
                                <td data-label="Name">Nischal Basnet</td>
                                <td data-label="Email">nischal@gmail.com</td>
                                <td data-label="Role">Trainer</td>
                                <td data-label="Status"><span class="status inactive">Inactive</span></td>
                                <td data-label="Action">
                                    <button class="edit-btn">Edit</button>
                                    <button class="delete-btn">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Profile"><img src="" alt="User Profile"></td>
                                <td data-label="Name">Sunil Chettri</td>
                                <td data-label="Email">sunil@gmail.com</td>
                                <td data-label="Role">Member</td>
                                <td data-label="Status"><span class="status active">Active</span></td>
                                <td data-label="Action">
                                    <button class="edit-btn">Edit</button>
                                    <button class="delete-btn">Delete</button>
                                </td>
                            </tr>
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
                <a href="#" class="report">
                    <i class='bx bx-user-plus'></i>
                    <span>Add Trainer</span>
                </a>
            </div>

            <div class="bottom-data">
                <div class="table-list">
                    <div class="header">
                        <i class='bx bx-dumbbell'></i>
                        <h3>Trainer List</h3>
                        <i class='bx bx-filter'></i>
                        <i class='bx bx-search'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Specialty</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="images/trainer-1.jpg" alt="Trainer Profile"></td>
                                <td>Sujal Maharjan</td>
                                <td>sujal@gmail.com</td>
                                <td>Strength Training</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <button class="edit-btn">Edit</button>
                                    <button class="delete-btn">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td><img src="images/trainer-2.jpg" alt="Trainer Profile"></td>
                                <td>Nischal Basnet</td>
                                <td>nischal@gmail.com</td>
                                <td>Yoga</td>
                                <td><span class="status inactive">Inactive</span></td>
                                <td>
                                    <button class="edit-btn">Edit</button>
                                    <button class="delete-btn">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td><img src="images/trainer-3.jpg" alt="Trainer Profile"></td>
                                <td>Ram KC</td>
                                <td>Ram@example.com</td>
                                <td>Cardio</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <button class="edit-btn">Edit</button>
                                    <button class="delete-btn">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>




        </div>
    

        <!-- membership -->
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
            <a href="#" class="report add-membership-btn">
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
                        <tr>
                            <td>Basic Plan</td>
                            <td>$29.99</td>
                            <td>
                                <ul>
                                    <li>Access to Gym</li>
                                    <li>2 Personal Training Sessions</li>
                                </ul>
                            </td>
                            <td>
                                <button class="edit-btn">Edit</button>
                                <button class="publish-btn">Publish</button>
                                <button class="delete-btn">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Premium Plan</td>
                            <td>$59.99</td>
                            <td>
                                <ul>
                                    <li>All Basic Features</li>
                                    <li>Unlimited Personal Training</li>
                                    <li>Nutrition Guidance</li>
                                </ul>
                            </td>
                            <td>
                                <button class="edit-btn">Edit</button>
                                <button class="publish-btn">Publish</button>
                                <button class="delete-btn">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>VIP Plan</td>
                            <td>$99.99</td>
                            <td>
                                <ul>
                                    <li>All Premium Features</li>
                                    <li>Access to VIP Lounge</li>
                                    <li>Priority Scheduling</li>
                                </ul>
                            </td>
                            <td>
                                <button class="edit-btn">Edit</button>
                                <button class="publish-btn">Publish</button>
                                <button class="delete-btn">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </main>


    <script src="index.js"></script>
</body>

</html>
