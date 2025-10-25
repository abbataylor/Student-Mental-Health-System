<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

require_once "includes/config.php";

$student_id = $_SESSION['student_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Student Personal Info ---
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $university = $_POST['university'];
    $year_of_study = $_POST['year_of_study'];
    $cgpa = $_POST['cgpa'];

    // --- Mental State Inputs ---
    $sleep = $_POST['sleep'];
    $pressure = $_POST['pressure'];
    $social = $_POST['social'];
    $mood = $_POST['mood'];
    $anxiety = $_POST['anxiety'];

    // --- Scoring Model ---
    $score = 0;
    $score += (10 - $sleep);
    $score += $pressure;
    $score += $social;
    $score += $mood;
    $score += $anxiety;

    if ($score >= 20) {
        $risk_level = "High";
        $advice = "Your stress level appears high. Please consider reaching out to a counselor or trusted mentor. Try reducing academic overload, improve sleep, and practice mindfulness.";
    } elseif ($score >= 12) {
        $risk_level = "Moderate";
        $advice = "Your stress level is moderate. Try maintaining balance between academics and rest, talk to friends, and consider light relaxation exercises.";
    } else {
        $risk_level = "Low";
        $advice = "Your mental wellness appears stable. Continue healthy habits, good sleep routine, and positive social interaction.";
    }

    // --- Save to Database ---
    $stmt = $conn->prepare("INSERT INTO assessments 
        (student_id, risk_level, advice, gender, age, university, year_of_study, cgpa) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssisss", $student_id, $risk_level, $advice, $gender, $age, $university, $year_of_study, $cgpa);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Mental Health Assessment</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-4">
<h3>Mental Wellness Assessment</h3>

<form method="POST" class="card p-4">

<!-- Student Info -->
<h5>Student Details</h5>
<div class="row">
  <div class="col-md-2">
    <label>Age</label>
    <input type="number" name="age" class="form-control" required>
  </div>
  <div class="col-md-2">
    <label>Gender</label>
    <select name="gender" class="form-control" required>
      <option>Male</option>
      <option>Female</option>
    </select>
  </div>
  <div class="col-md-4">
    <label>University / Course</label>
    <input type="text" name="university" class="form-control" required>
  </div>
  <div class="col-md-2">
    <label>Year of Study</label>
    <input type="text" name="year_of_study" class="form-control" required>
  </div>
  <div class="col-md-2">
    <label>CGPA</label>
    <input type="text" name="cgpa" class="form-control" required>
  </div>
</div>

<hr>

<!-- Mental State Questions -->
<h5>Mental Health Questions</h5>

<label class="mt-2">How many hours do you sleep? (0-10)</label>
<input type="number" name="sleep" class="form-control" min="0" max="10" required>

<label class="mt-2">Academic Pressure (1-10)</label>
<input type="number" name="pressure" class="form-control" min="1" max="10" required>

<label class="mt-2">Social Withdrawal (1-10)</label>
<input type="number" name="social" class="form-control" min="1" max="10" required>

<label class="mt-2">Mood Level (1 = positive, 10 = very low mood)</label>
<input type="number" name="mood" class="form-control" min="1" max="10" required>

<label class="mt-2">Anxiety (1-10)</label>
<input type="number" name="anxiety" class="form-control" min="1" max="10" required>

<button class="btn btn-primary mt-4 w-100">Submit Assessment</button>

</form>
</div>
</body>
</html>
