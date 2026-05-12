<?php
include "db.php";
if(!isset($_SESSION['admin'])) header('Location: login.php');
$isAdmin = isset($_SESSION['admin']);
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <title>Student Messages</title>
</head>
<body>
<?php include 'menu.php'; ?>
<div class="container">
  <main class="main-card">
    <button id="menuBtn">☰</button>
    <h2>Student Messages</h2>
    <div class="table-wrap">
      <table class="messages-table">
        <thead>
          <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Room</th>
            <th>Message</th>
            <th>Sent At</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $mres = $conn->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 1000");
        if($mres){
          while($m = $mres->fetch_assoc()){
            echo '<tr>';
            echo '<td>'.htmlspecialchars($m['student_id']).'</td>';
            echo '<td>'.htmlspecialchars($m['student_name']).'</td>';
            echo '<td>'.htmlspecialchars($m['room_id']).'</td>';
            echo '<td class="message-cell">'.nl2br(htmlspecialchars($m['message'])).'</td>';
            echo '<td>'.htmlspecialchars($m['created_at']).'</td>';
            echo '</tr>';
          }
        }
        ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
<script src="script.js"></script>
</body>
</html>
