<?php
session_start();
include_once '../config/database.php';

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

$message = "";
if (isset($_POST['login'])) {
    $database = new Database();
    $db = $database->getConnection();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Password salah!";
        }
    } else {
        $message = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Manajemen Aset Mainan</title>
    <link rel="stylesheet" href="style/green.css">
    <style>
        .login-box { max-width: 400px; margin: 100px auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-top: 5px solid #2e7d32; }
    </style>
</head>
<body>
    <div class="login-box">
        <h3 style="text-align: center; margin-bottom: 5px;">Manajemen Aset</h3>
        <p style="text-align: center; color: #666; font-size: 14px; margin-bottom: 25px;">Silakan login untuk melanjutkan</p>
        
        <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'registrasi_sukses'): ?>
            <div style="color: green; margin-bottom: 15px; font-weight: bold;">Registrasi Berhasil! Silakan Login.</div>
        <?php endif; ?>

        <?php if(!empty($message)): ?>
            <div style="color: red; margin-bottom: 15px; font-weight: bold;"><?= $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Masukkan username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Masukkan password">
            </div>
            <button type="submit" name="login" class="btn" style="width: 100%; margin-top: 10px;">➔ Login</button>
        </form>
        <p style="text-align: center; margin-top: 15px; font-size: 14px;">
            Belum punya akun? <a href="registrasi.php" style="color: #2e7d32; font-weight: bold;">Registrasi</a>
        </p>
    </div>
</body>
</html>