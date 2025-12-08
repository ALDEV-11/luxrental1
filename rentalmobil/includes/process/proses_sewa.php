<?php
session_start();

// Pastikan member login
if (!isset($_SESSION['nik'])) {
    echo "<script>alert('Silakan login terlebih dahulu');window.location='login.php';</script>";
    exit;
}

$koneksi = new mysqli("localhost", "root", "root", "luxrental");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_POST['sewa'])) {
    $nik         = $_SESSION['nik']; // dari session login
    $nopol       = $_POST['nopol'];
    $harga       = $_POST['harga'];
    $tgl_booking = date('Y-m-d');
    $tgl_ambil   = $_POST['tgl_ambil'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $supir       = $_POST['supir'];
    $downpayment = $_POST['downpayment'];

    // Hitung lama sewa (dalam hari)
    $ambil   = new DateTime($tgl_ambil);
    $kembali = new DateTime($tgl_kembali);
    $lama    = $ambil->diff($kembali)->days;

    if ($lama <= 0) {
        echo "<script>alert('Tanggal kembali harus lebih besar dari tanggal ambil!');window.location='index.php?page=sewa_mobil';</script>";
        exit;
    }

    // Biaya supir per hari
    $biaya_supir = ($supir == 1) ? 100000 : 0;

    // Total biaya
    $total = ($harga + $biaya_supir) * $lama;

    // Kekurangan pembayaran
    $kekurangan = $total - $downpayment;

    // Simpan transaksi
    $sql = $koneksi->prepare("INSERT INTO tbl_transaksi 
        (nik, nopol, tgl_booking, tgl_ambil, tgl_kembali, supir, total, downpayment, kekurangan, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'booking')");
    $sql->bind_param("issssiiid", 
        $nik, 
        $nopol, 
        $tgl_booking, 
        $tgl_ambil, 
        $tgl_kembali, 
        $supir, 
        $total, 
        $downpayment, 
        $kekurangan
    );

    if ($sql->execute()) {
        // Update status mobil
        $update = $koneksi->prepare("UPDATE tbl_mobil SET status='tidak' WHERE nopol=?");
        $update->bind_param("s", $nopol);
        $update->execute();

        echo "<script>alert('Sewa berhasil!');window.location='index.php?page=sewa_mobil';</script>";
    } else {
        echo "<script>alert('Gagal menyewa mobil');window.location='index.php?page=sewa_mobil';</script>";
    }
}
?>
