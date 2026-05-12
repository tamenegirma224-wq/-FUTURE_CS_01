<?php
include "db.php";
if(isset($_POST['login'])){
        $role = $_POST['role'] ?? 'admin';
        if($role === 'admin'){
                $u = $conn->real_escape_string($_POST['username'] ?? '');
                $p = hash("sha256", $_POST['password'] ?? '');
                $q = $conn->query("SELECT * FROM users WHERE username='$u' AND password='$p'");
                if($q && $q->num_rows==1){
                        $_SESSION['admin'] = $u;
                        setcookie("admin_user", $u, time()+3600);
                        header("Location: dashboard.php"); exit;
                } else $error = "Invalid admin credentials";
        } else {
                // student login by ID and full name (no password required)
                $student_id = (int)($_POST['student_id'] ?? 0);
                $name = $conn->real_escape_string(trim($_POST['student_name'] ?? ''));
                if($student_id && $name){
                        $q = $conn->query("SELECT * FROM students WHERE student_id=$student_id AND fullname='$name'");
                        if($q && $q->num_rows==1){
                                $_SESSION['student'] = $student_id;
                                        $_SESSION['student_name'] = $name;
                                        header('Location: student_dashboard.php'); exit;
                        } else $error = "No matching student record";
                } else $error = "Provide student ID and full name";
        }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<script>
function toggleRole(){
        const sel = document.getElementById('roleSelect');
        const role = sel ? sel.value : 'admin';
        document.getElementById('adminFields').style.display = role==='admin' ? 'block' : 'none';
        document.getElementById('studentFields').style.display = role==='student' ? 'block' : 'none';
}
</script>
</head>
<body>
<div class="box">
<h2>Login</h2>
<form method="post">
        <div class="role-choice">
                <label for="roleSelect">Role</label>
                <select id="roleSelect" name="role" onchange="toggleRole()">
                        <option value="admin">Admin</option>
                        <option value="student">Student</option>
                </select>
        </div>

    <div id="adminFields" style="margin-top:12px">
        <input name="username" placeholder="Admin username">
        <input type="password" name="password" placeholder="Password">
    </div>

    <div id="studentFields" style="display:none;margin-top:12px">
        <input name="student_id" type="number" placeholder="Student ID">
        <input name="student_name" placeholder="Full name">
    </div>

    <div style="margin-top:12px"><button name="login">Login</button></div>
</form>
<p class="error"><?php echo $error??""; ?></p>
</div>
<script>toggleRole();</script>
</body>
</html>
