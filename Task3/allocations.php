<?php
include "db.php";
if(!isset($_SESSION['admin'])) header("Location: login.php");

// determine primary key column name
$pkcol = null;
$pkres = $conn->query("SHOW KEYS FROM allocations WHERE Key_name = 'PRIMARY'");
if($pkres && $pkrow = $pkres->fetch_assoc()){
  $pkcol = $pkrow['Column_name'];
}
if(!$pkcol){
  $cols = $conn->query("SHOW COLUMNS FROM allocations");
  if($cols){
    while($c = $cols->fetch_assoc()){
      if(in_array($c['Field'], ['allocation_id','id'])){
        $pkcol = $c['Field']; break;
      }
    }
  }
}
if(!$pkcol) $pkcol = 'allocation_id';

// ========================
// Deallocate ONLY
// ========================
if(isset($_GET['deallocate'])){
  $id = (int)$_GET['deallocate'];
  $r = $conn->query("SELECT room_id FROM allocations WHERE {$pkcol}=$id");
  if($r && $a=$r->fetch_assoc()){
    $conn->query("DELETE FROM allocations WHERE {$pkcol}=$id");
    $conn->query("UPDATE rooms 
                  SET occupied = GREATEST(0, occupied-1) 
                  WHERE room_id = {$a['room_id']}");
  }
  header('Location: allocations.php');
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <aside id="navMenu">
    <div class="brand">Dormitory</div>
    <a href="register_student.php">Register Student</a>
    <a href="allocate_room.php">Allocate Room</a>
    <a href="room_status.php">Room Status</a>
    <a href="about.php">About</a>
    <a href="logout.php">Logout</a>
  </aside>

  <main class="main-card">
    <button id="menuBtn">☰</button>
    <h2>Allocations</h2>

    <div class="table-wrap">
      <table class="status-table">
        <thead>
          <tr>
            <th>Student</th>
            <th>Room</th>
            <th>Allocated At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $order = 's.fullname ASC';
        $c = $conn->query("SHOW COLUMNS FROM allocations LIKE 'created_at'");
        if($c && $c->num_rows>0) $order = 'a.created_at DESC';

        $sql = "
          SELECT a.*, a.$pkcol AS alloc_pk,
                 s.fullname,
                 r.room_number
          FROM allocations a
          JOIN students s ON a.student_id = s.student_id
          JOIN rooms r ON a.room_id = r.room_id
          ORDER BY $order
        ";

        $r = $conn->query($sql);
        if($r){
          while($row = $r->fetch_assoc()){
            $when = $row['created_at'] ?? $row['alloc_pk'];
            $id = $row['alloc_pk'];

            echo "<tr>
                    <td>{$row['fullname']}</td>
                    <td>{$row['room_number']}</td>
                    <td>{$when}</td>
                    <td>
                      <a href='allocations.php?deallocate=$id'
                         onclick=\"return confirm('Deallocate this student?')\">
                         Deallocate
                      </a>
                    </td>
                  </tr>";
          }
        }
        ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<script src="script.js"></script>
</script>
<p style="margin:18px 0 28px;text-align:center"><a href="dashboard.php" class="btn-link">Back to Dashboard</a></p>
</body>
</html>
