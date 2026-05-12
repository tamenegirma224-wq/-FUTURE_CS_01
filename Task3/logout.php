<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
// clear session data
$_SESSION = [];
session_unset();
session_destroy();
// clear cookie used for display
setcookie("admin_user", "", time() - 3600, "/");
header("Location: login.php");
exit;
