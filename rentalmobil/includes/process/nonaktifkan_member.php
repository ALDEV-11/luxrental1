<?php
session_start();

// Cek apakah user sudah login dan memiliki akses
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("Location: ../../landing.php");
    exit;
}

// Koneksi database
$koneksi = new mysqli("localhost", "root", "root", "luxrental");

// Cek koneksi
if ($koneksi->connect_errno) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Ambil NIK dari parameter URL
if (isset($_GET['nik'])) {
    $nik = $koneksi->real_escape_string($_GET['nik']);
    
    // Update status member menjadi tidak aktif (soft delete)
    $query = "UPDATE tbl_member SET is_active = 0 WHERE nik = '$nik'";
    
    if ($koneksi->query($query)) {
        echo "<script>
                alert('Member berhasil dinonaktifkan! Member tidak dapat login lagi.');
                window.location.href = 'index.php?page=member_sewa';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menonaktifkan member: " . $koneksi->error . "');
                window.location.href = 'index.php?page=member_sewa';
              </script>";
    }
    
    $koneksi->close();
} else {
    echo "<script>
            alert('NIK tidak ditemukan!');
            window.location.href = 'index.php?page=member_sewa';
          </script>";
}
?>