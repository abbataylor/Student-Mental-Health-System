<?php
require_once "../includes/config.php";

// Count risk levels
$high = $conn->query("SELECT COUNT(*) AS c FROM assessments WHERE risk_level='High'")->fetch_assoc()['c'];
$moderate = $conn->query("SELECT COUNT(*) AS c FROM assessments WHERE risk_level='Moderate'")->fetch_assoc()['c'];
$low = $conn->query("SELECT COUNT(*) AS c FROM assessments WHERE risk_level='Low'")->fetch_assoc()['c'];

echo json_encode([
    "high" => (int)$high,
    "moderate" => (int)$moderate,
    "low" => (int)$low
]);
?>
