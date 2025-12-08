<?php
include __DIR__ . "/../../config/koneksi.php";
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id']; // id_transaksi

    // ambil data transaksi + id_kembali
    $sql = "SELECT 
                t.id_transaksi,
                t.total, 
                t.downpayment, 
                t.kekurangan, 
                t.nopol,
                k.id_kembali,
                k.denda
            FROM tbl_transaksi t
            JOIN tbl_kembali k ON t.id_transaksi = k.id_transaksi
            WHERE t.id_transaksi = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $id_kembali  = $row['id_kembali'];
        $total       = $row['total'];
        $dp          = $row['downpayment'];
        $kekurangan  = $row['kekurangan'];
        $nopol       = $row['nopol'];
        $denda       = $row['denda'];

        // total yang harus dibayar = kekurangan + denda
        $total_bayar = $kekurangan + $denda;

        if ($total_bayar > 0) {
            // update transaksi → kekurangan jadi 0
            $sqlUpdate = "UPDATE tbl_transaksi 
                          SET kekurangan = 0, status = 'kembali' 
                          WHERE id_transaksi = :id";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute(['id' => $id]);

            // catat pembayaran di tbl_bayar
            $sqlInsert = "INSERT INTO tbl_bayar (id_kembali, tgl_bayar, total_bayar, status) 
                          VALUES (:id_kembali, NOW(), :bayar, 'lunas')";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->execute([
                'id_kembali' => $id_kembali,
                'bayar'      => $total_bayar
            ]);

            // update status mobil jadi tersedia
            $sqlUpdateMobil = "UPDATE tbl_mobil 
                               SET status = 'tersedia' 
                               WHERE nopol = :nopol";
            $stmtUpdateMobil = $pdo->prepare($sqlUpdateMobil);
            $stmtUpdateMobil->execute(['nopol' => $nopol]);

            // pesan sukses
            echo "<script>
                alert('Pembayaran berhasil! Total yang dibayar Rp " . number_format($total_bayar, 0, ',', '.') . "');
                window.location='index.php?page=bayar';
            </script>";
            exit;
        }
    }

    // kalau data tidak ada
    echo "<script>alert('Data transaksi tidak ditemukan atau sudah lunas'); window.location='index.php?page=bayar';</script>";
    exit;
} else {
    header("Location: index.php?page=bayar");
    exit;
}
?>
