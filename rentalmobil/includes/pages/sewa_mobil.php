<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "root", "luxrental");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data mobil yang tersedia
$sql = "SELECT * FROM tbl_mobil WHERE status='tersedia' ORDER BY brand ASC";
$result = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Sewa Mobil - LuxRental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 <style>
        :root {
            --luxury-black: #0a0a0a;
            --luxury-gray: #1a1a1a;
            --luxury-gold: #d4af37;
            --luxury-gold-light: #f7e98e;
            --luxury-silver: #c0c0c0;
            --luxury-white: #ffffff;
        }
        
        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding-bottom: 30px;
        }
        
        .page-header {
            text-align: center;
            margin: 40px 0;
            position: relative;
        }
        
        .page-header h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--luxury-gold) !important;
            font-size: 2.8rem;
            text-shadow: 0 2px 10px rgba(212, 175, 55, 0.3);
            display: inline-block;
            padding: 0 20px;
            letter-spacing: 1px;
        }
        
        .page-header::before, .page-header::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 30%;
            height: 2px;
            background: linear-gradient(to right, transparent, var(--luxury-gold), transparent);
        }
        
        .page-header::before {
            left: 0;
        }
        
        .page-header::after {
            right: 0;
        }
        
        .card {
            border: 2px solid var(--luxury-gold);
            border-radius: 15px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            background: rgba(26, 26, 26, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.1);
            height: 100%;
            position: relative;
        }
        
        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, var(--luxury-gold), var(--luxury-gold-light), var(--luxury-gold));
        }
        
        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.3);
            border-color: var(--luxury-gold-light);
        }
        
        .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .card:hover .card-img-top {
            transform: scale(1.05);
        }
        
        .card-body {
            padding: 1.5rem;
            position: relative;
            z-index: 1;
            background: transparent;
        }
        
        .card-title {
            font-size: 1.4rem;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--luxury-gold) !important;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card-title i {
            color: var(--luxury-gold);
            font-size: 1.2rem;
        }
        
        .card-text {
            color: var(--luxury-silver) !important;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .card-text strong {
            color: var(--luxury-gold-light);
        }
        
        .price-tag {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--luxury-gold);
            margin: 15px 0;
            text-shadow: 0 2px 8px rgba(212, 175, 55, 0.4);
        }
        
        .card-footer {
            background: transparent;
            border-top: 1px solid rgba(212, 175, 55, 0.3);
            padding: 1rem 1.5rem;
            backdrop-filter: blur(5px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, #c9a532 100%);
            border: 2px solid var(--luxury-gold);
            border-radius: 25px;
            padding: 12px 24px;
            font-weight: 700;
            color: var(--luxury-black);
            transition: all 0.3s ease;
            width: 100%;
            box-shadow: 0 4px 10px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
        
        .btn-primary::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(247, 233, 142, 0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.5);
            background: linear-gradient(135deg, var(--luxury-gold-light) 0%, var(--luxury-gold) 100%);
            border-color: var(--luxury-gold-light);
            color: var(--luxury-black);
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        /* Modal styling with fixed z-index */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.8) !important;
            z-index: 1040 !important;
            pointer-events: auto !important;
        }
        
        .modal {
            z-index: 1055 !important;
            pointer-events: auto !important;
        }
        
        .modal-dialog {
            z-index: 1056 !important;
            pointer-events: auto !important;
        }
        
        .modal-content {
            border-radius: 15px;
            border: 2px solid var(--luxury-gold);
            box-shadow: 0 20px 60px rgba(212, 175, 55, 0.3);
            overflow: hidden;
            background: var(--luxury-gray);
            z-index: 1057 !important;
            pointer-events: auto !important;
        }
        
        .modal-content * {
            pointer-events: auto !important;
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--luxury-black) 0%, var(--luxury-gray) 100%);
            color: var(--luxury-gold);
            border-bottom: 2px solid var(--luxury-gold);
            padding: 1.5rem;
        }
        
        .modal-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--luxury-gold) !important;
        }
        
        .modal-body {
            padding: 2rem;
            background: var(--luxury-gray);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--luxury-gold-light);
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 15px;
            border: 2px solid rgba(212, 175, 55, 0.3);
            transition: all 0.3s ease;
            background: rgba(10, 10, 10, 0.5);
            color: var(--luxury-white);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--luxury-gold);
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
            background: rgba(10, 10, 10, 0.7);
            color: var(--luxury-white);
        }
        
        .dp-field {
            background-color: rgba(212, 175, 55, 0.1);
            font-weight: 600;
            color: var(--luxury-gold);
        }
        
        .modal-footer {
            border-top: 2px solid rgba(212, 175, 55, 0.3);
            padding: 1.5rem;
            background: var(--luxury-gray);
        }
        
        .btn-secondary {
            background: rgba(108, 117, 125, 0.2);
            border: 2px solid var(--luxury-silver);
            color: var(--luxury-silver);
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: var(--luxury-silver);
            color: var(--luxury-black);
            transform: translateY(-2px);
            border-color: var(--luxury-white);
        }
        
        .no-cars-message {
            text-align: center;
            padding: 60px 20px;
            color: var(--luxury-silver);
        }
        
        .no-cars-message i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: rgba(212, 175, 55, 0.3);
        }
        
        .no-cars-message h3 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--luxury-gold);
        }
        
        .car-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, var(--luxury-gold) 0%, #c9a532 100%);
            color: var(--luxury-black);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            z-index: 2;
            box-shadow: 0 4px 8px rgba(212, 175, 55, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        @media (max-width: 768px) {
            .page-header h2 {
                font-size: 2rem;
            }
            
            .page-header::before, .page-header::after {
                width: 20%;
            }
            
            .card:hover {
                transform: translateY(-5px);
            }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="page-header">
        <h2><i class="fas fa-crown"></i> Koleksi Mobil Premium <i class="fas fa-crown"></i></h2>
    </div>
    
    <div class="row g-4">
        <?php
        // Koneksi ke database
        $koneksi = new mysqli("localhost", "root", "root", "luxrental");
        if ($koneksi->connect_error) {
            die("Koneksi gagal: " . $koneksi->connect_error);
        }

        // Ambil data mobil yang tersedia
        $sql = "SELECT * FROM tbl_mobil WHERE status='tersedia' ORDER BY brand ASC";
        $result = $koneksi->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Buat ID modal yang unik dan aman
                $modal_id = 'sewaModal_' . preg_replace('/[^a-zA-Z0-9]/', '_', $row['nopol']);
                ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <?php
                        $foto_path = "uploads/mobil/" . htmlspecialchars($row['foto']);
                        // Cek apakah file foto exists, jika tidak gunakan placeholder
                        if (!file_exists($foto_path) || empty($row['foto'])) {
                            $foto_path = "https://via.placeholder.com/300x200/6a11cb/ffffff?text=" . urlencode($row['brand']);
                        }
                        ?>
                        <img src="<?php echo $foto_path; ?>" class="card-img-top" style="height: 200px; object-fit: cover;" 
                             alt="<?php echo htmlspecialchars($row['brand'] . ' ' . $row['type']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['brand']) . " " . htmlspecialchars($row['type']); ?></h5>
                            <p class="card-text mb-1"><strong>No. Polisi:</strong> <?php echo htmlspecialchars($row['nopol']); ?></p>
                            <p class="card-text mb-1"><strong>Tahun:</strong> <?php echo htmlspecialchars($row['tahun']); ?></p>
                            <p class="card-text text-success fw-bold">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>/hari</p>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-primary btn-sewa" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#<?php echo $modal_id; ?>"
                                    data-harga="<?php echo $row['harga']; ?>"
                                    data-nopol="<?php echo htmlspecialchars($row['nopol']); ?>">
                                <i class="fas fa-key"></i> Sewa Sekarang
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Konfirmasi Sewa -->
                <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="post" action="proses_sewa.php" class="form-sewa">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-crown"></i> Sewa Mobil - <?php echo htmlspecialchars($row['brand']); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="nopol" value="<?php echo htmlspecialchars($row['nopol']); ?>">
                                    <input type="hidden" name="harga" value="<?php echo $row['harga']; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Ambil</label>
                                        <input type="date" name="tgl_ambil" class="form-control tgl-ambil" required min="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Kembali</label>
                                        <input type="date" name="tgl_kembali" class="form-control tgl-kembali" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Supir</label>
                                        <select name="supir" class="form-select" required>
                                            <option value="0">Tanpa Supir</option>
                                            <option value="1">Pakai Supir (+Rp 100.000/hari)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Downpayment (DP) <small class="text-muted">(30% dari total biaya)</small></label>
                                        <input type="number" name="downpayment" class="form-control dp-field" readonly required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="sewa" class="btn btn-primary"><i class="fas fa-check-circle"></i> Konfirmasi Sewa</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="col-12">
                    <div class="no-cars-message">
                        <i class="fas fa-crown"></i>
                        <h3>Armada Sedang Tidak Tersedia</h3>
                        <p>Maaf, saat ini semua kendaraan mewah kami sedang disewa. Silakan hubungi customer service untuk informasi ketersediaan.</p>
                    </div>
                  </div>';
        }
        $koneksi->close();
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Fungsi untuk menghitung DP
    function hitungDP(modal) {
        const harga = parseInt(modal.querySelector('input[name="harga"]').value);
        const ambilInput = modal.querySelector('.tgl-ambil');
        const kembaliInput = modal.querySelector('.tgl-kembali');
        const dpField = modal.querySelector('.dp-field');
        const supirSelect = modal.querySelector('select[name="supir"]');
        
        if (ambilInput.value && kembaliInput.value) {
            const tglAmbil = new Date(ambilInput.value);
            const tglKembali = new Date(kembaliInput.value);
            
            // Validasi tanggal
            if (tglKembali <= tglAmbil) {
                dpField.value = "";
                alert("Tanggal kembali harus setelah tanggal ambil!");
                return;
            }
            
            const lama = Math.ceil((tglKembali - tglAmbil) / (1000 * 60 * 60 * 24));
            
            if (lama > 0) {
                let total = harga * lama;
                
                // Tambah biaya supir jika dipilih
                if (supirSelect.value === "1") {
                    total += 100000 * lama;
                }
                
                const dp = Math.floor(total * 0.3); // 30%
                dpField.value = dp;
            } else {
                dpField.value = "";
            }
        }
    }
    
    // Event listener untuk semua modal
    document.querySelectorAll('.modal').forEach(modal => {
        const ambilInput = modal.querySelector('.tgl-ambil');
        const kembaliInput = modal.querySelector('.tgl-kembali');
        const supirSelect = modal.querySelector('select[name="supir"]');
        
        if (ambilInput) {
            ambilInput.addEventListener('change', function() {
                // Set min date untuk tanggal kembali
                const kembaliInput = this.closest('.modal').querySelector('.tgl-kembali');
                if (kembaliInput) {
                    kembaliInput.min = this.value;
                }
                hitungDP(modal);
            });
        }
        
        if (kembaliInput) {
            kembaliInput.addEventListener('change', () => hitungDP(modal));
        }
        
        if (supirSelect) {
            supirSelect.addEventListener('change', () => hitungDP(modal));
        }
    });
    
    // Validasi form sebelum submit
    document.querySelectorAll('.form-sewa').forEach(form => {
        form.addEventListener('submit', function(e) {
            const dpField = this.querySelector('.dp-field');
            if (!dpField.value || dpField.value === "") {
                e.preventDefault();
                alert("Silakan pilih tanggal ambil dan tanggal kembali terlebih dahulu!");
            }
        });
    });
});
</script>

</body>
</html>