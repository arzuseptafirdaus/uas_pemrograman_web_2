<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include_once '../controller/BarangController.php';
$controller = new BarangController();
$error = "";

if (isset($_POST['simpan'])) {
    $error = $controller->simpan($_POST, $_FILES);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Aset Mainan</title>
    <link rel="stylesheet" href="style/green.css">
</head>
<body>
    <div class="container" style="max-width: 600px;">
        <h2>Tambah Aset Barang Mainan 🧸</h2>
        <hr style="border: 1px solid #2e7d32; margin-bottom: 20px;">

        <?php if(!empty($error)): ?>
            <div style="color: red; margin-bottom: 15px; font-weight: bold;"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" name="kode_barang" required placeholder="Contoh: BRG002">
            </div>
            <div class="form-group">
                <label>Nama Mainan</label>
                <input type="text" name="nama_mainan" required placeholder="Contoh: Robot Transformers">
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" required>
                    <option value="Edukasi">Edukasi</option>
                    <option value="Action Figure">Action Figure</option>
                    <option value="Kendaraan">Kendaraan</option>
                    <option value="Puzzle">Puzzle</option>
                </select>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" min="0" required placeholder="0">
            </div>
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" min="0" required placeholder="0">
            </div>
            <div class="form-group">
                <label>Upload Foto Mainan (JPG/PNG)</label>
                <input type="file" name="foto" required>
            </div>
            <div style="margin-top: 20px;">
                <button type="submit" name="simpan" class="btn">Simpan Data</button>
                <a href="dashboard.php" class="btn btn-danger">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>