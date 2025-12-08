<?php
include __DIR__ . "/../../config/koneksi.php";

// misalnya ambil nik dari session
if (!isset($_SESSION['nik'])) {
    echo "<script>alert('Silakan login dulu!'); window.location='login.php';</script>";
    exit;
}

$nik = $_SESSION['nik'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>LuxRental - Riwayat Transaksi</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* LuxRental Luxury Theme */
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
            min-height: 100vh;
            padding: 30px 20px;
            color: var(--luxury-silver);
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
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 50px 30px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.95) 0%, rgba(247, 233, 142, 0.95) 100%);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .page-header h1 {
            font-size: 36px;
            font-weight: 800;
            color: var(--luxury-black);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            position: relative;
        }
        
        .page-header h1 i {
            font-size: 42px;
            color: var(--luxury-black);
            animation: bounce 2s ease-in-out infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .page-header p {
            font-size: 16px;
            color: rgba(10, 10, 10, 0.7);
            font-weight: 500;
            position: relative;
        }
        
        /* Tabs */
        .tabs-container {
            background: rgba(26, 26, 26, 0.95);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(212, 175, 55, 0.2);
            margin-bottom: 40px;
            border: 2px solid var(--luxury-gold);
            backdrop-filter: blur(10px);
        }
        
        .tab-buttons {
            display: flex;
            background: linear-gradient(to bottom, rgba(10, 10, 10, 0.8) 0%, rgba(26, 26, 26, 0.8) 100%);
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
            padding: 20px 25px 0;
            flex-wrap: wrap;
        }
        
        .tab-buttons button {
            padding: 14px 28px;
            cursor: pointer;
            border: 2px solid transparent;
            background: transparent;
            font-weight: 600;
            color: var(--luxury-silver);
            transition: all 0.3s ease;
            position: relative;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 12px 12px 0 0;
            font-family: 'Inter', sans-serif;
        }
        
        .tab-buttons button:hover {
            color: var(--luxury-gold);
            background: rgba(212, 175, 55, 0.1);
        }
        
        .tab-buttons button.active {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            color: var(--luxury-black);
            font-weight: 700;
            border-color: var(--luxury-gold);
            box-shadow: 0 -4px 20px rgba(212, 175, 55, 0.4);
        }
        
        /* Content */
        .tab-content {
            display: none;
            padding: 30px;
            animation: fadeIn 0.4s ease-in-out;
            background: rgba(10, 10, 10, 0.4);
        }
        
        .tab-content.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .tab-title {
            font-size: 24px;
            margin-bottom: 25px;
            color: var(--luxury-gold);
            text-align: center;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-family: 'Playfair Display', serif;
        }
        
        .tab-title i {
            color: var(--luxury-gold);
            font-size: 28px;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            background: rgba(26, 26, 26, 0.6);
            border: 2px solid var(--luxury-gold);
        }
        
        .table-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-container::-webkit-scrollbar-track {
            background: rgba(10, 10, 10, 0.5);
            border-radius: 10px;
        }
        
        .table-container::-webkit-scrollbar-thumb {
            background: var(--luxury-gold);
            border-radius: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
            background: transparent;
        }
        
        thead {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            color: var(--luxury-black);
        }
        
        th {
            padding: 16px 15px;
            text-align: center;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-family: 'Inter', sans-serif;
        }
        
        tbody tr {
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            transition: all 0.3s ease;
        }
        
        tbody tr:hover {
            background: rgba(212, 175, 55, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
        }
        
        td {
            padding: 16px 15px;
            text-align: center;
            color: var(--luxury-silver);
            font-size: 14px;
        }
        
        .no-data {
            text-align: center;
            padding: 50px;
            color: rgba(192, 192, 192, 0.5);
            font-style: italic;
            font-size: 16px;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 8px 18px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 2px solid;
        }
        
        .status-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }
        
        .status-waiting {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.2) 0%, rgba(245, 158, 11, 0.2) 100%);
            color: #fbbf24;
            border-color: #fbbf24;
        }
        
        .status-waiting::before {
            background: #fbbf24;
        }
        
        .status-approved {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.2) 100%);
            color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .status-approved::before {
            background: #3b82f6;
        }
        
        .status-taken {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.2) 100%);
            color: #10b981;
            border-color: #10b981;
        }
        
        .status-taken::before {
            background: #10b981;
        }
        
        .status-returned {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2) 0%, rgba(247, 233, 142, 0.2) 100%);
            color: var(--luxury-gold);
            border-color: var(--luxury-gold);
        }
        
        .status-returned::before {
            background: var(--luxury-gold);
        }
        
        .status-rejected {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(220, 38, 38, 0.2) 100%);
            color: #ef4444;
            border-color: #ef4444;
        }
        
        .status-rejected::before {
            background: #ef4444;
        }
        
        /* Button */
        .btn {
            padding: 9px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            border: 2px solid;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            color: var(--luxury-black);
            border-color: var(--luxury-gold);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--luxury-gold-light) 0%, var(--luxury-gold) 100%);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-color: #10b981;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border-color: #f59e0b;
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border-color: #ef4444;
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            border-color: #6b7280;
        }
        
        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            box-shadow: 0 8px 25px rgba(107, 114, 128, 0.4);
            transform: translateY(-2px);
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .action-buttons .btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            font-size: 13px;
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1040;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            padding: 20px;
            animation: fadeIn 0.3s ease-in-out;
            pointer-events: auto;
        }
        
        .modal-content {
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.98) 0%, rgba(10, 10, 10, 0.98) 100%);
            margin: 5% auto;
            padding: 35px;
            width: 520px;
            max-width: 90%;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: slideIn 0.4s ease-in-out;
            border: 2px solid var(--luxury-gold);
            position: relative;
            z-index: 1055;
            pointer-events: auto;
        }
        
        @keyframes slideIn {
            from { transform: translateY(-40px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
        }
        
        .modal-header h3 {
            color: var(--luxury-gold);
            font-size: 26px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        
        .close-modal {
            background: rgba(212, 175, 55, 0.2);
            border: 2px solid var(--luxury-gold);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 24px;
            color: var(--luxury-gold);
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .close-modal:hover {
            background: var(--luxury-gold);
            color: var(--luxury-black);
            transform: rotate(90deg);
        }
        
        .form-group {
            margin-bottom: 22px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--luxury-gold);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
        }
        
        .form-group select, 
        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: rgba(10, 10, 10, 0.6);
            color: var(--luxury-silver);
            font-family: 'Inter', sans-serif;
        }
        
        .form-group select:focus, 
        .form-group input:focus, 
        .form-group textarea:focus {
            outline: none;
            border-color: var(--luxury-gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
            background: rgba(26, 26, 26, 0.8);
            color: var(--luxury-gold-light);
        }
        
        .form-group textarea {
            resize: none;
            min-height: 90px;
        }
        
        .form-group select option {
            background: var(--luxury-gray);
            color: var(--luxury-silver);
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 28px;
        }
        
        .form-actions .btn {
            flex: 1;
            text-align: center;
            padding: 14px;
            font-size: 15px;
        }
        
        .denda-section {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(247, 233, 142, 0.15) 100%);
            padding: 18px;
            border-radius: 12px;
            margin-top: 12px;
            border-left: 4px solid var(--luxury-gold);
            border: 2px solid rgba(212, 175, 55, 0.3);
        }
        
        .denda-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: var(--luxury-silver);
            font-size: 14px;
        }
        
        .denda-label {
            font-weight: 500;
        }
        
        .denda-value {
            font-weight: 600;
            color: var(--luxury-gold-light);
        }
        
        .denda-total {
            font-weight: 700;
            font-size: 18px;
            border-top: 2px solid rgba(212, 175, 55, 0.3);
            padding-top: 12px;
            margin-top: 12px;
            display: flex;
            justify-content: space-between;
            color: var(--luxury-gold);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(10, 10, 10, 0.5);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--luxury-gold-light) 0%, var(--luxury-gold) 100%);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
            }
            
            .page-header {
                padding: 35px 20px;
            }
            
            .page-header h1 {
                font-size: 26px;
            }
            
            .tab-buttons {
                padding: 15px 18px 0;
            }
            
            .tab-buttons button {
                padding: 12px 20px;
                font-size: 13px;
            }
            
            .tab-content {
                padding: 22px 18px;
            }
            
            th, td {
                padding: 12px 10px;
                font-size: 13px;
            }
            
            .modal-content {
                padding: 28px;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 15px 10px;
            }
            
            .page-header {
                padding: 25px 15px;
            }
            
            .page-header h1 {
                font-size: 22px;
            }
            
            .tab-buttons {
                flex-direction: column;
            }
            
            .tab-buttons button {
                justify-content: center;
                width: 100%;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .modal-content {
                padding: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-crown"></i> Riwayat Transaksi LuxRental</h1>
            <p>Kelola dan pantau semua transaksi rental mobil premium Anda di satu tempat</p>
        </div>

        <div class="tabs-container">
            <div class="tab-buttons">
                <button class="active" data-tab="booking" onclick="showTab('booking')">
                    <i class="fas fa-clipboard-list"></i> Booking
                </button>
                <button data-tab="aprove" onclick="showTab('aprove')">
                    <i class="fas fa-check-circle"></i> Aprove
                </button>
                <button data-tab="ambil" onclick="showTab('ambil')">
                    <i class="fas fa-car"></i> Ambil
                </button>
                <button data-tab="kembali" onclick="showTab('kembali')">
                    <i class="fas fa-undo-alt"></i> Kembali
                </button>
                <button data-tab="ditolak" onclick="showTab('ditolak')">
                    <i class="fas fa-times-circle"></i> Ditolak
                </button>
            </div>

            <?php
            // Koneksi database dan sesi harus sudah di-include di file ini
            // include "koneksi.php";
            
            // misalnya ambil nik dari session
            if (!isset($_SESSION['nik'])) {
                echo "<script>alert('Silakan login dulu!'); window.location='login.php';</script>";
                exit;
            }

            $nik = $_SESSION['nik'];
            
            $statusList = ["booking", "aprove", "ambil", "kembali", "ditolak"];
            foreach ($statusList as $status) {
                $sql = "
                    SELECT 
                        t.id_transaksi, 
                        mb.nopol, 
                        t.tgl_booking, 
                        t.tgl_ambil, 
                        t.tgl_kembali, 
                        t.supir, 
                        t.total, 
                        t.downpayment, 
                        t.kekurangan
                    FROM tbl_transaksi t
                    JOIN tbl_mobil mb ON t.nopol = mb.nopol
                    WHERE t.status = :status AND t.nik = :nik
                    ORDER BY t.id_transaksi DESC
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['status' => $status, 'nik' => $nik]);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div id="<?= $status ?>" class="tab-content <?= $status == 'booking' ? 'active' : '' ?>">
                <h3 class="tab-title">
                    <i class="fas fa-list-alt"></i>
                    Data Transaksi - <?= ucfirst($status) ?>
                </h3>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nopol</th>
                                <th>Tgl Booking</th>
                                <th>Tgl Ambil</th>
                                <th>Tgl Kembali</th>
                                <th>Supir</th>
                                <th>Total</th>
                                <th>DP</th>
                                <th>Kekurangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($rows) > 0) {
                                foreach ($rows as $row) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nopol']) ?></td>
                                    <td><?= htmlspecialchars($row['tgl_booking']) ?></td>
                                    <td><?= htmlspecialchars($row['tgl_ambil']) ?></td>
                                    <td><?= htmlspecialchars($row['tgl_kembali']) ?></td>
                                    <td><?= $row['supir'] ? "Ya" : "Tidak" ?></td>
                                    <td>Rp <?= number_format($row['total'],0,',','.') ?></td>
                                    <td>Rp <?= number_format($row['downpayment'],0,',','.') ?></td>
                                    <td>Rp <?= number_format($row['kekurangan'],0,',','.') ?></td>
                                    <td>
                                        <?php if ($status == 'booking') { ?>
                                            <span class="status-badge status-waiting">Menunggu Approve</span>
                                        <?php } elseif ($status == 'aprove') { ?>
                                            <a class="btn btn-primary" href="proses_ambil.php?id=<?= $row['id_transaksi'] ?>">
                                                <i class="fas fa-car"></i> Ambil Mobil
                                            </a>
                                        <?php } elseif ($status == 'ambil') { ?>
                                            <button class="btn btn-success" 
                                                onclick="openModal(<?= $row['id_transaksi'] ?>, '<?= $row['tgl_kembali'] ?>')">
                                                <i class="fas fa-undo-alt"></i> Kembalikan
                                            </button>
                                        <?php } elseif ($status == 'kembali') { ?>
                                                <?php if ($row['kekurangan'] > 0) { ?>
                                                    <a class="btn btn-warning" href="proses_bayar.php?id=<?= $row['id_transaksi'] ?>">
                                                        <i class="fas fa-money-bill-wave"></i> Bayar Lunas
                                                    </a>
                                                <?php } else { ?>
                                                    <span class="status-badge status-returned">Lunas & Dikembalikan</span>
                                                <?php } ?>
                                        <?php } elseif ($status == 'ditolak') { ?>
                                            <span class="status-badge status-rejected">Tidak Disetujui</span>
                                        <?php } else { ?>
                                            <span>-</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } } else { ?>
                                <tr><td colspan="9" class="no-data">Tidak ada data transaksi</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- Modal untuk kembalikan mobil -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-undo-alt"></i> Kembalikan Mobil</h3>
                <button class="close-modal" onclick="closeModal()">×</button>
            </div>
            <div class="modal-body">
                <form action="proses_kembali.php" method="POST">
                    <input type="hidden" name="id_transaksi" id="id_transaksi">
                    <input type="hidden" name="tgl_kembali" id="tgl_kembali">
                    
                    <div class="form-group">
                        <label for="kondisi_mobil"><i class="fas fa-clipboard-check"></i> Kondisi Mobil</label>
                        <select name="kondisi_mobil" id="kondisi_mobil" onchange="hitungDenda()" required>
                            <option value="">-- Pilih Kondisi Mobil --</option>
                            <option value="Baik">Baik (Tidak ada kerusakan)</option>
                            <option value="Lecet">Lecet Ringan</option>
                            <option value="Rusak Sedang">Rusak Sedang</option>
                            <option value="Rusak Parah">Rusak Parah</option>
                            <option value="Hilang">Hilang / Komponen Hilang</option>
                        </select>
                    </div>
                    
                    <div class="denda-section">
                        <div class="denda-item">
                            <span class="denda-label"><i class="fas fa-wrench"></i> Denda Kerusakan:</span>
                            <span class="denda-value" id="denda_kerusakan_text">Rp 0</span>
                        </div>
                        <div class="denda-item">
                            <span class="denda-label"><i class="fas fa-clock"></i> Denda Keterlambatan:</span>
                            <span class="denda-value" id="denda_telat_text">Rp 0</span>
                        </div>
                        <div class="denda-total">
                            <span><i class="fas fa-calculator"></i> Total Denda:</span>
                            <span id="denda_total_text">Rp 0</span>
                        </div>
                    </div>
                    
                    <!-- Input tersembunyi untuk nilai denda -->
                    <input type="hidden" name="denda" id="denda" value="0">
                    
                    <div class="form-group">
                        <label for="keterangan"><i class="fas fa-comment-alt"></i> Keterangan Tambahan</label>
                        <textarea name="keterangan" placeholder="Jelaskan kondisi mobil secara detail..." rows="3"></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Konfirmasi Pengembalian
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            document.querySelectorAll(".tab-content").forEach(el => el.classList.remove("active"));
            document.querySelectorAll(".tab-buttons button").forEach(el => el.classList.remove("active"));
            document.getElementById(tabId).classList.add("active");
            document.querySelector(`[data-tab='${tabId}']`).classList.add("active");
        }

        function openModal(idTransaksi, tglKembali) {
            document.getElementById("modal").style.display = "block";
            document.getElementById("id_transaksi").value = idTransaksi;
            document.getElementById("tgl_kembali").value = tglKembali;
            
            // Reset form ketika modal dibuka
            document.getElementById("kondisi_mobil").selectedIndex = 0;
            document.querySelector("textarea[name='keterangan']").value = "";
            
            hitungDenda();
        }

        function closeModal() {
            document.getElementById("modal").style.display = "none";
        }

        // Tutup modal ketika klik di luar konten modal
        window.onclick = function(event) {
            const modal = document.getElementById("modal");
            if (event.target === modal) {
                closeModal();
            }
        }

        function hitungDenda() {
            let kondisi = document.getElementById("kondisi_mobil").value;
            let dendaKerusakanText = document.getElementById("denda_kerusakan_text");
            let dendaTelatText = document.getElementById("denda_telat_text");
            let dendaTotalText = document.getElementById("denda_total_text");
            let dendaTotalField = document.getElementById("denda");

            let dendaKerusakan = 0;
            let dendaTelat = 0;
            let dendaPerHari = 100000;

            // Denda berdasarkan kondisi mobil
            switch (kondisi) {
                case "Baik": dendaKerusakan = 0; break;
                case "Lecet": dendaKerusakan = 200000; break;
                case "Rusak Sedang": dendaKerusakan = 500000; break;
                case "Rusak Parah": dendaKerusakan = 1000000; break;
                case "Hilang": dendaKerusakan = 5000000; break;
                default: dendaKerusakan = 0;
            }

            // Hitung denda keterlambatan
            let tglKembali = document.getElementById("tgl_kembali").value;
            if (tglKembali) {
                let tglTarget = new Date(tglKembali);
                let tglHariIni = new Date();
                tglTarget.setHours(0,0,0,0);
                tglHariIni.setHours(0,0,0,0);

                let selisihHari = Math.floor((tglHariIni - tglTarget) / (1000 * 60 * 60 * 24));
                if (selisihHari > 0) {
                    dendaTelat = selisihHari * dendaPerHari;
                }
            }

            let totalDenda = dendaKerusakan + dendaTelat;
            
            // Format angka ke Rupiah
            function formatRupiah(angka) {
                return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            
            // Update tampilan
            dendaKerusakanText.textContent = formatRupiah(dendaKerusakan);
            dendaTelatText.textContent = formatRupiah(dendaTelat);
            dendaTotalText.textContent = formatRupiah(totalDenda);
            dendaTotalField.value = totalDenda;
        }
    </script>
</body>
</html>