<?php
include_once '../config/database.php';

$message = "";
if (isset($_POST['register'])) {
    $database = new Database();
    $db = $database->getConnection();

    $nama = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    if (empty($nama) || empty($username) || empty($password)) {
        $message = "Semua field wajib diisi!";
    } elseif ($password !== $konfirmasi_password) {
        $message = "Konfirmasi password tidak cocok!";
    } else {
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        $check_query = "SELECT * FROM users WHERE username = ?";
        $stmt_check = $db->prepare($check_query);
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $message = "Username sudah terdaftar!";
        } else {
            $query = "INSERT INTO users (nama_lengkap, username, password) VALUES (?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("sss", $nama, $username, $password_hashed);
            
            if ($stmt->execute()) {
                header("Location: login.php?pesan=registrasi_sukses");
                exit();
            } else {
                $message = "Gagal melakukan registrasi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="style/green.css">
    <style>
        .login-box { max-width: 400px; margin: 100px auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-top: 5px solid #2e7d32; }
    </style>
</head>
<body>
    <div class="login-box">
        <h3 style="text-align: center; margin-bottom: 20px;">Registrasi Akun Aset</h3>
        <?php if(!empty($message)): ?>
            <div style="color: red; margin-bottom: 15px; font-weight: bold;"><?= $message; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" required placeholder="Masukkan Nama Lengkap">
            </div>
            <div class="form-group">
                <label>Username *</label>
                <input type="text" name="username" required placeholder="Masukkan Username">
            </div>
            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password" required placeholder="Masukkan Password">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password *</label>
                <input type="password" name="konfirmasi_password" required placeholder="Ulangi Password">
            </div>
            <button type="submit" name="register" class="btn" style="width: 100%; margin-top: 10px;">Daftar Akun</button>
        </form>
        <p style="text-align: center; margin-top: 15px; font-size: 14px;">
            Sudah punya akun? <a href="login.php" style="color: #2e7d32; font-weight: bold;">Login di sini</a>
        </p>
    </div>
</body>
</html>