<?php
// Cek apakah session sudah aktif sebelum memulai session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Koneksi database
$koneksi = new mysqli("localhost", "root", "root", "luxrental");

// Cek koneksi
if ($koneksi->connect_errno) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Cek apakah parameter nik ada
if (isset($_GET['nik'])) {
    $nik = $koneksi->real_escape_string($_GET['nik']);
    
    try {
        // Cek apakah member memiliki transaksi
        $query_cek_transaksi = "SELECT COUNT(*) as total FROM tbl_transaksi WHERE nik = '$nik'";
        $result_cek = $koneksi->query($query_cek_transaksi);
        
        if (!$result_cek) {
            throw new Exception("Error checking transactions: " . $koneksi->error);
        }
        
        $row_cek = $result_cek->fetch_assoc();
        
        if ($row_cek['total'] > 0) {
            // Jika ada transaksi, hapus semua data terkait terlebih dahulu
            
            // 1. Hapus data di tbl_bayar yang terkait dengan transaksi member ini
            $query_hapus_bayar = "DELETE b FROM tbl_bayar b 
                                 JOIN tbl_kembali k ON b.id_kembali = k.id_kembali 
                                 JOIN tbl_transaksi t ON k.id_transaksi = t.id_transaksi 
                                 WHERE t.nik = '$nik'";
            if (!$koneksi->query($query_hapus_bayar)) {
                throw new Exception("Error deleting payment data: " . $koneksi->error);
            }
            
            // 2. Hapus data di tbl_kembali yang terkait
            $query_hapus_kembali = "DELETE k FROM tbl_kembali k 
                                   JOIN tbl_transaksi t ON k.id_transaksi = t.id_transaksi 
                                   WHERE t.nik = '$nik'";
            if (!$koneksi->query($query_hapus_kembali)) {
                throw new Exception("Error deleting return data: " . $koneksi->error);
            }
            
            // 3. Hapus data transaksi
            $query_hapus_transaksi = "DELETE FROM tbl_transaksi WHERE nik = '$nik'";
            if (!$koneksi->query($query_hapus_transaksi)) {
                throw new Exception("Error deleting transaction data: " . $koneksi->error);
            }
        }
        
        // Cek apakah kolom foto ada di tabel sebelum mencoba mengaksesnya
        $check_column = $koneksi->query("SHOW COLUMNS FROM tbl_member LIKE 'foto'");
        if ($check_column->num_rows > 0) {
            // Ambil data foto sebelum menghapus member
            $query_foto = "SELECT foto FROM tbl_member WHERE nik = '$nik'";
            $result_foto = $koneksi->query($query_foto);
            
            if ($result_foto && $result_foto->num_rows > 0) {
                $row = $result_foto->fetch_assoc();
                $foto = $row['foto'];
                
                // Hapus file foto dari folder uploads jika ada
                if (!empty($foto) && file_exists("uploads/" . $foto)) {
                    unlink("uploads/" . $foto);
                }
            }
        }
        
        // Hapus data member
        $query_hapus_member = "DELETE FROM tbl_member WHERE nik = '$nik'";
        
        if ($koneksi->query($query_hapus_member)) {
            if ($koneksi->affected_rows > 0) {
                $_SESSION['pesan'] = "Data member berhasil dihapus";
            } else {
                $_SESSION['pesan'] = "Error: Member dengan NIK $nik tidak ditemukan";
            }
        } else {
            throw new Exception("Error deleting member: " . $koneksi->error);
        }
        
    } catch (Exception $e) {
        $_SESSION['pesan'] = "Error: " . $e->getMessage();
    }
    
    $koneksi->close();
} else {
    $_SESSION['pesan'] = "Error: NIK tidak ditemukan";
}

// Redirect kembali ke halaman kelola member
header("Location: kelola_member.php");
exit();
?>