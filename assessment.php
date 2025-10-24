<?php
// Include database connection
include('db_connect.php'); // Make sure this file exists and connects to your database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs safely
    $sleep_hours = $_POST['sleep_hours'];
    $study_pressure = $_POST['study_pressure'];
    $stress_frequency = $_POST['stress_frequency'];
    $age = $_POST['age'];
    $marital_status = $_POST['marital_status'];

    // Basic logic for mental health assessment
    if ($sleep_hours < 5 && $study_pressure > 7 && $stress_frequency == "Always") {
        $result = "High Risk";
        $advice = "You may be experiencing high stress and sleep deprivation. Try to rest, manage your schedule, and talk to a counselor.";
    } elseif ($sleep_hours >= 5 && $sleep_hours <= 7 && $study_pressure >= 4 && $stress_frequency == "Often") {
        $result = "Moderate Risk";
        $advice = "You may be under some stress. Take breaks, maintain a healthy routine, and seek support if needed.";
    } else {
        $result = "Low Risk";
        $advice = "Your mental health seems stable. Continue maintaining a balanced lifestyle.";
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO assessments (student_id, sleep_hours, study_pressure, stress_frequency, result, advice) VALUES (?, ?, ?, ?, ?, ?)");
    $student_id = 1; // You can change this or get it from session later
    $stmt->bind_param("iiisss", $student_id, $sleep_hours, $study_pressure, $stress_frequency, $result, $advice);

    if ($stmt->execute()) {
        echo "<div style='padding:20px; background:#e0ffe0; border:1px solid #00b300; border-radius:8px;'>
                🧠 <strong>Your Mental Health Risk:</strong> $result<br>
                💬 <strong>Advice:</strong> $advice
              </div>";
    } else {
        echo "<div style='color:red;'>Error saving assessment: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>

<!-- Simple HTML Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Mental Health Assessment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 40px;
        }
        form {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        h2 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>🧩 Mental Health Assessment</h2>

        <label>How many hours do you sleep per day?</label>
        <input type="number" name="sleep_hours" min="0" max="24" required>

        <label>How would you rate your study/work pressure? (1-10)</label>
        <input type="number" name="study_pressure" min="1" max="10" required>

        <label>How often do you feel stressed?</label>
        <select name="stress_frequency" required>
            <option value="">Select</option>
            <option value="Rarely">Rarely</option>
            <option value="Sometimes">Sometimes</option>
            <option value="Often">Often</option>
            <option value="Always">Always</option>
        </select>

        <label>Age</label>
        <input type="number" name="age" required>

        <label>Marital Status</label>
        <select name="marital_status" required>
            <option value="">Select</option>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Divorced">Divorced</option>
        </select>

        <button type="submit">Get Mental Health Risk</button>
    </form>
</body>
</html>
