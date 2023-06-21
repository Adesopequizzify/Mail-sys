<?php
session_start();

// Unset all of the session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the login page or another desired location
header("Location: login.php");
exit();
?>
