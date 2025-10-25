<?php
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}
?>
<nav class="navbar navbar-expand-lg" style="background:#008037;">
  <div class="container">
    <a class="navbar-brand text-white fw-bold" href="dashboard.php">KIU Mental Health System</a>
    <a href="chat.php" style="position:fixed; bottom:25px; right:25px; background:#00eaff; 
color:#000; padding:15px; border-radius:50%; text-decoration:none; box-shadow:0 0 10px #00eaff;">
💬
</a>

    <div class="ms-auto">
      <span class="text-white me-3">👤 <?php echo htmlspecialchars($_SESSION['name']); ?></span>
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>
