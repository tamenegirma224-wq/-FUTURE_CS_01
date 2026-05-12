<?php
$include_line = 'include "db.php";';
include "db.php";
if(!isset($_SESSION['admin'])) header("Location: login.php");
$editing = false;
if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
    $res = $conn->query("SELECT * FROM students WHERE student_id=$id");
    if($res) $student = $res->fetch_assoc();
    $editing = true;
}
if(isset($_POST['save'])){
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $department = $conn->real_escape_string($_POST['department']);
    if(!empty($_POST['student_id'])){
        // editing existing student
        $id = (int)$_POST['student_id'];
        $conn->query("UPDATE students SET fullname='$fullname', gender='$gender', department='$department' WHERE student_id=$id");
        $msg = "Student updated.";
    } else {
        // new student - require custom student id (no auto-increment)
        $custom_id = isset($_POST['student_id_custom']) && $_POST['student_id_custom']!=='' ? (int)$_POST['student_id_custom'] : 0;
        if(!$custom_id){
            $msg = "Student ID is required. Please provide a unique numeric ID.";
        } else {
            // ensure no conflict
            $check = $conn->query("SELECT student_id FROM students WHERE student_id=$custom_id");
            if($check && $check->num_rows>0){
                $msg = "Student ID $custom_id already exists. Choose another.";
            } else {
                $conn->query("INSERT INTO students (student_id,fullname,gender,department) VALUES($custom_id,'$fullname','$gender','$department')");
                $msg = "Student Registered Successfully (ID: $custom_id)";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
<h2><?php echo $editing? 'Edit Student' : 'Student Registration'; ?></h2>
<form method="post" class="box">
    <?php if($editing): ?>
        <label>Student ID (readonly)</label>
        <input name="student_id" value="<?php echo (int)$student['student_id'] ?>" readonly>
    <?php else: ?>
        <label>Student ID (required, unique)</label>
        <input name="student_id_custom" type="number" placeholder="Enter unique numeric ID" required>
    <?php endif; ?>

    <label>Full Name</label>
    <input name="fullname" placeholder="Full Name" required value="<?php echo htmlspecialchars($student['fullname'] ?? '') ?>">

    <label>Gender</label>
    <select name="gender">
        <option <?php if(($student['gender'] ?? '')=='Male') echo 'selected';?>>Male</option>
        <option <?php if(($student['gender'] ?? '')=='Female') echo 'selected';?>>Female</option>
    </select>

    <label>Department</label>
    <input name="department" placeholder="Department" value="<?php echo htmlspecialchars($student['department'] ?? '') ?>">

    <div style="margin-top:12px"><button name="save"><?php echo $editing? 'Update' : 'Save'; ?></button></div>
</form>
<p><?php echo $msg??""; ?></p>
<p><a href="students.php">Manage Students</a></p>
<script src="script.js"></script>
</script>
<p style="margin:18px 0 28px;text-align:center"><a href="dashboard.php" class="btn-link">Back to Dashboard</a></p>
</body>
</html>
