<?php
// admin_check.php - diagnostic helper
// Put this file in C:\xampp\htdocs\mental\ and open it in browser: http://localhost/mental/admin_check.php

// DB connect - adjust if your db_connect file name differs
include 'db_connect.php';

echo "<h2>Admin verification diagnostic</h2>";

// Fetch admin row
$sql = "SELECT id, username, password FROM admins WHERE id = 1 LIMIT 1";
$res = $conn->query($sql);
if (!$res) {
    echo "<p style='color:red;'>DB query failed: " . htmlspecialchars($conn->error) . "</p>";
    exit;
}
$row = $res->fetch_assoc();
if (!$row) {
    echo "<p style='color:red;'>No admin row found (id=1)</p>";
    exit;
}

echo "<p><strong>Row fetched from DB:</strong></p>";
echo "<pre>" . htmlspecialchars(print_r($row, true)) . "</pre>";

// Test password_verify with expected password values
$tests = [
    '123456',
    'adminpass',
    'admin123',
    'password',
];

echo "<h3>password_verify tests</h3>";
foreach ($tests as $t) {
    $ok = password_verify($t, $row['password']);
    echo "<p>Testing '<strong>" . htmlspecialchars($t) . "</strong>' : " . ($ok ? "<span style='color:green;'>MATCH</span>" : "<span style='color:red;'>NO MATCH</span>") . "</p>";
}

// Also show password_hash of a sample to compare format
$sample = password_hash('123456', PASSWORD_DEFAULT);
echo "<p>Sample hash of '123456' using this PHP: <br><code>" . htmlspecialchars($sample) . "</code></p>";

echo "<p style='color:blue;'>If none of the tested passwords match, use admin_reset.php to set a new known password (instructions below).</p>";
?>
