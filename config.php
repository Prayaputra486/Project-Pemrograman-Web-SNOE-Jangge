<?php
session_start();
include 'db.php';
if (!isset($_SESSION['login'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_key'])) {
        $id = $_COOKIE['user_id'];
        $key = $_COOKIE['user_key'];
        $result = $pdo->prepare("SELECT username, role FROM users WHERE id_user = :id");
        $result->execute([':id' => $id]);
        $row = $result->fetch();
        if ($row && $key === hash('sha256', $row['username'])) {
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $id;
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
        }
    }
    if (!isset($_SESSION['login'])) {
        header("Location: login.php");
        exit;
    }
}
if ($_SESSION['role'] === 'admin') {
    header("Location: reservation_tables.php");
    exit;
}
$user_id = $_SESSION['id_user'];
?>