<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $no_telp  = trim($_POST['no_telp']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    $existingUser = $stmt->fetch();
    if ($existingUser) {
        echo "<script>
            alert('Username atau email sudah digunakan!');
            window.location.href='register.php';
        </script>";
        exit;
    }
    $stmt = $pdo->prepare("
        INSERT INTO users (nama, email, no_telp, username, password, role)
        VALUES (:nama, :email, :no_telp, :username, :password, 'user')
    ");
    try {
        $stmt->execute([
            'nama'     => $nama,
            'email'    => $email,
            'no_telp'  => $no_telp,
            'username' => $username,
            'password' => $password
        ]);
        echo "<script>
            alert('Registration successful! Please login.');
            window.location.href='login.php';
        </script>";
    } catch (PDOException $e) {
        echo "<script>
            alert('Registration failed! Please try again.');
            window.location.href='register.php';
        </script>";
    }
}
?>
