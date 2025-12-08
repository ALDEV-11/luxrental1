<?php
// koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "rental1");

// cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// ambil ID transaksi dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID transaksi tidak ditemukan.");
}

$id_transaksi = intval($_GET['id']);

// update status transaksi jadi 'aprove'
$sql = "UPDATE tbl_transaksi SET status='aprove' WHERE id_transaksi=?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_transaksi);

if ($stmt->execute()) {
    // ubah status mobil menjadi 'disewa'
    $sql_mobil = "UPDATE tbl_mobil 
                  SET status='disewa' 
                  WHERE nopol = (SELECT nopol FROM tbl_transaksi WHERE id_transaksi=?)";
    $stmt2 = $koneksi->prepare($sql_mobil);
    $stmt2->bind_param("i", $id_transaksi);
    $stmt2->execute();

    echo "<script>alert('Transaksi berhasil disetujui!');window.location='index.php?page=transaksi';</script>";
} else {
    echo "<script>alert('Gagal menyetujui transaksi.');window.location='index.php?page=transaksi';</script>";
}
?>
