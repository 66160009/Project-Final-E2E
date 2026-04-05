<?php
session_start();

// BUG 38: Session not properly destroyed - only unsets variables
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['role']);
unset($_SESSION['full_name']);

// Should use: session_destroy();

header('Location: login.php');
exit();
?>
