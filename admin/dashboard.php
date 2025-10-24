<?php
include('../includes/config.php');
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
$total = mysqli_fetch_row(mysqli_query($conn, 'SELECT COUNT(*) FROM students'))[0];
$atRisk = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM assessments WHERE result='High'"))[0];
?>
<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <title>Admin Dashboard</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
  <div class='container'><a class='navbar-brand' href='#'>SMHS Admin</a></div>
</nav>
<div class='container py-4'>
  <div class='row'>
    <div class='col-md-4'><div class='card p-3'><h5>Total Students</h5><p class='h3'><?php echo $total; ?></p></div></div>
    <div class='col-md-4'><div class='card p-3'><h5>High Risk</h5><p class='h3 text-danger'><?php echo $atRisk; ?></p></div></div>
    <div class='col-md-4'><div class='card p-3'><h5>Assessments</h5><p class='h3'><?php echo mysqli_fetch_row(mysqli_query($conn, 'SELECT COUNT(*) FROM assessments'))[0]; ?></p></div></div>
  </div>
  <div class='mt-4'><a href='../logout.php' class='btn btn-secondary'>Logout</a></div>
</div>
</body>
</html>
