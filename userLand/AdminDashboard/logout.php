<?php
session_start();

session_unset();

session_destroy();

// print_r($_SESSION); // Should be empty

header('Location: ../Form/login.php ')
?>