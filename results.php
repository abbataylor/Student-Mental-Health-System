<?php
require_once 'includes/config.php';
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}
$student_id = $_SESSION['student_id'];
$stmt = mysqli_prepare($conn, 'SELECT * FROM assessments WHERE student_id = ? ORDER BY id DESC LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $student_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
?>
<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <title>Results - Student Mental Health System</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
<div class='container py-5'>
  <div class='row justify-content-center'>
    <div class='col-md-8'>
      <div class='card p-4 text-center'>
        <?php if ($row): ?>
          <h3>Your Assessment Result</h3>
          <p class='h2'><?php echo htmlspecialchars($row['result']); ?></p>
          <p><?php echo nl2br(htmlspecialchars($row['advice'])); ?></p>
          <a href='dashboard.php' class='btn btn-primary'>Back to Dashboard</a>
        <?php else: ?>
          <p>No assessment found. <a href='assessment.php'>Take one now</a></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>
