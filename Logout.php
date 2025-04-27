<?php
session_start();
$db_connect = mysqli_connect('localhost', 'root', '', 'login_activity');

if (isset($_SESSION['user_id'])) {
    $stmt = $db_connect->prepare("UPDATE user_info SET remember_token = 'none', token_expires = 'none' WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
}

setcookie("remember_token", "", time() - 3600, "/");
session_destroy();

header("Location: index.html");
exit;

