<?php
$conn = new mysqli("localhost", "root", "root", "luxrental");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data
$nama_mobil = $_POST['nama_mobil'];
$harga = $_POST['harga'];
$status = $_POST['status'];

// Upload foto
$foto = $_FILES['foto']['name'];
$tmp_name = $_FILES['foto']['tmp_name'];
$folder = "uploads/";

if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

move_uploaded_file($tmp_name, $folder . $foto);

// Simpan ke database
$sql = "INSERT INTO tbl_mobil (nama_mobil, harga, status, foto) 
        VALUES ('$nama_mobil', '$harga', '$status', '$foto')";
if ($conn->query($sql) === TRUE) {
    header("Location: daftar_mobil.php");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
