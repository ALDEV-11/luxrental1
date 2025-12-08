<?php
// koneksi database
$koneksi = new mysqli("localhost", "root", "root", "luxrental");

// cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// ambil data berdasarkan nopol
if (isset($_GET['id'])) {
    $nopol = $_GET['id'];
    $data = $koneksi->query("SELECT * FROM tbl_mobil WHERE nopol='$nopol'")->fetch_assoc();
    if (!$data) {
        die("Data tidak ditemukan!");
    }
}

// update data
if (isset($_POST['update'])) {
    $nopol     = $_POST['nopol']; // nopol tidak bisa diubah, hanya untuk WHERE clause
    $brand     = $_POST['brand'];
    $type      = $_POST['type'];
    $tahun     = $_POST['tahun'];
    $harga     = $_POST['harga'];
    $status    = $_POST['status'];

    // cek apakah upload foto baru
    if (!empty($_FILES['foto']['name'])) {
        $fotoBaru = $_FILES['foto']['name'];
        $target_dir = "uploads/mobil/";
        $target_file = $target_dir . basename($fotoBaru);

        // hapus foto lama
        if ($data['foto'] && file_exists($target_dir . $data['foto'])) {
            unlink($target_dir . $data['foto']);
        }

        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
    } else {
        $fotoBaru = $data['foto'];
    }

    // update data mobil (nopol tidak berubah)
    $stmt = $koneksi->prepare("UPDATE tbl_mobil SET brand=?, type=?, tahun=?, harga=?, foto=?, status=? WHERE nopol=?");
    $stmt->bind_param("ssissss", $brand, $type, $tahun, $harga, $fotoBaru, $status, $nopol);
    $stmt->execute();

    echo "<script>
        alert('Data mobil berhasil diupdate!');
        window.location.href = 'index.php?page=tambah_mobil';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>LuxRental - Edit Mobil</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --luxury-black: #0a0a0a;
            --luxury-gray: #1a1a1a;
            --luxury-gold: #d4af37;
            --luxury-gold-light: #f7e98e;
            --luxury-gold-dark: #b8941f;
            --luxury-silver: #c0c0c0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--luxury-black) 0%, var(--luxury-gray) 100%);
            color: var(--luxury-silver);
            min-height: 100vh;
            padding: 40px 20px;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        .container {
            max-width: 800px;
            position: relative;
            z-index: 1;
        }
        
        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }
        
        .edit-card {
            background: rgba(26, 26, 26, 0.98);
            backdrop-filter: blur(10px);
            border: 2px solid var(--luxury-gold);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.3);
        }
        
        .edit-card h2 {
            color: var(--luxury-gold);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
        }
        
        .edit-card h2 i {
            margin-right: 10px;
        }
        
        .form-label {
            color: var(--luxury-gold);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid var(--luxury-gold);
            padding: 12px 18px;
            transition: all 0.3s ease;
            background: rgba(10, 10, 10, 0.6);
            color: var(--luxury-silver);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--luxury-gold-light);
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
            background: rgba(26, 26, 26, 0.8);
            color: var(--luxury-gold);
        }
        
        .form-control::placeholder {
            color: rgba(192, 192, 192, 0.5);
        }
        
        .form-select option {
            background: var(--luxury-gray);
            color: var(--luxury-silver);
        }
        
        .preview-image {
            border: 2px solid var(--luxury-gold);
            border-radius: 15px;
            padding: 10px;
            background: rgba(10, 10, 10, 0.4);
            display: inline-block;
            margin-bottom: 15px;
        }
        
        .preview-image img {
            border-radius: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--luxury-gold), var(--luxury-gold-light));
            border: 2px solid var(--luxury-gold);
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: var(--luxury-black);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(212, 175, 55, 0.5);
            background: linear-gradient(135deg, var(--luxury-black), var(--luxury-gray));
            color: var(--luxury-gold);
        }
        
        .btn-secondary {
            background: transparent;
            border: 2px solid var(--luxury-gold);
            color: var(--luxury-gold);
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: var(--luxury-gold);
            color: var(--luxury-black);
            transform: translateY(-3px);
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--luxury-gray);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--luxury-gold) 0%, var(--luxury-gold-dark) 100%);
            border-radius: 10px;
            border: 2px solid var(--luxury-gray);
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--luxury-gold-light) 0%, var(--luxury-gold) 100%);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="edit-card">
        <h2><i class="fas fa-edit"></i> Edit Mobil</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-id-card"></i> Nomor Polisi</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($data['nopol']) ?>" disabled 
                       style="background-color: rgba(212, 175, 55, 0.1); cursor: not-allowed;">
                <input type="hidden" name="nopol" value="<?= htmlspecialchars($data['nopol']) ?>">
                <small style="color: #ffd700 !important; opacity: 1; font-size: 0.9rem; font-weight: 500; display: block; margin-top: 5px;">
                    <i class="fas fa-lock"></i> Nomor polisi tidak dapat diubah
                </small>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-tag"></i> Brand</label>
                <input type="text" name="brand" class="form-control" value="<?= htmlspecialchars($data['brand']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-car"></i> Tipe Mobil</label>
                <select name="type" class="form-select" required>
                    <option value="">-- Pilih Tipe Mobil --</option>
                    <option value="Sedan" <?= $data['type'] == 'Sedan' ? 'selected' : '' ?>>Sedan</option>
                    <option value="SUV" <?= $data['type'] == 'SUV' ? 'selected' : '' ?>>SUV</option>
                    <option value="MPV" <?= $data['type'] == 'MPV' ? 'selected' : '' ?>>MPV</option>
                    <option value="Hatchback" <?= $data['type'] == 'Hatchback' ? 'selected' : '' ?>>Hatchback</option>
                    <option value="Sport" <?= $data['type'] == 'Sport' ? 'selected' : '' ?>>Sport</option>
                    <option value="Pickup" <?= $data['type'] == 'Pickup' ? 'selected' : '' ?>>Pickup</option>
                    <option value="Van" <?= $data['type'] == 'Van' ? 'selected' : '' ?>>Van</option>
                    <option value="Lainnya" <?= $data['type'] == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-calendar"></i> Tahun</label>
                <input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars($data['tahun']) ?>" required min="1900" max="2100">
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-money-bill-wave"></i> Harga (Rp / Hari)</label>
                <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($data['harga']) ?>" required step="0.01" min="0">
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-image"></i> Foto</label><br>
                <div class="preview-image">
                    <img src="uploads/mobil/<?= htmlspecialchars($data['foto']) ?>" width="200" class="mb-2">
                </div>
                <input type="file" name="foto" class="form-control" accept="image/*">
                <small class="text-muted" style="color: var(--luxury-silver); opacity: 0.7;">Biarkan kosong jika tidak ingin mengubah foto</small>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-toggle-on"></i> Status</label>
                <select name="status" class="form-select" required>
                    <option value="tersedia" <?= $data['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                    <option value="tidak" <?= $data['status'] == 'tidak' ? 'selected' : '' ?>>Tidak Tersedia</option>
                </select>
            </div>
            <div class="button-group">
                <button type="submit" name="update" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="index.php?page=tambah_mobil" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
