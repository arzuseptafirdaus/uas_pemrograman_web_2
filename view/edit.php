<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include_once '../controller/BarangController.php';
$controller = new BarangController();

$id = $_GET['id'];
$barang = $controller->edit($id);
$error = "";

if (isset($_POST['update'])) {
    $error = $controller->update($id, $_POST, $_FILES);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Aset Mainan</title>
    <link rel="stylesheet" href="style/green.css">
</head>
<body>
    <div class="container" style="max-width: 600px;">
        <h2>Ubah Data Aset Mainan 📝</h2>
        <hr style="border: 1px solid #2e7d32; margin-bottom: 20px;">

        <?php if(!empty($error)): ?>
            <div style="color: red; margin-bottom: 15px; font-weight: bold;"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" name="kode_barang" value="<?= htmlspecialchars($barang['kode_barang']); ?>" required>
            </div>
            <div class="form-group">
                <label>Nama Mainan</label>
                <input type="text" name="nama_mainan" value="<?= htmlspecialchars($barang['nama_mainan']); ?>" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" required>
                    <option value="Edukasi" <?= $barang['kategori'] == 'Edukasi' ? 'selected' : ''; ?>>Edukasi</option>
                    <option value="Action Figure" <?= $barang['kategori'] == 'Action Figure' ? 'selected' : ''; ?>>Action Figure</option>
                    <option value="Kendaraan" <?= $barang['kategori'] == 'Kendaraan' ? 'selected' : ''; ?>>Kendaraan</option>
                    <option value="Puzzle" <?= $barang['kategori'] == 'Puzzle' ? 'selected' : ''; ?>>Puzzle</option>
                </select>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" min="0" value="<?= htmlspecialchars($barang['stok']); ?>" required>
            </div>
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" min="0" value="<?= htmlspecialchars($barang['harga']); ?>" required>
            </div>
            <div class="form-group">
                <label>Foto Saat Ini</label><br>
                <img src="../uploads/<?= $barang['foto']; ?>" width="80" style="border-radius: 5px; margin-bottom: 10px;"><br>
                <label>Ganti Foto (Kosongkan jika tidak diubah)</label>
                <input type="file" name="foto">
            </div>
            <div style="margin-top: 20px;">
                <button type="submit" name="update" class="btn" style="background-color: #f57c00;">Perbarui Data</button>
                <a href="dashboard.php" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>