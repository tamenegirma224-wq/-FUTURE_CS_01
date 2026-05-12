<?php
include "db.php";
if(!isset($_SESSION['student'])) header('Location: login.php');
$student_id = (int)$_SESSION['student'];
$student_name = $_SESSION['student_name'] ?? '';
$success = '';
if(isset($_POST['send'])){
    $room_id = $conn->real_escape_string($_POST['room_id'] ?? '');
    $message = $conn->real_escape_string($_POST['message'] ?? '');
    if($message === ''){
        $err = 'Message cannot be empty.';
    } else {
        $conn->query("INSERT INTO messages (student_id, student_name, room_id, message) VALUES($student_id, '".$conn->real_escape_string($student_name)."', '".$room_id."', '".$message."')") or die($conn->error);
        $success = 'Successfully sent.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <title>Contact Admin</title>
</head>
<body>
<?php include 'menu.php'; ?>
<div class="container">
  <main class="main-card" style="max-width:720px;margin:40px auto">
    <h2>Send Message to Admin</h2>
    <?php if(!empty($success)) echo "<div class='box' style='background:#e6ffed;color:#064e3b'>".htmlspecialchars($success)."</div>"; ?>
    <form method="post" class="box">
      <label>Student ID</label>
      <input name="student_id" value="<?php echo $student_id; ?>" readonly>

      <label>Full Name</label>
      <input name="student_name" value="<?php echo htmlspecialchars($student_name); ?>" readonly>

      <label>Room ID (optional)</label>
      <input name="room_id" placeholder="Enter room number or id">

      <label>Message</label>
      <textarea name="message" rows="5" placeholder="Your message to admin"></textarea>

      <div style="margin-top:12px"><button name="send">Send</button></div>
    </form>
    <p style="margin:18px 0 0;text-align:center"><a href="student_dashboard.php" class="btn-link">Back to Dashboard</a></p>
  </main>
</div>
<script src="script.js"></script>
</body>
</html>
