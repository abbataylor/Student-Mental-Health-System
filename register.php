<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $password === '') {
        $error = 'Please fill all fields.';
    } else {
        // check existing
        $stmt = mysqli_prepare($conn, 'SELECT id FROM students WHERE email = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && mysqli_num_rows($res) > 0) {
            $error = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = mysqli_prepare($conn, 'INSERT INTO students (name, email, password) VALUES (?, ?, ?)');
            mysqli_stmt_bind_param($ins, 'sss', $name, $email, $hash);
            if (mysqli_stmt_execute($ins)) {
                echo "<script>alert('Registration successful. You can now login.'); window.location='login.php';</script>";
                exit();
            } else {
                $error = 'Database error: ' . mysqli_error($conn);
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <title>Register - Student Mental Health System</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
<div class='container py-5'>
  <div class='row justify-content-center'>
    <div class='col-md-6'>
      <div class='card p-4'>
        <h3 class='mb-3'>Create Student Account</h3>
        <?php if (!empty($error)): ?>
          <div class='alert alert-danger'><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action='register.php' method='POST' class='row g-3'>
          <div class='col-12'>
            <label class='form-label'>Full name</label>
            <input name='name' class='form-control' required>
          </div>
          <div class='col-12'>
            <label class='form-label'>Email</label>
            <input name='email' type='email' class='form-control' required>
          </div>
          <div class='col-12'>
            <label class='form-label'>Password</label>
            <input name='password' type='password' class='form-control' required>
          </div>
          <div class='col-12'>
            <button class='btn btn-primary w-100' type='submit'>Sign Up</button>
          </div>
          <div class='col-12 text-center'>
            <small>Already have an account? <a href='login.php'>Login</a></small>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
