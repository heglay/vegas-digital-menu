<?php
// Vegas Digital Menu - Admin Logout
session_start();

// Destroy all session data
$_SESSION = [];

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

session_destroy();

// Redirect to login page
header('Location: /painel/login.php');
exit;
?>
