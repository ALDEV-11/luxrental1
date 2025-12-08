<?php
require_once __DIR__ . '/../../config/koneksi.php'; // ini memanggil $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik     = trim($_POST['nik']);
    $nama    = trim($_POST['nama']);
    $jk      = $_POST['jk'];
    $telp    = trim($_POST['telp']);
    $alamat  = trim($_POST['alamat']);
    $user    = trim($_POST['user']);
    $pass    = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $foto    = "";

    // Cek NIK atau Username sudah ada
    $stmt = $pdo->prepare("SELECT 1 FROM tbl_member WHERE nik = ? OR user = ?");
    $stmt->execute([$nik, $user]);
    if ($stmt->fetch()) {
        header("Location: ../auth/register.php?error=" . urlencode("NIK atau Username sudah terdaftar!"));
        exit;
    }

    // Upload foto jika ada
    if (!empty($_FILES['foto']['name'])) {
        $targetDir = __DIR__ . "/../../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $foto = time() . "_" . basename($_FILES['foto']['name']);
        $targetFile = $targetDir . $foto;

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
            header("Location: ../auth/register.php?error=" . urlencode("Gagal mengupload foto!"));
            exit;
        }
    }

    // Simpan data ke database
    $stmt = $pdo->prepare("INSERT INTO tbl_member (nik, nama, jk, telp, alamat, user, pass, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$nik, $nama, $jk, $telp, $alamat, $user, $pass, $foto])) {
        header("Location: ../auth/register.php?success=" . urlencode("Registrasi berhasil! Silakan login."));
        exit;
    } else {
        header("Location: ../auth/register.php?error=" . urlencode("Terjadi kesalahan saat menyimpan data."));
        exit;
    }
} else {
    header("Location: ../auth/register.php");
    exit;
}
