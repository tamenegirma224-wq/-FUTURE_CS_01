<?php
include "db.php";
if(!isset($_SESSION['admin'])) header("Location: login.php");
$msg='';
$dir = __DIR__ . '/uploads/carousel';
if(!is_dir($dir)) mkdir($dir, 0755, true);
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['upload'])){
    if(!empty($_FILES['image']['name'])){
        $f = $_FILES['image'];
        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        if(!in_array($ext, $allowed)) $msg = 'Only JPG/PNG/GIF allowed.';
        elseif($f['size'] > 3*1024*1024) $msg = 'File too large (max 3MB).';
        else{
            $name = time() . '_' . preg_replace('/[^a-z0-9._-]/i','_', $f['name']);
            $target = $dir . '/' . $name;
            if(move_uploaded_file($f['tmp_name'], $target)) $msg = 'Uploaded.'; else $msg='Upload failed.';
        }
    } else $msg='No file selected.';
}
if(isset($_GET['delete'])){
    $file = basename($_GET['delete']);
    $path = $dir . '/' . $file;
    if(file_exists($path)) { unlink($path); $msg='Deleted.'; }
    header('Location: carousel_admin.php'); exit;
}
$files = array_values(array_filter(scandir($dir), function($x){ return preg_match('/\.(jpg|jpeg|png|gif)$/i',$x); }));
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="style.css">
<title>Carousel Admin</title>
</head>
<body>
<?php include 'menu.php'; ?>
<div class="container">
  <main class="main-card">
    <h2>Carousel Images</h2>
    <?php if($msg): ?><div class="box"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="box">
      <label>Choose image (max 3MB)</label>
      <input type="file" name="image" accept="image/*" required>
      <div style="margin-top:8px"><button name="upload">Upload</button></div>
    </form>
    <h3>Existing Images</h3>
    <div style="display:flex;gap:12px;flex-wrap:wrap">
    <?php foreach($files as $f): ?>
      <div style="width:140px;text-align:center">
        <img src="uploads/carousel/<?php echo rawurlencode($f); ?>" style="width:100%;height:90px;object-fit:cover;border-radius:6px;border:1px solid #ddd">
        <div style="margin-top:6px"><a href="carousel_admin.php?delete=<?php echo urlencode($f); ?>" onclick="return confirm('Delete?')">Delete</a></div>
      </div>
    <?php endforeach; ?>
    </div>
  </main>
</div>
<script src="script.js"></script>
</body>
</html>