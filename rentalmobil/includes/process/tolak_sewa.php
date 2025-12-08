<?php
// koneksi ke database
$koneksi = new mysqli("localhost", "root", "root", "luxrental");

// cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// ambil ID transaksi dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID transaksi tidak ditemukan.");
}

$id_transaksi = intval($_GET['id']);

// update status transaksi jadi 'batal'
$sql = "UPDATE tbl_transaksi SET status='batal' WHERE id_transaksi=?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_transaksi);

if ($stmt->execute()) {
    echo "<script>alert('Transaksi berhasil dibatalkan!');window.location='index.php?page=transaksi';</script>";
} else {
    echo "<script>alert('Gagal membatalkan transaksi.');window.location='index.php?page=transaksi';</script>";
}
?>
