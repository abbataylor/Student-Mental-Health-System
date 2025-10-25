<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

require_once "includes/config.php";
$student_id = $_SESSION['student_id'];

// Fetch all past assessments
$stmt = $conn->prepare("SELECT risk_level, advice, created_at FROM assessments WHERE student_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Assessment History</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
  <div class='container'>
    <a class='navbar-brand' href='dashboard.php'>SMHS</a>
    <div class='ms-auto text-white'>
      <?php echo htmlspecialchars($_SESSION['name']); ?> |
      <a href='logout.php' class='text-white'>Logout</a>
    </div>
  </div>
</nav>

<div class="container py-4">

<h3>Your Assessment History</h3>
<p class="text-muted">Below is a record of all your previous mental wellness assessments.</p>

<div class="card p-3">
<table class="table table-bordered table-striped text-center">
<thead class="table-primary">
<tr>
  <th>Date</th>
  <th>Risk Level</th>
  <th>Advice Summary</th>
</tr>
</thead>
<tbody>

<?php 
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['created_at'] . "</td>";

        if ($row['risk_level'] == "High") {
            echo "<td style='color:red; font-weight:bold;'>" . $row['risk_level'] . "</td>";
        } elseif ($row['risk_level'] == "Moderate") {
            echo "<td style='color:orange; font-weight:bold;'>" . $row['risk_level'] . "</td>";
        } else {
            echo "<td style='color:green; font-weight:bold;'>" . $row['risk_level'] . "</td>";
        }

        echo "<td>" . substr($row['advice'], 0, 60) . "...</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No assessments recorded yet.</td></tr>";
}
?>

</tbody>
</table>
</div>

<a href="dashboard.php" class="btn btn-secondary mt-3">⬅ Back to Dashboard</a>

</div>
</body>
</html>
