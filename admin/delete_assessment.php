<?php
require_once "../includes/config.php";
$id = $_GET['id'];
$conn->query("DELETE FROM assessments WHERE id='$id'");
header("Location: admin_dashboard.php");
exit();
