<?php
session_start();
if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$risk = isset($_GET['risk']) ? $_GET['risk'] : "Unknown";
$advice = isset($_GET['advice']) ? urldecode($_GET['advice']) : "No advice available.";
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Assessment Result</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
body {
    background: #e8edf3;
    font-family: 'Segoe UI', sans-serif;
}
.card {
    border-radius: 15px;
    padding: 30px;
    margin-top: 80px;
    box-shadow: 0px 6px 30px rgba(0,0,0,0.07);
}
.risk-badge {
    font-size: 22px;
    padding: 10px 20px;
    border-radius: 8px;
}
.low { background: #28a745; color: white; }
.moderate { background: #ffc107; color: black; }
.high { background: #dc3545; color: white; }
</style>
</head>
<body>

<div class="container">
<div class="col-md-8 mx-auto">
<div class="card text-center">

    <h2 class="mb-3">🧠 Mental Health Assessment Result</h2>
    <h4 class="mb-2">Student: <strong><?php echo $name; ?></strong></h4>
    
    <h3 class="risk-badge 
        <?php echo strtolower($risk); ?>">
        Risk Level: <?php echo $risk; ?>
    </h3>

    <p class="mt-4" style="font-size:18px;"><?php echo $advice; ?></p>

    <a href="dashboard.php" class="btn btn-primary mt-4">⬅ Back to Dashboard</a>

</div>
</div>
</div>

</body>
</html>
