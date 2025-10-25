<?php
session_start();
if(isset($_SESSION['admin_id'])){
  header("Location: admin/admin_dashboard.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login - Student Mental Health System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #e9f1ff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: Arial, sans-serif;
    }
    .login-box {
      width: 380px;
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

<div class="login-box">
  <h3 class="text-center mb-3">Admin Login</h3>
  <form action="admin_login_process.php" method="POST">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <button class="btn btn-primary w-100">Login</button>
  </form>
</div>

</body>
</html>
