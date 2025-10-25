<?php
require_once 'includes/config.php';
session_start();
include 'includes/header_student.php';
$student_id = $_SESSION['student_id'];
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Student Dashboard</title>
</head>
<body class="bg-light">

<div class="container py-4">
  <div class="row">
    
    <!-- LEFT CARD: Latest Result -->
    <div class="col-md-4">
      <div class="card p-3 mb-3 shadow-sm">
        <h5>🧠 Latest Assessment Result</h5>
        <hr>

        <?php
        $query = $conn->query("SELECT risk_level, advice, created_at FROM assessments WHERE student_id='$student_id' ORDER BY id DESC LIMIT 1");

        if($query->num_rows > 0){
            $row = $query->fetch_assoc();
            $risk = $row['risk_level'];
            $advice = $row['advice'];
            $date = $row['created_at'];

            $color = ($risk == 'High') ? 'red' : (($risk == 'Moderate') ? 'orange' : 'green');
            echo "<p class='h4' style='color:$color;'>$risk</p>";
            echo "<p>". nl2br(htmlspecialchars($advice)) ."</p>";
            echo "<p><small>📅 $date</small></p>";
        } else {
            echo "<p>No assessment taken yet.</p>";
        }
        ?>
      </div>

      <!-- ACTIONS -->
      <div class="card p-3 shadow-sm">
        <h5>Quick Actions</h5>
        <a href="assessment.php" class="btn btn-success w-100 mb-2">📝 Take Assessment</a>
        <a href="results.php" class="btn btn-outline-success w-100">📁 View Past Results</a>
      </div>
    </div>

    <!-- RIGHT SIDE WELLNESS TIPS -->
    <div class="col-md-8">
      <div class="card p-3 shadow-sm">
        <h4>🌱 Wellness Tips</h4>
        <ul>
          <li>Maintain a healthy sleep schedule.</li>
          <li>Reach out to someone if you feel overwhelmed.</li>
          <li>Balance academic work with relaxation.</li>
        </ul>
      </div>
    </div>

  </div>
</div>

</body>
</html>
