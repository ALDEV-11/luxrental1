<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "root", "luxrental");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_GET['id'])) {
    $nopol = htmlspecialchars($_GET['id']); // sanitasi sedikit

    // cek apakah mobil masih dipakai di transaksi
    $cek = $koneksi->prepare("SELECT COUNT(*) FROM tbl_transaksi WHERE nopol=?");
    $cek->bind_param("s", $nopol);
    $cek->execute();
    $cek->bind_result($jumlah);
    $cek->fetch();
    $cek->close();

    if ($jumlah > 0) {
        echo "<script>alert('Mobil tidak bisa dihapus karena masih ada transaksi!');window.location='daftar_mobil.php';</script>";
    } else {
        // ambil nama file foto
        $foto = $koneksi->prepare("SELECT foto FROM tbl_mobil WHERE nopol=?");
        $foto->bind_param("s", $nopol);
        $foto->execute();
        $foto->bind_result($nama_foto);
        $foto->fetch();
        $foto->close();

        if (!$nama_foto) {
            echo "<script>alert('Data mobil tidak ditemukan!');window.location='daftar_mobil.php';</script>";
            exit;
        }

        // hapus file foto jika ada
        $filePath = "uploads/mobil/" . $nama_foto;
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // hapus data mobil
        $sql = $koneksi->prepare("DELETE FROM tbl_mobil WHERE nopol=?");
        $sql->bind_param("s", $nopol);
        if ($sql->execute()) {
            echo "<script>alert('Mobil berhasil dihapus!');window.location='index.php?page=tambah_mobil';</script>";
        } else {
            echo "<script>alert('Gagal menghapus mobil: " . $koneksi->error . "');window.location='daftar_mobil.php';</script>";
        }
        $sql->close();
    }
}

$koneksi->close();
?>
