<?php
include_once "db.php";
$isAdmin = isset($_SESSION['admin']);
$admin_user = $_SESSION['admin_user'] ?? $_COOKIE['admin_user'] ?? '';
$isStudent = isset($_SESSION['student']);
$student_name = $_SESSION['student_name'] ?? '';
?>
<header class="top-nav">
  <div class="nav-left">
    <nav class="main-menu">
      <?php if($isAdmin): ?>
        <a href="dashboard.php">Home</a>
        <a href="students.php">Students</a>
      <?php endif; ?>
      <a href="about.php">About Us</a>
      <!-- Contact removed -->
      <?php if($isAdmin): ?>
        <a href="messages.php">Messages</a>
      <?php endif; ?>
      
    </nav>
  </div>
    <div class="nav-right">
    <?php if($isAdmin): ?>
      <span class="user">Welcome <?php echo htmlspecialchars($admin_user); ?></span>
      <a href="logout.php" class="btn-link">Logout</a>
    <?php elseif($isStudent): ?>
      <span class="user">Welcome <?php echo htmlspecialchars($student_name); ?></span>
      <a href="logout.php" class="btn-link">Logout</a>
    <?php else: ?>
      <a href="login.php" class="btn-link">Login</a>
    <?php endif; ?>
  </div>
</header>