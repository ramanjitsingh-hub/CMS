<?php
// Start the session (if not already started)
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page after logout
header("Location:  ../pages/login/login.html");
exit;
?>
