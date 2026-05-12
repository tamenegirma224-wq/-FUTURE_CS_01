<?php
include "db.php";
if(!isset($_SESSION['student'])) header('Location: login.php');
$student_id = (int)$_SESSION['student'];
$student_name = $_SESSION['student_name'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <title>Student Dashboard</title>
</head>
<body>
<?php include 'menu.php'; ?>
<div class="container">
  <aside id="navMenu">
    <div class="brand">Student</div>
    <a href="view_room.php">Find Room</a>
    <a href="contact_student.php">Add Contact</a>
    <a href="logout.php">Logout</a>
  </aside>

  <main class="main-card">
    <button id="menuBtn">☰</button>
    <h2>Welcome <?php echo htmlspecialchars($student_name); ?></h2>
    <p class="lead">Use the menu to find your room or send a message to the admin.</p>
  </main>
</div>
<script src="script.js"></script>
</body>
</html>
