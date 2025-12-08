<?php
include __DIR__ . "/../../config/koneksi.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Update status
    $sql = "UPDATE tbl_transaksi SET status = :status WHERE id_transaksi = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['status' => $status, 'id' => $id]);

    // Balik ke halaman riwayat.php dengan tab aktif
    header("Location: riwayat.php?status=".$status);
    exit;
} else {
    echo "Data tidak valid!";
}
