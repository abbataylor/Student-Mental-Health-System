<?php
session_start();

// Remove only admin session values
unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);

session_write_close();

// Redirect back to admin login page
header("Location: ../admin_login.php");
exit();
