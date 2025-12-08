<?php
include __DIR__ . "/../../config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_transaksi'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    // Ambil data transaksi
    $q = mysqli_query($koneksi, "SELECT kekurangan, downpayment FROM tbl_transaksi WHERE id_transaksi='$id'");
    $data = mysqli_fetch_assoc($q);

    if ($data) {
        $kekurangan_baru = $data['kekurangan'] - $jumlah_bayar;
        if ($kekurangan_baru < 0) $kekurangan_baru = 0;

        $dp_baru = $data['downpayment'] + $jumlah_bayar;

        // Update tabel transaksi
        mysqli_query($koneksi, "UPDATE tbl_transaksi 
                                SET downpayment='$dp_baru', 
                                    kekurangan='$kekurangan_baru' 
                                WHERE id_transaksi='$id'");

        echo "<script>alert('Pembayaran berhasil!'); window.location='bayar.php';</script>";
    } else {
        echo "<script>alert('Transaksi tidak ditemukan'); window.location='bayar.php';</script>";
    }
}
?>
