<?php
session_start();
require __DIR__ . '/../../config/koneksi.php';

// Cek login dan role
if (!isset($_SESSION['login']) || $_SESSION['role'] === 'member') {
    header("Location: ../../landing.php");
    exit;
}

// Ambil data dari form
$nik = $_POST['nik'] ?? '';
$nama = $_POST['nama'] ?? '';
$jk = $_POST['jk'] ?? '';
$telp = $_POST['telp'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';

// Validasi input
if (empty($nik) || empty($nama) || empty($jk) || empty($telp) || empty($alamat) || empty($user) || empty($pass)) {
    echo "<script>
        alert('Semua field wajib diisi!');
        window.history.back();
    </script>";
    exit;
}

// Validasi NIK (harus 16 digit)
if (!preg_match('/^[0-9]{16}$/', $nik)) {
    echo "<script>
        alert('NIK harus 16 digit angka!');
        window.history.back();
    </script>";
    exit;
}

// Validasi username (4-20 karakter, hanya huruf, angka, underscore)
if (!preg_match('/^[a-zA-Z0-9_]{4,20}$/', $user)) {
    echo "<script>
        alert('Username harus 4-20 karakter, hanya huruf, angka, dan underscore!');
        window.history.back();
    </script>";
    exit;
}

// Validasi password minimal 6 karakter
if (strlen($pass) < 6) {
    echo "<script>
        alert('Password minimal 6 karakter!');
        window.history.back();
    </script>";
    exit;
}

try {
    // Cek apakah NIK sudah ada
    $stmt = $pdo->prepare("SELECT nik FROM tbl_member WHERE nik = ?");
    $stmt->execute([$nik]);
    if ($stmt->fetch()) {
        echo "<script>
            alert('NIK sudah terdaftar!');
            window.history.back();
        </script>";
        exit;
    }
    
    // Cek apakah username sudah ada
    $stmt = $pdo->prepare("SELECT user FROM tbl_member WHERE user = ?");
    $stmt->execute([$user]);
    if ($stmt->fetch()) {
        echo "<script>
            alert('Username sudah digunakan!');
            window.history.back();
        </script>";
        exit;
    }
    
    // Hash password
    $passHash = password_hash($pass, PASSWORD_DEFAULT);
    
    // Handle upload foto
    $fotoName = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fotoTmp = $_FILES['foto']['tmp_name'];
        $fotoOriginal = $_FILES['foto']['name'];
        $fotoExt = strtolower(pathinfo($fotoOriginal, PATHINFO_EXTENSION));
        
        // Validasi tipe file
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($fotoExt, $allowedExt)) {
            echo "<script>
                alert('Format foto tidak valid! Gunakan JPG, PNG, GIF, atau WEBP.');
                window.history.back();
            </script>";
            exit;
        }
        
        // Validasi ukuran file (max 5MB)
        if ($_FILES['foto']['size'] > 5 * 1024 * 1024) {
            echo "<script>
                alert('Ukuran foto terlalu besar! Maksimal 5MB.');
                window.history.back();
            </script>";
            exit;
        }
        
        // Generate nama file unik
        $fotoName = time() . '_' . uniqid() . '.' . $fotoExt;
        $uploadDir = 'uploads/';
        
        // Buat folder uploads jika belum ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Upload file
        if (!move_uploaded_file($fotoTmp, $uploadDir . $fotoName)) {
            echo "<script>
                alert('Gagal upload foto!');
                window.history.back();
            </script>";
            exit;
        }
    }
    
    // Insert data member baru
    $stmt = $pdo->prepare("INSERT INTO tbl_member (nik, nama, jk, telp, alamat, user, pass, foto, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)");
    $stmt->execute([$nik, $nama, $jk, $telp, $alamat, $user, $passHash, $fotoName]);
    
    echo "<script>
        alert('Member berhasil ditambahkan!');
        window.location.href = 'index.php?page=member_sewa';
    </script>";
    
} catch (PDOException $e) {
    echo "<script>
        alert('Gagal menambahkan member: " . addslashes($e->getMessage()) . "');
        window.history.back();
    </script>";
}
?>
