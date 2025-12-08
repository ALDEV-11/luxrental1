<?php
include __DIR__ . "/../../config/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // update status transaksi menjadi ambil
    $sql = "UPDATE tbl_transaksi 
            SET status = 'ambil', tgl_ambil = NOW() 
            WHERE id_transaksi = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    header("Location: index.php?page=bayar");
    exit;
}
