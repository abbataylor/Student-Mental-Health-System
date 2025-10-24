<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/config.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email === '' || $password === '') {
        $error = 'Please enter email and password.';
    } else {
        $stmt = mysqli_prepare($conn, 'SELECT id, name, password FROM students WHERE email = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && mysqli_num_rows($res) === 1) {
            $user = mysqli_fetch_assoc($res);
            if (password_verify($password, $user['password'])) {
                // login success
                $_SESSION['student_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                header('Location: dashboard.php');
                exit();
            } else {
                $error = 'Invalid credentials.';
            }
        } else {
            $error = 'Invalid credentials.';
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <title>Login - Student Mental Health System</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
<div class='container py-5'>
  <div class='row justify-content-center'>
    <div class='col-md-5'>
      <div class='card p-4'>
        <h3 class='mb-3'>Student Login</h3>
        <?php if (!empty($error)): ?>
          <div class='alert alert-danger'><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action='login.php' method='POST' class='row g-3'>
          <div class='col-12'>
            <label class='form-label'>Email</label>
            <input name='email' type='email' class='form-control' required>
          </div>
          <div class='col-12'>
            <label class='form-label'>Password</label>
            <input name='password' type='password' class='form-control' required>
          </div>
          <div class='col-12'>
            <button class='btn btn-primary w-100' type='submit'>Login</button>
          </div>
          <div class='col-12 text-center'>
            <small>No account? <a href='register.php'>Create one</a></small>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
