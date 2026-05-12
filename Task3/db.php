<?php
// ================================
// DATABASE CONNECTION & CREATION
// ================================

// Connect without database first
$conn = new mysqli("localhost", "root", "");
if ($conn->connect_error) die("DB Connection Error");

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS dormitory_db");

// Select database
$conn->select_db("dormitory_db");

// Start session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<?php
// ================================
// USERS TABLE (ADMIN LOGIN)
// ================================

$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
)") or die($conn->error);

// Insert default admin if not exists
$checkAdmin = $conn->query("SELECT id FROM users WHERE username='admin'");
if ($checkAdmin->num_rows == 0) {
    $conn->query("
        INSERT INTO users (username, password)
        VALUES ('admin', SHA2('admin123', 256))
    ") or die($conn->error);
}
?>

<?php
// ================================
// STUDENTS TABLE
// ================================

$conn->query("CREATE TABLE IF NOT EXISTS students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    gender VARCHAR(32),
    department VARCHAR(128)
)") or die($conn->error);

// Remove AUTO_INCREMENT if exists (optional safety)
$col = $conn->query("SHOW COLUMNS FROM students LIKE 'student_id'");
if ($col && $crow = $col->fetch_assoc()) {
    if (stripos($crow['Extra'], 'auto_increment') !== false) {
        $conn->query("ALTER TABLE students MODIFY student_id INT NOT NULL")
            or die($conn->error);
    }
}
?>

<?php
// ================================
// ROOMS TABLE
// ================================

$conn->query("CREATE TABLE IF NOT EXISTS rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(64) NOT NULL,
    capacity INT NOT NULL DEFAULT 6,
    occupied INT NOT NULL DEFAULT 0
)") or die($conn->error);
?>

<?php
// ================================
// ALLOCATIONS TABLE
// ================================

$conn->query("CREATE TABLE IF NOT EXISTS allocations (
    allocation_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    room_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE CASCADE
)") or die($conn->error);
?>

<?php
// ================================
// MESSAGES TABLE (STUDENT -> ADMIN)
// ================================

$conn->query("CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    student_name VARCHAR(255),
    room_id VARCHAR(64),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)") or die($conn->error);
?>

<?php
// ================================
// INSERT ROOMS 600 - 680
// ================================

for ($n = 600; $n <= 680; $n++) {
    $roomnum = (string)$n;
    $res = $conn->query("SELECT room_id FROM rooms WHERE room_number='$roomnum'");
    if (!$res || $res->num_rows == 0) {
        $conn->query("
            INSERT INTO rooms (room_number, capacity, occupied)
            VALUES ('$roomnum', 6, 0)
        ");
    }
}

// Ensure all rooms have capacity = 6
$conn->query("UPDATE rooms SET capacity = 6") or die($conn->error);
?>

