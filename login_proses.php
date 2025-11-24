<?php
include 'db.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();
    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];
            if (!empty($_POST['remember'])) {
                setcookie('user_id', $user['id_user'], time() + (7 * 24 * 60 * 60), "/"); // 7 hari
                setcookie('user_key', hash('sha256', $user['username']), time() + (7 * 24 * 60 * 60), "/");
            }
            if ($user['role'] === 'admin') {
                header("Location: reservation_tables.php");
            } else {
                header("Location: reservation.php");
            }
            exit;
        } else {
            echo "<script>
                alert('Password salah!');
                window.location.href='login.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Username tidak ditemukan!');
            window.location.href='login.php';
        </script>";
    }
}
?>