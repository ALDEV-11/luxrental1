<?php
session_start();
include __DIR__ . "/../../config/koneksi.php";

// Cek apakah admin sudah login
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../landing.php");
    exit;
}

if ($_POST) {
    $id_transaksi = $_POST['id_transaksi'];
    $jenis_denda = $_POST['jenis_denda'];
    $jumlah_denda = $_POST['jumlah_denda'];
    $keterangan_denda = $_POST['keterangan_denda'];

    try {
        // Update kekurangan di tabel transaksi
        $sql_update = "UPDATE tbl_transaksi 
                      SET kekurangan = kekurangan + :jumlah_denda 
                      WHERE id_transaksi = :id_transaksi";
        
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([
            'jumlah_denda' => $jumlah_denda, 
            'id_transaksi' => $id_transaksi
        ]);

        // Update denda di tbl_kembali jika record sudah ada
        $sql_kembali = "UPDATE tbl_kembali 
                       SET denda = denda + :jumlah_denda,
                           keterangan = CONCAT(COALESCE(keterangan, ''), ' | Denda ', :jenis_denda, ': ', :keterangan_denda, ' (Rp', :jumlah_denda_format, ')')
                       WHERE id_transaksi = :id_transaksi";
        
        $stmt_kembali = $pdo->prepare($sql_kembali);
        $stmt_kembali->execute([
            'jumlah_denda' => $jumlah_denda,
            'jenis_denda' => $jenis_denda,
            'keterangan_denda' => $keterangan_denda,
            'jumlah_denda_format' => number_format($jumlah_denda, 0, ',', '.'),
            'id_transaksi' => $id_transaksi
        ]);

        // Jika tidak ada baris yang diupdate di tbl_kembali, buat record baru
        if ($stmt_kembali->rowCount() == 0) {
            $sql_insert_kembali = "INSERT INTO tbl_kembali (id_transaksi, tgl_kembali, kondisi_mobil, denda, keterangan) 
                                  VALUES (:id_transaksi, CURDATE(), 'Baik', :jumlah_denda, CONCAT('Denda ', :jenis_denda, ': ', :keterangan_denda, ' (Rp', :jumlah_denda_format, ')'))";
            
            $stmt_insert = $pdo->prepare($sql_insert_kembali);
            $stmt_insert->execute([
                'id_transaksi' => $id_transaksi,
                'jumlah_denda' => $jumlah_denda,
                'jenis_denda' => $jenis_denda,
                'keterangan_denda' => $keterangan_denda,
                'jumlah_denda_format' => number_format($jumlah_denda, 0, ',', '.')
            ]);
        }

        $_SESSION['success'] = "Denda berhasil ditambahkan dan kekurangan telah diupdate!";
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }

    header("Location: index.php?page=transaksi");
    exit;
}
?>