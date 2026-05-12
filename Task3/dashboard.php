<?php
include "db.php";
// do not force redirect here; show login/logout depending on session
$isAdmin = isset($_SESSION['admin']);
$admin_user = $_SESSION['admin_user'] ?? $_COOKIE['admin_user'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="style.css">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
		<title>Dormitary — Home</title>
</head>
<body>

<?php include 'menu.php'; ?>

<div class="container">
	<main class="main-card main-column">
		<section class="hero">
			<div class="hero-overlay"></div>
			<?php
			$carousel_dir = 'uploads/carousel';
			$imgs = [];
			if(is_dir($carousel_dir)){
				$imgs = glob($carousel_dir."/*.{jpg,jpeg,png,gif}", GLOB_BRACE) ?: [];
			}
			if(count($imgs)>0): ?>
				<div class="carousel" id="carousel">
					<?php foreach($imgs as $img): ?>
						<div class="carousel-item"><img src="<?php echo htmlspecialchars($img); ?>" alt=""></div>
					<?php endforeach; ?>
				</div>
			<?php else: ?>
				<div class="hero-content">
					<h1>Dormitary Management</h1>
					<div class="quick-actions">
						<a class="btn btn-primary" href="register_student.php">Register Student</a>
					</div>
				</div>
			<?php endif; ?>
		</section>



	</main>
</div>

<script src="script.js"></script>
</body>
</html>
