<?php include "db.php"; if(!isset($_SESSION['admin'])) header("Location: login.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="style.css">
	<title>Room Status</title>
</head>
<body>

<div class="container">
	<aside id="navMenu">
		<div class="brand">Dormitary</div>
		<a href="register_student.php">Register Student</a>
		<a href="allocate_room.php">Allocate Room</a>
		<a href="room_status.php">Room Status</a>
		<a href="about.php">About</a>
		<a href="logout.php">Logout</a>
	</aside>

	<main class="main-card">
		<button id="menuBtn">☰</button>
		<h2>Room Status</h2>

		<div class="table-wrap">
			<table class="status-table">
				<thead>
					<tr><th>Room</th><th>Capacity</th><th>Occupied</th><th>Available</th><th>Usage</th></tr>
				</thead>
				<tbody>
				<?php
				$r=$conn->query("SELECT * FROM rooms");
				while($row=$r->fetch_assoc()){
					$capacity = (int)$row['capacity'];
					$occupied = (int)$row['occupied'];
					$available = max(0, $capacity - $occupied);
					$percent = $capacity>0 ? round(($occupied/$capacity)*100) : 0;
					$statusClass = $percent>=100 ? 'full' : ($percent>=70 ? 'high' : ($percent>=40 ? 'medium' : 'low'));
					echo "<tr class=\"status-{$statusClass}\">";
					echo "<td>{$row['room_number']}</td>";
					echo "<td>{$capacity}</td>";
					echo "<td>{$occupied}</td>";
					echo "<td><span class=\"badge badge-{$statusClass}\">{$available}</span></td>";
					echo "<td><div class=\"progress\"><div class=\"progress-fill\" style=\"width:{$percent}%\"></div><small>{$percent}%</small></div></td>";
					echo "</tr>";
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
