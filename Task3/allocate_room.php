<?php
include "db.php";
if(!isset($_SESSION['admin'])) header("Location: login.php");
if(isset($_POST['allocate'])){
    $student = (int)$_POST['student'];
    $room = (int)$_POST['room'];

    // prevent a student from having more than one allocation
    $check = $conn->query("SELECT a.*, r.room_number FROM allocations a JOIN rooms r ON a.room_id=r.room_id WHERE a.student_id=$student");
    if($check && $check->num_rows>0){
        $ex = $check->fetch_assoc();
        $msg = "Student is already allocated to room {$ex['room_number']}. Deallocate first to assign a different room.";
    } else {
        // validate room gender and range
        $r = $conn->query("SELECT capacity,occupied,room_number FROM rooms WHERE room_id=$room");
        $sQ = $conn->query("SELECT gender FROM students WHERE student_id=$student");
        $row = null; $srow = null;
        if($r !== false) $row = $r->fetch_assoc();
        if($sQ !== false) $srow = $sQ->fetch_assoc();
        if($row && $srow){
            $roomnum = (int)$row['room_number'];
            $sg = strtolower($srow['gender'] ?? '');
            $roomGender = 'mixed';
            if($roomnum>=600 && $roomnum<=640) $roomGender = 'female';
            if($roomnum>=641 && $roomnum<=680) $roomGender = 'male';
            if($roomnum < 600 || $roomnum > 680){
                $msg = "Selected room is outside the allowed range (600-680).";
            } elseif($roomGender !== 'mixed' && $sg !== $roomGender){
                $msg = "Selected room is reserved for {$roomGender} students only.";
            } else {
                if( (int)($row['occupied'] ?? 0) < (int)($row['capacity'] ?? 0) ){
                    $conn->query("INSERT INTO allocations (student_id,room_id) VALUES($student,$room)");
                    $conn->query("UPDATE rooms SET occupied=occupied+1 WHERE room_id=$room");
                    $msg = "Allocated successfully.";
                } else {
                    $msg = "Selected room is full.";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
<h2>Allocate Room</h2>
<form method="post" class="box" id="allocForm">

<label>Student</label>
<select name="student" id="studentSelect">
<?php
// render only students who are not currently allocated
$r=$conn->query("SELECT s.* FROM students s LEFT JOIN allocations a ON s.student_id=a.student_id WHERE a.student_id IS NULL ORDER BY s.fullname");
if($r){
    while($s=$r->fetch_assoc()){
        $g = strtolower($s['gender'] ?? '');
        echo "<option value='{$s['student_id']}' data-gender='{$g}'>{$s['fullname']} ({$g})</option>";
    }
} else {
    echo "<option value=''>No students available</option>";
}
?>
</select>

<label>Room</label>
<select name="room" id="roomSelect">
<?php
// render rooms limited to 600-680 and with computed gender based on room_number numeric range
$r=$conn->query("SELECT * FROM rooms WHERE (room_number+0) BETWEEN 600 AND 680 ORDER BY (room_number+0)");
function room_gender($roomnum){
    $n = (int)filter_var($roomnum, FILTER_SANITIZE_NUMBER_INT);
    if($n>=600 && $n<=640) return 'female';
    if($n>=641 && $n<=680) return 'male';
    return 'mixed';
}
if($r){
    while($rm=$r->fetch_assoc()){
        $gender = room_gender($rm['room_number']);
        $isFull = ($rm['occupied'] ?? 0) >= ($rm['capacity'] ?? 0);
        $disabledAttr = $isFull ? "data-disabled='true' disabled" : "data-disabled='false'";
        echo "<option value='{$rm['room_id']}' data-gender='{$gender}' {$disabledAttr}>{$rm['room_number']} ({$rm['occupied']}/{$rm['capacity']})</option>";
    }
} else {
    echo "<option value=''>No rooms available</option>";
}
?>
</select>
<p id="noRoomsMsg" class="box" style="display:none;margin-top:8px;background:#fff4e5;color:#663c00">No eligible rooms available for the selected student.</p>

<div style="margin-top:10px"><button name="allocate">Allocate</button></div>
</form>

<?php if(isset($msg)): ?>
    <p class="box" style="background:#e6ffed;color:#064e3b"><?php echo htmlspecialchars($msg); ?></p>
<?php endif; ?>

<script>
// filter rooms based on selected student's gender
const studentSelect = document.getElementById('studentSelect');
const roomSelect = document.getElementById('roomSelect');
function filterRooms(){
    const sg = studentSelect.selectedOptions[0].dataset.gender || '';
    let anyVisible = false;
    for(const opt of roomSelect.options){
        const rg = opt.dataset.gender || '';
        const isDisabled = opt.getAttribute('data-disabled') === 'true';
        // allow 'mixed' rooms for everyone
        const ok = (rg === 'mixed' || sg === rg || !sg) && !isDisabled;
        opt.hidden = !ok;
        if(ok) anyVisible = true;
    }
    document.getElementById('noRoomsMsg').style.display = anyVisible ? 'none' : 'block';
}
studentSelect.addEventListener('change', filterRooms);
window.addEventListener('load', filterRooms);
</script>
<script src="script.js"></script>
</script>
<p style="margin:18px 0 28px;text-align:center"><a href="dashboard.php" class="btn-link">Back to Dashboard</a></p>
</body>
</html>
