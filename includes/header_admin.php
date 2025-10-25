<?php
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}
?>
<nav class="navbar navbar-expand-lg" style="background:#008037;">
  <div class="container">
    <a class="navbar-brand text-white fw-bold" href="admin_dashboard.php">KIU Admin Panel</a>

    <div class="ms-auto">
      <span class="text-white me-3">🛡 Admin</span>
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>
