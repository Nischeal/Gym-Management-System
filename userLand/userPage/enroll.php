<?php
session_start();
include('db.php');
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

// user is logged in
if (!isset($_SESSION['u_id'])) {
    die("Error: You must be logged in to enroll.");
}

//  user details from session
$u_id = $_SESSION['u_id'];

$u_name = $_SESSION['fullname']; // Assuming you store the username in the session
// $amouont = $_SESSION['amount'];

// membership details from URL
$m_id = isset($_GET['m_id']) ? htmlspecialchars($_GET['m_id']) : 'N/A';
$m_type = isset($_GET['m_type']) ? htmlspecialchars($_GET['m_type']) : 'N/A';
$amount = isset($_GET['amount']) ? htmlspecialchars($_GET['amount']) : 'N/A';
$duration = isset($_GET['duration']) ? htmlspecialchars($_GET['duration']) : 'N/A';

$stmt = $conn->prepare("SELECT enrolled_at, duration FROM members WHERE u_id = ?");
$stmt->bind_param("i", $u_id);
$stmt->execute();
$stmt->store_result();



// added

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Membership</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(../images/image.jpg);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background-color: rgba(81, 81, 85, 0.226);
            
            width: 400px;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            backdrop-filter: blur(3px);
        }

        .card h2 {
            margin-bottom: 20px;
            color: white;
        }

        .card .detail {
            margin: 15px 0;
            padding: 10px;
            color: white;
            /* background-color: rgba(81, 81, 85, 0.226); */
            border-radius: 5px;
            text-align: left;
            display: flex;
            justify-content: space-between;
            /* backdrop-filter: blur(3px); */
        }

        .card .detail label {
            font-weight: bold;
        }

        .card .detail input {
            border: none;
            background: none;
            color: white;
            font-size: 16px;
            text-align: right;
        }

        .card button {
            background-color:rgb(33, 118, 230);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .card button:hover {
            background-color:rgb(38, 39, 38);
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Confirm Your Membership</h2>
    <form action="process_enrollment.php" method="post">
        <div class="detail">
            <label for="u_id">User ID:</label>
            <input type="text" id="u_id" name="u_id" value="<?php echo $u_id; ?>" readonly>
        </div>

        <div class="detail">
            <label for="u_name">Name:</label>
            <input type="text" id="u_name" name="u_name" value="<?php echo $u_name; ?>" readonly>
        </div>

        <div class="detail">
            <label for="m_type">Membership Type:</label>
            <input type="hidden" name="duration" value="<?php echo isset($_GET['duration']) ? $_GET['duration'] : 0; ?>">
            <input type="text" id="m_type" name="m_type" value="<?php echo $m_type; ?>" readonly>
        </div>

        <div class="detail">
            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" value="<?php echo $amount; ?>" readonly>
        </div>

        <!-- Hidden field for m_id -->
        <input type="hidden" name="m_id" value="<?php echo $m_id; ?>">
        
      
        <a href="/index.php"><button type="submit">Confirm Enrollment</button></a>
    </form>
</div>

</body>
</html>

