<?php
include "db.php";
$found = false;
if($_SERVER['REQUEST_METHOD']==='POST'){
    $student_id = (int)($_POST['student_id'] ?? 0);
    $name = $conn->real_escape_string(trim($_POST['name'] ?? ''));
    if($student_id && $name){
        $q = $conn->query("SELECT s.*, r.room_number FROM students s LEFT JOIN allocations a ON s.student_id=a.student_id LEFT JOIN rooms r ON a.room_id=r.room_id WHERE s.student_id=$student_id AND s.fullname='".$conn->real_escape_string($name)."'");
        if($q && $row=$q->fetch_assoc()){
            $found = $row;
        } else {
            $err = "No matching student found.";
        }
    } else {
        $err = "Provide both ID and full name.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <title>Find My Room</title>
</head>
<body>
<div class="container">
  <main class="main-card" style="max-width:720px;margin:40px auto">
    <h2>Find your room</h2>
    <?php if(!empty($err)) echo "<div class='box' style='background:#fee2e2;color:#7f1d1d'>".htmlspecialchars($err)."</div>";?>
    <?php if($found): ?>
      <div class="box">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($found['fullname']); ?></p>
        <p><strong>Department:</strong> <?php echo htmlspecialchars($found['department']); ?></p>
        <p><strong>Room:</strong> <?php echo htmlspecialchars($found['room_number'] ?? 'Not allocated'); ?></p>
      </div>
    <?php else: ?>
      <form method="post" class="box">
        <label>Student ID</label>
        <input name="student_id" type="number" required>
        <label>Full name</label>
        <input name="name" required>
        <button type="submit">Find</button>
      </form>
    <?php endif; ?>
  </main>
</div>
<script src="script.js"></script>
<p style="margin:18px 0 28px;text-align:center">
  <a href="student_dashboard.php" class="btn-link">Back to Dashboard</a>
  <a href="contact_student.php" class="btn-link" style="margin-left:12px">Contact</a>
</p>
</body>
</html>