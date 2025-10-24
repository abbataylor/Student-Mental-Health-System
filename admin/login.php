<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../includes/config.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = mysqli_prepare($conn, 'SELECT id, password FROM admins WHERE username = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res && mysqli_num_rows($res) === 1) {
        $admin = mysqli_fetch_assoc($res);
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Invalid credentials.';
        }
    } else {
        $error = 'Invalid credentials.';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <title>Admin Login</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
<div class='container py-5'>
  <div class='row justify-content-center'>
    <div class='col-md-5'>
      <div class='card p-4'>
        <h3 class='mb-3'>Admin Login</h3>
        <?php if (!empty($error)): ?><div class='alert alert-danger'><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <form method='POST' action='login.php'>
          <div class='mb-3'><label class='form-label'>Username</label><input name='username' class='form-control' required></div>
          <div class='mb-3'><label class='form-label'>Password</label><input name='password' type='password' class='form-control' required></div>
          <button class='btn btn-primary w-100'>Login</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
