<?php
session_start();

session_unset();

session_destroy();

header('Location: ../Form/login.php ')
?>