<?php
// Common helper functions

function is_logged_in() {
    session_start();
    return isset($_SESSION['student_id']);
}

function require_login() {
    session_start();
    if (!isset($_SESSION['student_id'])) {
        header('Location: login.php');
        exit();
    }
}
?>