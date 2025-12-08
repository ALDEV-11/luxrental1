<?php

include __DIR__ . "/../../config/koneksi.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id     = $_GET['id'];
    $status = $_GET['status']; // langsung "aprove" / "ditolak"

    // validasi status
    if (!in_array($status, ['aprove', 'ditolak'])) {
        die("Status tidak valid!");
    }

    // ambil nopol mobil dari transaksi
    $sql = "SELECT nopol FROM tbl_transaksi WHERE id_transaksi = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $transaksi = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($transaksi) {
        // update status transaksi
        $sql = "UPDATE tbl_transaksi SET status = :status WHERE id_transaksi = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['status' => $status, 'id' => $id]);

        // kalau ditolak, mobil jadi tersedia
        if ($status === 'ditolak') {
            $sql = "UPDATE tbl_mobil SET status = 'tersedia' WHERE nopol = :nopol";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['nopol' => $transaksi['nopol']]);
        }
    }

    header("Location: index.php?page=transaksi");
    exit;
}
