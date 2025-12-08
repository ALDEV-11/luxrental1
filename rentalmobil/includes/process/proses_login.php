<?php
session_start();
require __DIR__ . '/../../config/koneksi.php';

$user = $_POST['user'];
$pass = $_POST['pass'];

// Cek di tbl_user (admin/petugas)
$stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE user = ?");
$stmt->execute([$user]);
$data = $stmt->fetch();

if ($data && password_verify($pass, $data['pass'])) {
    $_SESSION['login'] = true;
    $_SESSION['role'] = $data['lvl']; // 'admin' atau 'petugas'
    $_SESSION['user'] = $data['user'];

    if ($data['lvl'] == 'admin') {
        header("Location: ../../index.php?page=tambah_mobil");
    } elseif ($data['lvl'] == 'petugas') {
        header("Location: ../../index.php?page=petugas");
    } else {
        echo "Level tidak dikenali.";
    }
    exit;
}

// Cek di tbl_member (customer) dengan user atau nik
$stmt = $pdo->prepare("SELECT * FROM tbl_member WHERE user = ? OR nik = ?");
$stmt->execute([$user, $user]);
$data = $stmt->fetch();

if ($data && password_verify($pass, $data['pass'])) {
    // Cek apakah member aktif
    if ($data['is_active'] == 0) {
        $_SESSION['error'] = 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.';
        header("Location: ../auth/login.php");
        exit;
    }
    
    $_SESSION['login'] = true;
    $_SESSION['role'] = 'member';
    $_SESSION['nik'] = $data['nik']; // simpan nik sebagai id
    $_SESSION['user'] = $data['user'];
    $_SESSION['nama'] = $data['nama'];

    header("Location: ../../index.php?page=member");
    exit;
}

// Gagal login
$_SESSION['error'] = 'Username atau password salah!';
header("Location: ../auth/login.php");
exit;
?>