<?php
require_once 'includes/config.php';
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}
$student_id = $_SESSION['student_id'];
// fetch latest assessment
$stmt = mysqli_prepare($conn, 'SELECT * FROM assessments WHERE student_id = ? ORDER BY id DESC LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $student_id);
mysqli_stmt_execute($stmt);
$latest = mysqli_stmt_get_result($stmt);
$assessment = mysqli_fetch_assoc($latest);
?>
<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <title>Dashboard - Student Mental Health System</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
  <div class='container'>
    <a class='navbar-brand' href='#'>SMHS</a>
    <div class='ms-auto text-white'>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> | <a href='logout.php' class='text-white'>Logout</a></div>
  </div>
</nav>
<div class='container py-4'>
  <div class='row'>
    <div class='col-md-4'>
      <div class='card p-3 mb-3'>
        <h5>Latest Result</h5>
        <?php if ($assessment): ?>
          <p class='h4'><?php echo htmlspecialchars($assessment['result']); ?></p>
          <p><?php echo nl2br(htmlspecialchars($assessment['advice'])); ?></p>
        <?php else: ?>
          <p>No assessments yet. <a href='assessment.php'>Take one now</a></p>
        <?php endif; ?>
      </div>
      <div class='card p-3'>
        <h5>Quick Actions</h5>
        <a href='assessment.php' class='btn btn-outline-primary w-100 mb-2'>Take Assessment</a>
        <a href='results.php' class='btn btn-outline-secondary w-100'>View Results</a>
      </div>
    </div>
    <div class='col-md-8'>
      <div class='card p-3'>
        <h5>Wellness Tips</h5>
        <ul>
          <li>Maintain regular sleep schedule.</li>
          <li>Take short walks to clear your mind.</li>
          <li>Connect with friends or a counselor if stressed.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
</body>
</html>
