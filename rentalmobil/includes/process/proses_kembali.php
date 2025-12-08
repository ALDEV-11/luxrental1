<?php
include __DIR__ . "/../../config/koneksi.php"; // koneksi pakai $pdo
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi  = $_POST['id_transaksi'];
    $kondisi_mobil = $_POST['kondisi_mobil'];
    $keterangan    = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
    $denda_client  = isset($_POST['denda']) ? (int)$_POST['denda'] : 0; // dari JS (hidden input)

    // ambil data transaksi
    $stmt = $pdo->prepare("
        SELECT tgl_kembali, nopol, total, downpayment, kekurangan 
        FROM tbl_transaksi 
        WHERE id_transaksi = ?
    ");
    $stmt->execute([$id_transaksi]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "<script>alert('Transaksi tidak ditemukan!'); window.location='index.php?page=riwayat';</script>";
        exit;
    }

    $tgl_seharusnya = $row['tgl_kembali'];
    $nopol          = $row['nopol'];
    $total          = $row['total'];
    $dp             = $row['downpayment'];
    $kekurangan     = $row['kekurangan'];

    // ====== HITUNG DENDA SERVER SIDE ======
    $denda = 0;
    $denda_per_hari = 100000; // bisa disesuaikan

    // denda keterlambatan
    $selisih = (strtotime(date('Y-m-d')) - strtotime($tgl_seharusnya)) / (60*60*24);
    if ($selisih > 0) {
        $denda += $selisih * $denda_per_hari;
    }

    // denda kondisi mobil
    switch ($kondisi_mobil) {
        case "Lecet":
            $denda += 200000;
            break;
        case "Rusak Sedang":
            $denda += 500000;
            break;
        case "Rusak Parah":
            $denda += 1000000;
            break;
        case "Hilang":
            $denda += 5000000;
            break;
        default: // Baik
            $denda += 0;
            break;
    }

    // safety check: kalau denda client-side lebih besar → ambil itu
    if ($denda_client > $denda) {
        $denda = $denda_client;
    }

    // ====== SIMPAN KE tbl_kembali ======
    $stmt = $pdo->prepare("
        INSERT INTO tbl_kembali 
        (id_transaksi, tgl_kembali, kondisi_mobil, denda, keterangan) 
        VALUES (?, NOW(), ?, ?, ?)
    ");
    $simpan = $stmt->execute([$id_transaksi, $kondisi_mobil, $denda, $keterangan]);

    if ($simpan) {
        // update status transaksi & kekurangan
        $pdo->prepare("
            UPDATE tbl_transaksi 
            SET status = 'kembali', kekurangan = kekurangan + ? 
            WHERE id_transaksi = ?
        ")->execute([$denda, $id_transaksi]);

        // update status mobil jadi tersedia
        $pdo->prepare("
            UPDATE tbl_mobil 
            SET status = 'tersedia' 
            WHERE nopol = ?
        ")->execute([$nopol]);

        // total bayar = kekurangan lama + denda baru
        $total_bayar = $kekurangan + $denda;

        echo "<script>
            alert('Pengembalian berhasil! Anda harus melunasi kekurangan + denda sebesar Rp " . number_format($total_bayar, 0, ',', '.') . "');
            window.location='index.php?page=bayar';
        </script>";
    } else {
        echo "<script>alert('Gagal menyimpan pengembalian'); window.location='index.php?page=riwayat';</script>";
    }
} else {
    header("Location: index.php?page=riwayat");
    exit;
}
?>
