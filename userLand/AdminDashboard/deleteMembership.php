<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gym_management_system";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection Failed: " .$conn->connect_error);
    } 
    if(isset($_GET['m_id'])){
        $membershipid = $_GET['m_id'];
        $sql="DELETE FROM memberships WHERE m_id =$membershipid";
        $result = $conn->query($sql);
        if($result == true){
            echo "<script>alert('deleted sucessfully')</script>";
            echo '<meta http-equiv = "refresh" content = "0; url = index.php"/>';
        }
    }
    ?>