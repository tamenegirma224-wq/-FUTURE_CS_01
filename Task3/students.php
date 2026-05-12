<?php
include "db.php";
if(!isset($_SESSION['admin'])) header("Location: login.php");
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    // remove allocation first (ON DELETE CASCADE would handle student removal, but ensure counts)
    $r = $conn->query("SELECT room_id FROM allocations WHERE student_id=$id");
    if($r){
        while($a=$r->fetch_assoc()){
            $conn->query("UPDATE rooms SET occupied = GREATEST(0, occupied-1) WHERE room_id={$a['room_id']}");
        }
    }
    $conn->query("DELETE FROM students WHERE student_id=$id");
    header('Location: students.php'); exit;
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
<?php include 'menu.php'; ?>
<div class="container">
  <main class="main-card">
    <h2>Students</h2>
    <div class="quick-actions" style="margin-bottom:12px">
      <a class="btn" href="allocate_room.php">Allocate Room</a>
      <a class="btn" href="allocations.php">Allocations</a>
      <a class="btn" href="room_status.php">Room Status</a>
      <a class="btn" href="view_room.php">View Room</a>
    </div>
    <table class="status-table">
      <thead><tr><th>ID</th><th>Name</th><th>Gender</th><th>Department</th><th>Actions</th></tr></thead>
      <tbody>
      <?php
      $r=$conn->query("SELECT * FROM students");
      while($s=$r->fetch_assoc()){
        echo "<tr><td>{$s['student_id']}</td><td>{$s['fullname']}</td><td>{$s['gender']}</td><td>{$s['department']}</td>";
        echo "<td><a href='register_student.php?id={$s['student_id']}'>Edit</a> | <a href='students.php?delete={$s['student_id']}' onclick=\"return confirm('Delete student?')\">Delete</a></td></tr>";
      }
      ?>
      </tbody>
    </table>
  </main>
</div>
<script src="script.js"></script>
</body>
</html>