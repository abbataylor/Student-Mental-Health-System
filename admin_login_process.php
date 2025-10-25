<?php
session_start();
require_once "includes/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($admin_id, $hashed_pass);
        $stmt->fetch();

        if (password_verify($password, $hashed_pass)) {
            $_SESSION['admin_id'] = $admin_id;
            header("Location: admin/admin_dashboard.php");
            exit();
        }
    }

    echo "<script>alert('Invalid username or password'); window.location='admin_login.php';</script>";
}
?>
