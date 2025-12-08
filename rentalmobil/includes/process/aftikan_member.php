<?php
session_start();

// Cek apakah user sudah login dan memiliki akses
if (!isset($_SESSION['login']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("Location: ../../landing.php");
    exit;
}

// Koneksi database
$koneksi = new mysqli("localhost", "root", "root", "luxrental");

// Ambil NIK dari parameter URL
if (isset($_GET['nik'])) {
    $nik = $koneksi->real_escape_string($_GET['nik']);
    
    // Update status member menjadi aktif
    $query = "UPDATE tbl_member SET is_active = 1 WHERE nik = '$nik'";
    
    if ($koneksi->query($query)) {
        $_SESSION['success'] = "Member berhasil diaktifkan kembali!";
    } else {
        $_SESSION['error'] = "Gagal mengaktifkan member: " . $koneksi->error;
    }
    
    $koneksi->close();
    
    // Redirect kembali ke halaman member nonaktif
    header("Location: member_nonaktif.php");
    exit;
} else {
    header("Location: member_nonaktif.php");
    exit;
}
?>