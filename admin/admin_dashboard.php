<?php
require_once "../includes/config.php";
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$query = $conn->query("
    SELECT a.id, s.name, a.university, a.department, a.risk_level, a.advice, a.created_at
    FROM assessments a
    LEFT JOIN students s ON a.student_id = s.id
    ORDER BY a.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Dashboard - KIU Mental Health System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
  background: #0b0f1a;
  color: #e6e6e6;
  font-family: Arial, sans-serif;
}

.navbar {
  background: linear-gradient(90deg, #0a1b4f, #001a33);
  border-bottom: 2px solid #00eaff;
}
.navbar-brand { font-weight: 700; color: #00eaff !important; }

.card {
  background: #111827;
  border: 1px solid #00eaff55;
  border-radius: 10px;
  box-shadow: 0 0 8px #00eaff40;
}

table {
  background: #1a2338;
  color: #e6e6e6;
  border: 1px solid #00eaff55;
}
th {
  background: #0d1530;
  color: #00eaff;
  text-transform: uppercase;
}
td { color: #d0d8ff; }

.high { color: #ff005e; font-weight: bold; }
.mod  { color: #ffb300; font-weight: bold; }
.low  { color: #36ff88; font-weight: bold; }

#riskChart { max-width: 330px; height: 330px; margin:auto; }

.section-title {
  text-align:center;
  color:#00eaff;
  font-size:28px;
  font-weight:bold;
  text-shadow:0 0 12px #00eaff;
}

.btn-danger, .btn-info {
  border-radius: 6px;
  padding: 5px 10px;
}
</style>
</head>
<body>

<nav class="navbar navbar-dark">
  <div class="container">
    <span class="navbar-brand">KIU Mental Health - Admin Panel</span>
    <a href="logout.php" class="btn btn-outline-info btn-sm">Logout</a>
  </div>
</nav>

<div class="container py-4">
  <h2 class="section-title">📊 Mental Health Assessment Overview</h2>

  <div class="text-center my-3">
    <canvas id="riskChart"></canvas>
  </div>

  <div class="card p-3 mt-4">
    <h4 class="text-center" style="color:#00eaff;">📝 Student Assessment Records</h4>

    <table class="table table-striped table-bordered align-middle mt-3">
      <thead>
        <tr>
          <th>Student</th>
          <th>University</th>
          <th>Department</th>
          <th>Risk Level</th>
          <th style="width:28%;">Advice</th>
          <th>Date</th>
          <th>PDF</th>
          <th>Delete</th>
        </tr>
      </thead>

      <tbody>
        <?php while($row = $query->fetch_assoc()): ?>
        <?php
          $riskClass = ($row['risk_level'] == 'High') ? 'high' :
                       (($row['risk_level'] == 'Moderate') ? 'mod' : 'low');
        ?>
        <tr>
          <td><?= htmlspecialchars($row['name']); ?></td>
          <td><?= htmlspecialchars($row['university']); ?></td>
          <td><?= htmlspecialchars($row['department']); ?></td>
          <td class="<?= $riskClass; ?>"><?= $row['risk_level']; ?></td>
          <td><?= nl2br(htmlspecialchars($row['advice'])); ?></td>
          <td><?= $row['created_at']; ?></td>

          <td>
            <a href="generate_pdf.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm">PDF</a>
          </td>

          <td>
            <a href="delete_assessment.php?id=<?= $row['id']; ?>" 
               class="btn btn-danger btn-sm"
               onclick="return confirm('Are you sure you want to delete this record?');">
               Delete
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
fetch("risk_data.php")
.then(r=>r.json())
.then(data=>{
  new Chart(document.getElementById('riskChart'),{
    type:'doughnut',
    data:{
      labels:["High","Moderate","Low"],
      datasets:[{
        data:[data.high,data.moderate,data.low],
        backgroundColor:["#ff005e","#ffb300","#36ff88"],
        borderColor:"#00eaff",
        borderWidth:2
      }]
    },
    options:{ plugins:{ legend:{ labels:{ color:"#e6e6e6" }}} }
  });
});
</script>

</body>
</html>
