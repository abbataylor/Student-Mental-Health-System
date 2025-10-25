<?php
session_start();
require_once "../includes/config.php";
require_once "../dompdf/autoload.inc.php";

use Dompdf\Dompdf;

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit();
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = $conn->query("
        SELECT s.name, a.*
        FROM assessments a
        JOIN students s ON s.id = a.student_id
        WHERE a.id = '$id'
    ");
    $row = $query->fetch_assoc();

    $logo = "https://upload.wikimedia.org/wikipedia/en/e/e4/KIU_logo.png"; // KIU logo

    $html = "
    <h2 style='text-align:center;'>Kampala International University</h2>
    <img src='$logo' style='display:block;margin:auto;width:100px;'>
    <h3 style='text-align:center;margin-top:10px;'>Mental Health Assessment Report</h3>
    <hr><br>

    <p><strong>Student Name:</strong> {$row['name']}</p>
    <p><strong>Gender:</strong> {$row['gender']}</p>
    <p><strong>University:</strong> {$row['university']}</p>
    <p><strong>Department:</strong> {$row['department']}</p>
    <p><strong>Year of Study:</strong> {$row['year_of_study']}</p>
    <p><strong>CGPA:</strong> {$row['cgpa']}</p>
    <p><strong>Date Assessed:</strong> {$row['created_at']}</p>
    <br>

    <h4><strong>Mental Health Risk Level:</strong> {$row['risk_level']}</h4>
    <p style='font-size:17px;'><strong>Advice:</strong><br>{$row['advice']}</p>

    <br><br>
    <p style='text-align:center;font-size:14px;'>This report is confidential and intended for academic guidance and wellness support.</p>
    ";

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream("Assessment_Report.pdf");
}
?>
