<?php
session_start();

// Cek apakah user adalah admin atau petugas
if(!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("Location: ../../landing.php");
    exit;
}

// Koneksi database
$koneksi = new mysqli("localhost", "root", "root", "luxrental");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Cek apakah ada parameter nik
if(isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    
    // Update status member menjadi aktif
    $sql = "UPDATE tbl_member SET is_active = 1 WHERE nik = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $nik);
    
    if($stmt->execute()) {
        echo "<script>
                alert('Member berhasil diaktifkan kembali!');
                window.location.href = 'index.php?page=member_nonaktif';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengaktifkan member!');
                window.location.href = 'index.php?page=member_nonaktif';
              </script>";
    }
    
    $stmt->close();
} else {
    echo "<script>
            alert('NIK tidak ditemukan!');
            window.location.href = 'index.php?page=member_nonaktif';
          </script>";
}

$koneksi->close();
?>
